<?php
namespace App\Virtual\Requests;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      title="Login user request",
 *      description="Login user parameters",
 *      type="object",
 *      required={"username","password"},
 *      @OA\Xml(
 *         name="LoginRequest"
 *      )
 * )
 */
class LoginRequest {
    /**
     * @OA\Property(
     *     title="Username",
     *     description="User's email",
     *     type="string",
     *     example="admin@pensoft.net"
     * )
     *
     * @var string
     */
    private string $username;

    /**
     * @OA\Property(
     *     title="Password",
     *     description="User's password",
     *     type="string",
     *     example="admin@pensoft.net"
     * )
     *
     * @var string
     */
    private string $password;
}
