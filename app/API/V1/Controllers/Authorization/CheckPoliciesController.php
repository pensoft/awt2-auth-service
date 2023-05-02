<?php

namespace App\API\V1\Controllers\Authorization;

use App\API\V1\Controllers\BaseController;
use App\Traits\PolicyMatcherFunctions;
use Illuminate\Http\Request;
use Lauthz\Facades\Enforcer as NewEnforcer;
use OpenApi\Annotations as OA;

class CheckPoliciesController extends BaseController
{
    use PolicyMatcherFunctions;

    /**
     * @OA\Post(
     *      path="/api/v1/authorization/check",
     *      operationId="checkUserAuthorization",
     *      tags={"Authorization"},
     *      summary="Check user authorization",
     *      description="Check if the request is authorized for the given subject (user)",
     *      security={{"passport":{}}},
     *
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(mediaType="application/json", @OA\Schema(ref="#/components/schemas/CheckPolicyRequest"))
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="allow", type="boolean", example="true"),
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *     @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function __invoke(Request $request){
        $this->registerMatcherFunctions();

        return response()->json([
            'allow' => NewEnforcer::enforce($request->user()->id,$request->get('uri'),$request->get('method'))
        ], 200);
    }
}
