<?php
namespace App\API\V1\Controllers\Authorization;

use App\API\V1\Controllers\BaseController;
use App\Models\Services;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules;
use Lauthz\Facades\Enforcer;
use OpenApi\Annotations as OA;

class ServiceController extends BaseController {

    /**
     *  @OA\Post(
     *      path="/api/service-register",
     *      operationId="ServiceRegister",
     *      tags={"Authentication"},
     *      summary="Register microservice",
     *      description="This endpoint is used to register additional microservice. !!! This endpoint need to be restricted !!!",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RegisterRequest"),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(ref="#/components/schemas/Login")
     *          )
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal error"
     *      )
     * )
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $service = Services::where('username', $request->name)->first();
        if(!$service) {
            try {
                $request->validate([
                    'name'     => ['required', 'string', 'max:255', 'unique:services'],
                    'password' => ['required', Rules\Password::defaults()],
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage()
                ]);
            }


            $service = Services::create([
                'name'     => $request->name,
                'username' => $request->name,
                'password' => Hash::make($request->password),
            ]);

            // Assign role `ServiceExecutionRole` to the new registered users
            if (!Enforcer::hasRoleForUser($service->id, 'ServiceExecutionRole')) {
                Enforcer::addRoleForUser($service->id, 'ServiceExecutionRole');
            }
        }

        return $this->token($request);
    }

    public function token(Request $request)
    {
        $request->request->add([
            'grant_type'    => 'password',
            'username'      => $request->name,
            'client_id'     => config('auth.credentials.service_connector.client_id'),
            'client_secret' => config('auth.credentials.service_connector.client_secret'),
        ]);

        $proxy = Request::create('oauth/token', 'post');

        return Route::dispatch($proxy);
    }

    /**
     *  @OA\Post(
     *      path="/api/service-refresh-token",
     *      operationId="ServiceRefreshToken",
     *      tags={"Authentication"},
     *      summary="Refresh service's token",
     *      description="Refresh the service's token",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(mediaType="application/json", @OA\Schema(ref="#/components/schemas/RefreshTokenRequest"))
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(ref="#/components/schemas/Login")
     *          )
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal error"
     *      )
     * )
     */
    public function refreshToken(Request $request)
    {
        $token = $request->bearerToken();

        $request = app('request');
        $request->request->add([
            'grant_type'    => 'refresh_token',
            'client_id'     => config('auth.credentials.service_connector.client_id'),
            'client_secret' => config('auth.credentials.service_connector.client_secret'),
            'refresh_token' => $request->refresh_token,
        ]);
        $request->headers->set('Authorization', 'Bearer ' . $token);
        $proxy = Request::create('oauth/token', 'post');

        $res = Route::dispatch($proxy);

        return json_decode($res->getContent());
    }
}
