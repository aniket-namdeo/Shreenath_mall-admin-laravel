<?php

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

if (!function_exists('sendFirebaseNotification')) {
    function sendFirebaseNotification($title, $body, $deviceTokens = [], $image = null)
    {
        try {

            $firebaseCredential = [
                "type" => "service_account",
                "project_id" => "shreenath-mall",
                "private_key_id" => "490a420656a44464b5545c100f6a664a69f5c51b",
                "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCnS7kv0o5O92U9\n3coT7/JherXOM6u4TtAbihCMqXKLxsstDeQJvFnvDtUyzEgTevylbWwg9/IrY9t6\naolwy0VxrJI8imJL6yPyRVj2mgyUAGEd2GRPRhNNANADB2VJ2JBQdmIa5ehoDe5N\nZXIWCt2gnczIsibMFDOZ6kPjrG5Y5nevJmGScAqPqXTsouOmltJgBkmYUPU/4KKw\nOGGlzmeNBMPAeYgGb798l/Kn6VVHEg0NQz/BQBgMHVecN/EpNdesohnCdZ1SPzWj\nEghyArQwpyXO/mVIFa3RiNI9bWZdBBectaQa4BTJmFIz9vbFCxqja/REwkXzWysW\n3S1emDN1AgMBAAECggEAENe4zy29kgmqMa5Ql+1CU7oM77OYCDg3D26499Bfbd8X\nuXN6j9hcnYq6wCB86SkqomT/y9nqkZ++CvcK20Y7uZQMLPgpqUcFGXEN4dXkikn3\nfQ+6GZkOfGQmjQeDlQmujcs9WUPoQAGXCke6UqnJYlBAu7vj2Av4nfhN2XAUs/Jm\nQbyKGTo1Onvgs3d6V8oNGp9mltzQMpGX/0P3NNhNX5z1WkIkJLQ9H6o0Puf0+FKZ\nD0OaulG9t+0P5d/Kh6yk42b4OPXv6mNxP6LLH5WNxCBoFRY+Mfq/kzpgqaLftWaE\nat8sjZd8PmapRzNnhZwp4MCv/FXQhhRe6kdUVQ0cwQKBgQDa9dgdtG7Finn+4We2\n2//vjbpkwAOvmbhLKY10ocCGzGBsU4/zSjdOB/HTFcPbNvmmgK7KhVnwEaSQDNbF\nDydLTUAASE24HCQBHjFg5LZR7F3QKvSWhivVwSM8R6xdHlSf72oYK0GuHf4ZYJy2\nOOLARfG7Li9tKV7bq6+Gi6EyOQKBgQDDmIcm2qgDRE7rodgqagpljNNV0bqlWlnn\n56sQDyuDK8suZ+NbgwPWaoJuXmE7qYadkod/ylpl/j5uhHM8upBtfH0KgNK8JhFx\nFQ4tAg8bCwLxoo0iKwYbf60PF4cYSdnYAFeYyavVBVmEQeewBK524tlA4tKZoJco\n53udf1WbHQKBgBQ0AOfkwR/LAiypYad2ryvMWPl42h42wdF1mQ686gXGD9OO9kZN\nf8Lcasy+Ql8UuH5Le1VGbqD/D78W4C44kriY/SHJihpFxnCv94BoOgZfF9zgSccl\nxB+p/XVPa7D/3nEPZyupuhq1u79dsbgCkbGKAp7xyQB6g70jH0P72DjJAoGASmy6\nWG1w6rVONljB8PmidRuNuqTwGUT02soLDDRJgULjsAe1ujdy+V5TvP1KkDIkV8bO\nqjBsD00bol/hnWT72b05swprpU3y6w1w9G1JJCgfeaQ5gZvPWh1N02VHcVWAf7E5\no5hxOsArXKjbKN3PKMuOkSL9sZkqi1Txc29lOn0CgYBMN4jdSelt1hGdKJW6ahRz\nHOtaYs9M50PsXe5yUnTKkduZvrc2QuBgQyGRkewnOy3azufuu0FXefvebbMStKli\nnHMX5/XeuFon589gJk9O1gY26VD22WCWmsdi9UCmxvkPSoUvVaxNsyw4jPXyMOsy\nIPW+W93gCCa0xeBxYpIrKA==\n-----END PRIVATE KEY-----\n",
                "client_email" => "firebase-adminsdk-mkaiy@shreenath-mall.iam.gserviceaccount.com",
                "client_id" => "112219955830561777083",
                "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
                "token_uri" => "https://oauth2.googleapis.com/token",
                "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
                "client_x509_cert_url" => "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-mkaiy%40shreenath-mall.iam.gserviceaccount.com",
                "universe_domain" => "googleapis.com"
            ];

            $firebase = (new Factory)
                ->withServiceAccount($firebaseCredential);

            $messaging = $firebase->createMessaging();

            $notification = Notification::create($title, $body);

            $message = CloudMessage::new()->withNotification($notification);

            if ($image) {
                $message = $message->withData(['image' => $image]);
            }

            // $report = $messaging->sendMulticast($message, $deviceTokens);

            // $successCount = count($report->successes());
            // $failureCount = count($report->failures());

            // return [
            //     'success' => true,
            //     'failure_count' => $failureCount,
            //     'success_count' => $successCount,
            //     'failures' => $report->failures(),
            // ];

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
