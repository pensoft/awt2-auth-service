<?php
namespace App\Virtual\Requests;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      title="Check user policy request",
 *      description="User policy parameters",
 *      type="object",
 *      required={"uri","method"},
 *      @OA\Xml(
 *         name="CheckPolicyRequest"
 *      )
 * )
 */
class CheckPolicyRequest {
    /**
     * @OA\Property(
     *     title="Uri",
     *     description="URI of the request",
     *     type="string",
     *     example="/event-dispatcher/123"
     * )
     *
     * @var string
     */
    private string $uri;

    /**
     * @OA\Property(
     *     title="Method",
     *     description="Request method",
     *     type="string",
     *     enum={"post","get","put","patch","delete","option","head"},
     *     example="post"
     * )
     *
     * @var string
     */
    private string $method;
}
