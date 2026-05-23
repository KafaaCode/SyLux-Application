<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;
use Auth;
use Illuminate\Support\Facades\Cache;
use Exception;

class NotificationSendController extends Controller
{
    protected $serviceAccountKey;

    public function __construct()
    {
        // تحميل محتوى JSON من قاعدة البيانات
        $this->serviceAccountKey = json_decode(Setting::get('fcm_service_account'), true);
    }

    public function updateDeviceToken(Request $request)
    {
        $user = Auth::user();
        $user->fcm_token = $request->token;
        $user->save();

        return response()->json(['message' => 'Token successfully stored.']);
    }

    public function sendNotificationToAll(Request $request)
    {
        $FcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();

        $accessToken = $this->getCachedAccessToken();

        $url = 'https://fcm.googleapis.com/v1/projects/' . $this->serviceAccountKey['project_id'] . '/messages:send';
        $iconUrl = Setting::get('fcm_icon_url', '');

        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ];

        foreach ($FcmTokens as $FcmToken) {
            $data = [
                'message' => [
                    'token' => $FcmToken,
                    'notification' => [
                        "title" => $request->title,
                        "body" => $request->body,
                    ],
                    'webpush' => [
                        'notification' => [
                            'icon' => $iconUrl,
                        ],
                    ],
                ],
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_exec($ch);
            curl_close($ch);
        }

        return response()->json(['message' => 'Notifications sent.']);
    }

    public static function sendNotification($id, $title, $body, $options = [])
    {
        $user = User::find($id);
        if (!$user) return response()->json(['error' => 'User not found'], 404);

        $iconUrl = Setting::get('fcm_icon_url', '');
        $cacheDuration = Setting::get('fcm_cache_duration', 3500);

        $accessToken = Cache::remember('fcm_access_token', $cacheDuration, function () {
            $serviceAccountKey = json_decode(Setting::get('fcm_service_account'), true);
            $jwt = NotificationSendController::createJwt($serviceAccountKey);
            return NotificationSendController::getAccessToken($jwt);
        });

        $url = 'https://fcm.googleapis.com/v1/projects/' . json_decode(Setting::get('fcm_service_account'), true)['project_id'] . '/messages:send';

        $data = [
            'message' => [
                'token' => $user->fcm_token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'webpush' => [
                    'notification' => [
                        'icon' => $options['iconUrl'] ?? $iconUrl,
                    ],
                ],
            ],
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        curl_close($ch);

        return response()->json(['response' => json_decode($response, true)]);
    }

    public function sendNotificationTest($id)
    {
        return self::sendNotification($id, 'Test', 'This is a test notification');
    }

    protected static function createJwt($serviceAccountKey)
    {
        $header = json_encode(['alg' => 'RS256', 'typ' => 'JWT']);
        $claims = [
            'iss' => $serviceAccountKey['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => time() + 3600,
            'iat' => time(),
        ];
        $payload = json_encode($claims);

        $headerBase64 = base64_encode($header);
        $payloadBase64 = base64_encode($payload);

        $signature = '';
        openssl_sign("$headerBase64.$payloadBase64", $signature, $serviceAccountKey['private_key'], 'sha256');
        $signatureBase64 = base64_encode($signature);

        return "$headerBase64.$payloadBase64.$signatureBase64";
    }

    protected static function getAccessToken($jwt)
    {
        $tokenUrl = 'https://oauth2.googleapis.com/token';
        $tokenData = [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ];

        $ch = curl_init($tokenUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($tokenData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tokenResponse = curl_exec($ch);
        curl_close($ch);

        $tokenResponse = json_decode($tokenResponse, true);

        if (isset($tokenResponse['access_token'])) {
            return $tokenResponse['access_token'];
        }

        throw new Exception('Failed to generate access token: ' . json_encode($tokenResponse));
    }

    protected function getCachedAccessToken()
    {
        $cacheDuration = Setting::get('fcm_cache_duration', 3500);

        return Cache::remember('fcm_access_token', $cacheDuration, function () {
            $serviceAccountKey = json_decode(Setting::get('fcm_service_account'), true);
            $jwt = self::createJwt($serviceAccountKey);
            return self::getAccessToken($jwt);
        });
    }
}
