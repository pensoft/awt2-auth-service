<?php

namespace App\Virtual\Models;


use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Login",
 *     description="Login result object",
 *     @OA\Xml(
 *         name="Login"
 *     )
 * )
 */
class Login
{
    /**
     * @OA\Property(
     *      title="Token type",
     *      description="The type of the generated token",
     *      example="Bearer"
     * )
     *
     * @var string
     */
    private string $token_type;

    /**
     * @OA\Property(
     *      title="Access Token",
     *      description="The access token",
     *      example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vYXJ0aWNsZS1hcGkuY29tL2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNjM3Nzc2MzU0LCJleHAiOjE2Mzc3Nzk5NTQsIm5iZiI6MTYzNzc3NjM1NCwianRpIjoidGJEcTJmaHRkQWxZNFI4cSIsInN1YiI6MSwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.kWsb0pGpTCT-8S4hPuYUqTDvqTlQp3lI-CXK1zAbktY"
     * )
     *
     * @var string
     */
    private string $access_token;

    /**
     * @OA\Property(
     *      title="Refresh Token",
     *      description="The refresh token",
     *      example="def50200bc83ca2955ad879152dfb662e5c405b7091b5fc61c0f30cae516ea1a9b45d146b59092b0f498be19d9dd91e2b00168a9aec9980d2d3a9319c6616eb9e2d6a6d501893b39893660170bc2bc213d13a6ad89abeaac539940ca919bc9262a89dc4a5434224d6a0a3955559f0587fa85f8f269b230d3e4c84d9b102db7560b2af98a2cb3a7715ea2ab122a27fd70929cc2e7949c93494015a0a9fdbce9fafc944ba169021bedbde900720f48507910b314777f5df74a8d9570d7647712c0fe4d1ca5aaaeca435583f78cd534954caf2680508b1a0e41a5512e3dee14655218673787a8f5fc7d1305d60d1047ea3676aa61e72a7ff87c18bd0c487255a2a0976658e5caeea8cc7643cd3076640e73bfc4c9fe1728a3912b4af8d9d0aa93b49b62d390eacf13623e95ec118a43ee69c6ad41634a66275d2ed09172ffa4c55bb18febd6400d388e61da6b9f59e2d200c71db6d72b910afa92d64458d9478adbf648c9315e7a7dc02a6a4df0d7facac860ba8f728156e5c99d27b394d4b4fa79a5b4197485bf767c3dc43b10ca69814c64b886f709e81a1a7bb027e252b7d9ee18d12a1c15aa171086"
     * )
     *
     * @var string
     */
    private string $refresh_token;

    /**
     * @OA\Property(
     *      title="Expire in",
     *      description="The life time of the token in secconds",
     *      example="3600"
     * )
     *
     * @var \DateTime
     */
    private \DateTime $expires_in;
}
