<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    private $client;
    private $redirectUri;

    public function __construct()
    {
        $this->client = new Client();
        $this->redirectUri = env('LINE_LOGIN_REDIRECT');
    }

    /**
     * Redirect the user to the LINE authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToLine()
    {
        $clientId = env('LINE_LOGIN_CHANNEL');
        $redirectUri = urlencode($this->redirectUri);
        $state = Str::random(40);

        session(['line_state' => $state]);

        $url = "https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id={$clientId}&redirect_uri={$redirectUri}&state={$state}&scope=profile%20openid%20email";

        return redirect($url);
    }

    /**
     * Obtain the user information from LINE.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleLineCallback(Request $request)
    {
        $state = $request->input('state');
        $code = $request->input('code');

        if (!$state || $state !== session('line_state')) {
            return redirect('/login')->with('error', 'Invalid state');
        }

        $response = $this->getAccessToken($code);

        if (!$response || !isset($response->id_token)) {
            return redirect('/login')->with('error', 'Failed to get access token');
        }

        $userProfile = $this->getUserProfile($response->id_token);

        if (!$userProfile) {
            return redirect('/login')->with('error', 'Failed to get user profile');
        }

        $user = User::updateOrCreate(
            [
                'line_id' => $userProfile->sub,
            ],
            [
                'name' => $userProfile->name,
                'email' => '',
                'password' => null, // 明示的にnullを設定
                'avatar' => $userProfile->picture,
            ]
        );

        Auth::login($user, true);

        return redirect()->intended('/');
    }


    private function getAccessToken($code)
    {
        try {
            $response = $this->client->post('https://api.line.me/oauth2/v2.1/token', [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => $this->redirectUri,
                    'client_id' => env('LINE_LOGIN_CHANNEL'),
                    'client_secret' => env('LINE_LOGIN_SECRET'),
                ],
            ]);

            $responseBody = $response->getBody()->getContents();
            Log::info('Access Token Response: ' . $responseBody);

            return json_decode($responseBody);
        } catch (\Exception $e) {
            Log::error('Failed to get access token: ' . $e->getMessage());
            return null;
        }
    }

    private function getUserProfile($idToken)
    {
        try {
            $response = $this->client->post('https://api.line.me/oauth2/v2.1/verify', [
                'form_params' => [
                    'id_token' => $idToken,
                    'client_id' => env('LINE_LOGIN_CHANNEL'),
                ],
            ]);

            $responseBody = $response->getBody()->getContents();
            Log::info('User Profile Response: ' . $responseBody);

            return json_decode($responseBody);
        } catch (\Exception $e) {
            Log::error('Failed to get user profile: ' . $e->getMessage());
            return null;
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
