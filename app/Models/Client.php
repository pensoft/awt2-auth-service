<?php

namespace App\Models;

use Laravel\Passport\Client as PassportClient;

class Client extends PassportClient
{

    public function skipsAuthorization(): bool
    {
        return true;
    }
}
