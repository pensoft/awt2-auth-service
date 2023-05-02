<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\OrcidService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Lauthz\Facades\Enforcer;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
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

        $intended = request()->get('return_uri', null);
        redirect()->setIntendedUrl($intended);

        return view('auth.register', $data);
    }


    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $provider = Cache::get('provider');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Assign role `author` to the new registered users
        Enforcer::addRoleForUser($user->id, 'author');

        Auth::login($user);

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
    }
}
