<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialProvider;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\OrcidService;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class OrcidController extends Controller
{
    /**
     * The URL generator instance.
     *
     * @var \Illuminate\Routing\UrlGenerator
     */
    protected $generator;

    public function __construct(UrlGenerator $generator){
        $this->generator = $generator;
    }

    public function callback(){
        $user = Socialite::driver('orcid')->user();

        Cache::put('provider', [
            'name' =>OrcidService::class,
            'data' => $user
        ], now()->addMinutes(10));

        $return_uri = Cache::get('return_uri');

        $service = new OrcidService($user);
        $data = $service->getSocialProviderData();

        if($data['provider_user_id'] && !Auth::user()){
            $providerRecord = SocialProvider::where('provider_user_id', $data['provider_user_id'])->first();
            if($providerRecord) {
                $internalUser = $providerRecord->user;
                Auth::loginUsingId($internalUser->id);
            }
        }

        if($auth = Auth::user()){
            $auth->providers()->updateOrCreate(['provider' => OrcidService::class], $data);

            if($return_uri){
                Cache::forget('provider');
                return redirect($return_uri);
            }
        }


        return redirect()->route('login');
    }

    public function redirect(){
        $intended = session()->get('url.intended');
        redirect()->setIntendedUrl($intended);
        Cache::put('return_uri', $intended, now()->addMinutes(10));
        return Socialite::driver('orcid')->setScopes(['/authenticate'])->redirect();
    }

    public function authorize($ability, $arguments = []){
        $request = $this->generator->getRequest();
        $intended = $request->method() === 'GET' && $request->route() && ! $request->expectsJson()
            ? $this->generator->full()
            : $this->generator->previous();
        if($intended) {
            $intended = str_replace('/orcid/', '/oauth/', $intended);
            redirect()->setIntendedUrl($intended);
            Cache::put('return_uri', $intended, now()->addMinutes(10));
        }
        return Socialite::driver('orcid')->setScopes(['/authenticate'])->redirect();
    }
}
