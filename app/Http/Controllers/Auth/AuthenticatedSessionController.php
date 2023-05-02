<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\SocialProvider;
use App\Providers\RouteServiceProvider;
use App\Services\OrcidService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Laravel\Passport\Passport;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = [
            'name' => '',
            'email' => ''
        ];
        $provider = Cache::get('provider');
        if($provider){
            $app = app()->makeWith($provider['name'], ['data' => $provider['data']]);
            $data = $app->getDataForRegister();
        }

        return view('auth.login', $data);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {

        $request->authenticate();
        $request->session()->regenerate();

        $provider = Cache::get('provider');

        if($provider){
            $app = app()->makeWith($provider['name'], ['data' => $provider['data']]);
            $data = $app->getSocialProviderData();

            if($auth = Auth::user()) {
                $auth->providers()->updateOrCreate(['provider' => OrcidService::class], $data);
                Cache::forget('provider');
            }
        }


        return redirect()->intended(RouteServiceProvider::HOME);

        /*$ref = request()->headers->get('referer');
        $current = $request->getUri();
        if($ref == $current) {
            $ref = RouteServiceProvider::HOME;
        }

        session()->flash('pass', $request->get('password'));
        return redirect()->route('create.token')->with('rollback', $ref);*/
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function logout(Request $request)
    {

        $this->revokeAccess($request);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if($return_uri =request()->get('return_uri', null)){
            return redirect($return_uri);
        }

        return redirect()->back();
    }

    private function revokeAccess(Request $request){

        /*collect(Cookie::get())->each(function($key, $cookie){
            Cookie::queue(Cookie::forget($key));
        });*/
        setcookie('ps-token', '', time()-3600, '/', $this->getDomain(url()->current()));
        setcookie('ps-refreshToken', '', time()-3600, '/', $this->getDomain(url()->current()));

        /*$request->user()->tokens()->each(function($token) {
            Passport::refreshToken()->where('access_token_id', $token->id)->delete();
            $token->revoke();
            $token->delete();
        });*/
    }

    private function getDomain($url){
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : '';
        if(preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)){
            return $regs['domain'];
        }
        return FALSE;
    }
}
