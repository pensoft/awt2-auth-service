<?php
namespace App\Virtual\Requests;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      title="Register request",
 *      description="Register parameters",
 *      type="object",
 *      required={"name","password"},
 *      @OA\Xml(
 *         name="RegisterRequest"
 *      )
 * )
 */
class RegisterRequest {
    /**
     * @OA\Property(
     *     title="Name",
     *     description="Name of the microservice",
     *     type="string",
     *     example="ArticleService"
     * )
     *
     * @var string
     */
    private string $name;

    /**
     * @OA\Property(
     *     title="Password",
     *     description="Password for the service",
     *     type="string",
     *     example="0B0341FC"
     * )
     *
     * @var string
     */
    private string $password;
}
