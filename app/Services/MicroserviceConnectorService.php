<?php

namespace App\Services;

use App\Enums\HttpStatusCode;
use App\Models\Services;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\TooManyRedirectsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Cache\TaggableStore;
use Lauthz\Facades\Enforcer;

class MicroserviceConnectorService
{
    const UNAUTHORIZED = 401;

    protected $logger;

    protected $httpClient;

    protected $cacheStore;

    private $serviceName;

    protected $cacheTags;

    public function __construct(array $tags = [], array $guzzle = [], ?string $store = null)
    {
        $this->cacheTags = $tags;
        $this->cacheStore = $store ?? \config('cache.default');
        $this->httpClient = new Client($guzzle);
        $this->logger = Log::channel('MicroserviceConnectorService');
    }

    public function execute($uri, $method = 'GET', $name = 'ServiceExecutor', $attempts = 0)
    {
        try {
            $tokens = $this->auth($name);

            $options = $this->getRequestOptions($tokens->access_token);
            logger('data', [$uri, $options]);
            $response = $this->httpClient->get($uri, $options);

            return json_decode($response->getBody(), true);
        } catch (TooManyRedirectsException $e) {
            // handle too many redirects
            $this->logger->error('TooManyRedirectsException', [$uri, $method, $name]);
        } catch (ClientException|ServerException $e) {
            // ClientException - A GuzzleHttp\Exception\ClientException is thrown for 400 level errors if the http_errors request option is set to true.
            // ServerException - A GuzzleHttp\Exception\ServerException is thrown for 500 level errors if the http_errors request option is set to true.
            $statusCode = 0;
            if ($e->hasResponse()) {
                // is HTTP status code, e.g. 500
                $statusCode = $e->getResponse()->getStatusCode();
            }
            if ($statusCode == HttpStatusCode::UNAUTHORIZED && !$attempts) {
                $this->refreshToke($name);
                $attempts++;
                return $this->execute($uri, $method = 'GET', $name, $attempts);
            }

            $this->logger->error('ClientException [' . $statusCode . '|' . $e->getMessage() . ']', [$uri, $method, $name]);
        } catch (ConnectException $e) {
            // ConnectException - A GuzzleHttp\Exception\ConnectException exception is thrown in the event of a networking error. This may be any libcurl error, including certificate problems
            $handlerContext = $e->getHandlerContext();
            if ($handlerContext['errno'] ?? 0) {
                // this is the libcurl error code, not the HTTP status code!!!
                // for example 6 for "Couldn't resolve host"
                $errno = (int)($handlerContext['errno']);
            }
            // get a description of the error (which will include a link to libcurl page)
            $errorMessage = $handlerContext['error'] ?? $e->getMessage();
            $this->logger->error('[ConnectException] ' . $errorMessage, [$handlerContext, $uri, $method, $name]);
        } catch (\Exception $e) {
            // fallback, in case of other exception
            $this->logger->error('[Exception] ' . $e->getMessage(), [$uri, $method, $name]);
        }

        return null;
    }

    protected function refreshToke($name = 'ServiceExecutor')
    {
        $model = app(Services::class);
        $method_name = 'find' . $name;
        if (!method_exists($model, $method_name)) {
            throw new \BadMethodCallException('Method ' . $method_name . ' not exist!');
        }
        $service = $model->$method_name($name);

        $serviceName = $service->name;
        $this->setServiceName($serviceName);

        $tokens = $this->serviceRefresh($serviceName);

        if (@$tokens->error) {
            $this->logger->emergency($tokens->error_description, (array)$this->cacheStore()->get($service->name));
            throw new \InvalidArgumentException($tokens->error_description);
        }

        $this->cacheStore()->put(
            $serviceName,
            $tokens,
            \now()->addSeconds($tokens->expires_in)
        );

        return $tokens;
    }


    public function auth($name = 'ServiceExecutor')
    {
        $model = app(Services::class);
        $method_name = 'find' . $name;
        if (!method_exists($model, $method_name)) {
            throw new \BadMethodCallException('Method ' . $method_name . ' not exist!');
        }
        $service = $model->$method_name($name);

        if ($service) {
            $token = $this->cacheStore()->get($service->name);
            if (!$token) {
                $this->setServiceName($service->name);
                $key = $this->getServiceName();

                $tokens = $this->serviceRegister($name);
                return $this->cacheStore()->remember(
                    $key,
                    \now()->addSeconds($tokens->expires_in),
                    function () use ($tokens) {
                        return $tokens;
                    }
                );
            }
            return $token;
        } else {
            $this->generateServiceName($name);
            $key = $this->getServiceName();
            $tokens = $this->serviceRegister($name);
            return $this->cacheStore()->remember(
                $key,
                \now()->addSeconds($tokens->expires_in),
                function () use ($tokens) {
                    return $tokens;
                }
            );
        }
    }

    private function serviceRefresh($name = 'ServiceExecutor')
    {
        $key = $this->getServiceName();

        $oldTokens = $this->cacheStore()->get($key);

        $request = app('request');
        $request->request->add([
            'grant_type'    => 'refresh_token',
            'client_id'     => config('auth.credentials.service_connector.client_id'),
            'client_secret' => config('auth.credentials.service_connector.client_secret'),
            'refresh_token' => $oldTokens->refresh_token,
        ]);
        $request->headers->set('Authorization', 'Bearer ' . $oldTokens->access_token);
        $proxy = Request::create('oauth/token', 'post');

        $res = Route::dispatch($proxy);

        return json_decode($res->getContent());
    }

    public function serviceRegister($name = 'ServiceExecutor')
    {
        $title = $this->getServiceName();

        $password = $this->generateRandomString(8);

        $service = Services::where('name', $title)->first();
        if (!$service) {
            $service = Services::create([
                'name'     => $title,
                'username' => $title,
                'password' => Hash::make($password),
            ]);
        } else {
            $service->username = $title;
            $service->password = Hash::make($password);
        }

        // Assign role `ServiceExecutionRole` to the new registered users
        if(!Enforcer::hasRoleForUser($service->id, 'ServiceExecutionRole')) {
            Enforcer::addRoleForUser($service->id, 'ServiceExecutionRole');
        }


        logger(print_r($service, true));
        $request = app('request');
        $request->request->add([
            'grant_type'    => 'password',
            'username'      => $title,
            'password'      => $password,
            'client_id'     => env('SERVICE_CONNECTOR_CLIENT_ID'),
            'client_secret' => env('SERVICE_CONNECTOR_CLIENT_SECRET'),
        ]);

        $proxy = Request::create('oauth/token', 'post');

        $res = Route::dispatch($proxy);
        return json_decode($res->getContent());
    }


    protected function getRequestOptions($token)
    {
        return [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'verify' => env('VERIFY_SSL', true)
        ];
    }

    private function generateServiceName($name = 'ServiceExecutor')
    {
        $this->serviceName = $name . '-' . $this->generateRandomString(6);
    }

    protected function setServiceName($name)
    {
        $this->serviceName = $name;
    }

    protected function getServiceName()
    {
        return $this->serviceName;
    }

    public function cacheStore(): Repository
    {
        $store = Cache::store($this->cacheStore);

        return $store->getStore() instanceof TaggableStore ? $store->tags($this->cacheTags) : $store;
    }

    private function generateRandomString(int $n = 0): string
    {
        $al = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k'
               , 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u',
               'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E',
               'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
               'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
               '0', '2', '3', '4', '5', '6', '7', '8', '9'];

        $len = !$n ? random_int(7, 12) : $n; // Chose length randomly in 7 to 12

        $ddd = array_map(function ($a) use ($al) {
            $key = random_int(0, 60);
            return $al[$key];
        }, array_fill(0, $len, 0));
        return implode('', $ddd);
    }
}
