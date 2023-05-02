<?php

namespace App\Services;

use App\Models\SocialProvider;

class OrcidService
{
    public const NAME = 'ORCID';

    private $data;

    public function __construct($data = []){
        $this->data = $data;
    }

    public function getDataForRegister(): array
    {
        return [
            'name' => $this->data->name,
            'email' => $this->data->email,
            'provider' => self::NAME
        ];
    }

    public function getSocialProviderData(): array
    {
        return [
           'token' => $this->data->token,
           'refresh_token' => $this->data->refreshToken,
           'provider_user_id' => $this->data->id,
        ];
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
