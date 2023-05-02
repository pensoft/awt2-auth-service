<?php

namespace App\Virtual\Models;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="User",
 *     description="Authenticated user model",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */
class User extends BaseModels
{

    /**
     * @OA\Property(
     *     title="Id",
     *     description="The ID of the authenticated user",
     *     format="uuid",
     *     example="975c39e9-5071-44c5-b591-0cc6cde60945"
     * )
     *
     * @var string
     */
    private string $id;


    /**
     * @OA\Property(
     *      title="Name",
     *      description="The user\s name",
     *      example="Иван Иванов"
     * )
     *
     * @var string
     */
    private string $name;

    /**
     * @OA\Property(
     *      title="Email",
     *      description="The user's email",
     *      example="ivan.ivanov@arpha.com"
     * )
     *
     * @var string
     */
    private string $email;

    /**
     * @OA\Property(
     *     title="Role",
     *     description="The user's role",
     *     enum={"admin","author","editor","reader","SuperAdmin"},
     *     example="author"
     * ),
     * @var string
     */
    private string $role;

    /**
     * @OA\Property(
     *     title="Permissions",
     *     description="The user's permissions",
     *     type="array",
     *     @OA\Items(
     *      type="array",
     *      @OA\Items()
     *     )
     * ),
     * @var string
     */
    private array $permissions;
}
