<?php

namespace App\Http\Controllers;

use App\Models\SocialProvider;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function show()
    {

        $user = Auth::user();
        $providers = $user->providers->map(function($item) {
            return [
                'name'=> app($item->provider)->getName(),
                'id' => $item->provider_user_id
            ];
        })->toArray();

        return view('dashboard', ['providers'=>$providers]);
    }
}
