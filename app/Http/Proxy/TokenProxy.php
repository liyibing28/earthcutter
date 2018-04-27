<?php
/**
 * Created by PhpStorm.
 * User: liyibing
 * Date: 2018/4/19
 * Time: 下午4:37
 */

namespace App\Http\Proxy;


use GuzzleHttp\Client;

class TokenProxy
{
    protected $http;

    /**
     * TokenProxy constructor.
     * @param $http
     */
    public function __construct(Client $http)
    {
        $this->http = $http;
    }


    public function login($email, $password)
    {

        if(auth()->attempt(['email' => $email, 'password' => $password, 'is_active' => 1]))
        {
            return $this->proxy('password', [
                'username' => $email,
                'password' => $password,
                'scope' => '',
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Credentials is not match'
        ],421);

    }

    public function logout()
    {
        $user = auth()->guard('api')->user();  //从token获取到user

        if(is_null($user)){
            app('cookie')->queue(app('cookie')->forget('refreshToken'));

            return response()->json([
                'message' => 'Logout!'
            ],204);
        }

        $accessToken = $user->token();

        app('db')->table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        app('cookie')->queue(app('cookie')->forget('refreshToken'));

        $accessToken->revoke();

        return response()->json([
            'message' => 'Logout!'
        ],204);
    }

    public function refresh()
    {
        $refreshToken = request()->cookie('refreshToken');

        return $this->proxy('refresh_token',[
            'refresh_token' => $refreshToken,
        ]);
    }

    public function proxy($grantType, array $data = [])
    {
        $data = array_merge($data, [
            'client_id' => env('PASSPOT_Client_ID'),
            'client_secret' => env('PASSPOT_Client_Secret'),
            'grant_type' => $grantType,
        ]);
        $response = $this->http->post('http://earthcutter.test/oauth/token', [
            'form_params' => $data
        ]);

        $token = json_decode((string)$response->getBody(), true);

        return response()->json([
            'token' => $token['access_token'],
            'auth_id' => md5($token['refresh_token']),
            'expires_in' => $token['expires_in']
        ])->cookie('refreshToken', $token['refresh_token'], 14400, null, null, false, true);
    }
}