<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\RefreshTokenRepository;
use OpenApi\Annotations as OA;

class PassportAuthController extends Controller
{
    public function registerUserExample(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $access_token_example = $user->createToken('PassportExample@Section.io')->access_token;
        //return the access token we generated in the above step
        return response()->json(['token' => $access_token_example], 200);
    }


    public function loginUserExample(Request $request)
    {
        $login_credentials = [
            'email'    => $request->email,
            'password' => $request->password,
        ];
        if (auth()->attempt($login_credentials)) {
            //generate the token for the user
            $user_login_token = auth()->user()->createToken('PassportExample@Section.io')->accessToken;
            //now return this token on success login attempt
            return response()->json(['token' => $user_login_token], 200);
        } else {
            //wrong login credentials, return, user not authorised to our system, return error code 401
            return response()->json(['error' => 'UnAuthorised Access'], 401);
        }
    }

    /**
     *  @OA\Post(
     *      path="/api/token",
     *      operationId="login",
     *      tags={"Authentication"},
     *      summary="Log the user in",
     *      description="Login the user using password grant authentication",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/LoginRequest"),
     *          @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"username", "password"},
     *               @OA\Property(property="username", type="email"),
     *               @OA\Property(property="password", type="password")
     *            ),
     *          ),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(ref="#/components/schemas/Login")
     *          )
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal error"
     *      )
     * )
     *
     * login user to our application
     */
    public function token(Request $request)
    {
        $proxy = Request::create('oauth/token', 'post');

        return Route::dispatch($proxy);
    }

    /**
     *  @OA\Post(
     *      path="/api/refresh-token",
     *      operationId="RefreshToken",
     *      tags={"Authentication"},
     *      summary="Refresh user's token",
     *      description="Refresh the user's token",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(mediaType="application/json", @OA\Schema(ref="#/components/schemas/RefreshTokenRequest"))
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(ref="#/components/schemas/Login")
     *          )
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal error"
     *      )
     * )
     */
    public function refreshToken(Request $request)
    {

        $proxy = Request::create('oauth/token', 'post');

        return Route::dispatch($proxy);
    }

    public function logout(Request $request)
    {
        $id = $request->user()->id;
        $refreshTokenRepository = app(RefreshTokenRepository::class);
        foreach (User::find($id)->tokens as $token) {
            $token->revoke();
            $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);
        }

        return true;

    }

    /**
     * @OA\Get(
     *      path="/api/me",
     *      operationId="getUserByToken",
     *      tags={"Users"},
     *      summary="Get specific users",
     *      description="Returns user's data",
     *      security={{"passport":{}}},

     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
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
    public function authenticatedUserDetails()
    {
        return response()->json(['data' => auth()->user()], 200);
    }
}
