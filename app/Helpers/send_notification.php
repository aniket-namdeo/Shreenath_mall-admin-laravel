<?php

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\FcmOptions;
use Kreait\Firebase\Messaging\Notification;

if (!function_exists('sendFirebaseNotification')) {
    function sendFirebaseNotification($title, $body, $deviceTokens = [], $image = null, $data = [])
    {
        try {

            $firebaseCredential =
                [
                    "type" => "service_account",
                    "project_id" => "smed-432809",
                    "private_key_id" => "e8c31a1ac6cc1e6cf69f1497debca417b247ba2c",
                    "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDHv5XHllUtTUrW\n8UiztJmSgJPSkkq6WIcVpbDE6GN/gpQe94cAntQ+WpbZ0F2Blh7AxGyjnZt3g6j0\nsSmUFhPKkhtKDKarKb5rBt5Kvb9o0rjGTvGqS1ZM0CkaWztCuIM/S5pNLhjN843A\n9K4Z02w4cEIPSbD232O6RK/OoR8rInoaqBgD6Urz4Uo8H5fK8latY8s3e11yHgGD\n0/cmVY41EdQGgcaJDOSjr6MpaW9POrGNDGUL98fqMyn6oO0ehe8K7nIYRKQ2aZQ5\n5Yv/D/XuDqkAbcdaWSTKLmgjs+ReyFibg8g1QYhcxn+LKyQXYMvuZp99sFqnD8FG\nqrL1yyDZAgMBAAECggEAB9jEWwNSVEXBh2ESIJEbKVCovfBmRBy/LcAFCi8w3Wz1\nQaQqpwEWSF7Jp0PSsIkDq0HsHJ9P4KmI5RfikMEvRNlpfgayM24f31d1Ow1qLAV/\nIbcvMifke37/5luoH85cxYtEQ/zoF4sWSfqyriwKh8sNJUmZTJFo+wPAvkbBETIn\nPLaAP5jnxCSeiw8eYvxSqfsIZCDYg71mqcsGKSPirxXLCx9rYQq3gS1Qt6dHEZAX\nn+/7nutlQRbTYLIPxGS7xacUfcJDbuowPLLXETJaXVnYCwRI/NO8EAnUOv8kkzIq\nNxNvPFJE0592+FHEY06iRHNfczxbOAcf03cZtC1VswKBgQDt4lOz8rVz1Fhz+5sO\nsgnRHjSKhM+YIcClzms9kgqhJiLkaMdxxuQW6G/7XTlyNFsWD7n9KVdoKpda9nYT\nKUZWj+rhVLyuwGhb+/y27x8+cIm1nz1Ntdn1U6xlH1mf9L9juj3Kok+hO93kA3JJ\naTeDgSUZ/PyHRiAJlUavwvIMZwKBgQDW9chjQw4EqRElb4kD/aRLD3A/Vuq/75JE\nq3Jf+GvB9JW6ebxFGdpkoyc0WsfBwc/T93gi4sYkiQ9CEAGjeJq2hZGldnE36q6F\n3QzmwiOSlDhLpMYTzuJvLLyNpjLVW/2Uc7qZUPfata/R5NIwotLD9/TQ3XJNJohq\n0cPA2MEgvwKBgAUlon4AQGDTNV69EOvOelvl9WkR2pQGFu7/el6IrGY0NwkOI1KY\n5RKB0Pp1V+raqyXdDT8nB9cfJMs5DfD4Madp0cEyXirBywBCgYNLxTdKpBAj8+Wc\ni6y9NLuzY/MMDqAPxYp+3I42h2SJlo10E1lrD+xyBty+ba8HZdIju6z9AoGBAJr/\nrvakKz+BCTQNMKcIBad6Al4ptiuf+8A4P8ijwE+ipTRJA1BwS+G1I1fE/bTgo5Mc\nJixBiM5fZfkkwYm2NRjXRyYgOZMwTZeIxPy/kBbpeY5RyeIOk4fGok8hQBZItpiM\nukhC8fVqfNTEQit/vKpB6O2SQBERb9xWVOiBYwDRAoGABdFYI4LnUZBqk5eZwCyW\nUo2hV+RJHnuRnbEv5NsOxpYVM9mRy+j3NxOjlGDk0FBKV8ptuySKs1A7eBCr+fO0\ncQatMp4ClA2Gr3XhVkPwwyRI1XK3+vWTrGHOHhMbubRBSX7OkAm3dd6wz0I+R6q2\nFRi4mT1YThRFevKLB7V8iXA=\n-----END PRIVATE KEY-----\n",
                    "client_email" => "firebase-adminsdk-7xiyx@smed-432809.iam.gserviceaccount.com",
                    "client_id" => "110472758747748632847",
                    "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
                    "token_uri" => "https://oauth2.googleapis.com/token",
                    "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
                    "client_x509_cert_url" => "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-7xiyx%40smed-432809.iam.gserviceaccount.com",
                    "universe_domain" => "googleapis.com"
                ];

            $firebase = (new Factory)
                ->withServiceAccount($firebaseCredential);

            $messaging = $firebase->createMessaging();


            $dataPayload = array_merge($data, [
                'navigate_to' => 'open_latest_order'
            ]);

            $notification = [
                'title' => $title,
                'body' => $body,
                'sound' => 'custom_notification_sound',
                'android' => [
                    'notification' => [
                        'channelId' => 'default_notification_channel_id',
                        'sound' => 'custom_notification_sound',
                    ],
                ],
            ];

            $message = CloudMessage::new()
                ->withData($dataPayload)
                // ->withNotification(Notification::create($title, $body))
                ->withNotification($notification)
                ->withAndroidConfig(AndroidConfig::fromArray([
                    'notification' => [
                        'sound' => 'custom_notification_sound',
                    ],
                ]));

            // $sound = "custom_notification_sound";
            // $click_action = "FLUTTER_NOTIFICATION_CLICK";
            // $priority = "high";
            // $channelId = "custom_channel";
            // $show_on_foreground = true;

            // $notification = Notification::create($title, $body, $sound, $click_action, $priority, $show_on_foreground, $channelId);

            // $message = CloudMessage::new()->withNotification($notification);


            print_r($message);

            if (!empty($deviceTokens)) {
                $report = $messaging->sendMulticast($message, $deviceTokens);
                $successCount = count($report->successes());
                $failureCount = count($report->failures());

                return [
                    'success' => true,
                    'failure_count' => $failureCount,
                    'success_count' => $successCount,
                    'failures' => $report->failures(),
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'No device tokens provided',
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
