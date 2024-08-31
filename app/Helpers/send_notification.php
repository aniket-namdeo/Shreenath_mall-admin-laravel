<?php

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

if (!function_exists('sendFirebaseNotification')) {
    function sendFirebaseNotification($title, $body, $deviceTokens = [], $image = null, $data = [])
    {
        try {

            $firebaseCredential = [
                "type" => "service_account",
                "project_id" => "shreenath-mall",
                "private_key_id" => "9a607b8dc53818a714477297d428b3f1f96a7ebb",
                "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQC5eXx/h3lN9hv6\nAeby7iphjmL9OOGTBn/x/CVvEsHVMKi7Drb39SZuM0zmtOchtkLkoBFbUN0VkB5+\nUaJu6bWzUk03rbQvulJUFdqtprUF/F6sA8fgWwAxRGt2ul3ZVelUhtmRZxBiPdg7\nKV7R27lLXVgKxqLCaM/smN5ikQA6IF3A+A9GxHCLo+Avf3UyniEpn2yh8fqthbcD\nb96+kVpE0vdIuxX1y8hYaKSv20c9EkLK+AbJd+dkfq59sTvxqOeqo38abLVu+t8A\nZfWQwALbzJunew/4BqtuGXu3PencGPEIWMYJ6QQWbOZvcbLrM1t/KAGncA2FKW/X\nI/NhaMB/AgMBAAECggEAD2gsE1vpk7RR9p6Z1Kw8EQaG6ooDEveDQVK0uVlRiKgW\nHBPI1ygiHR1d0fxNBtvhCqTRTEiXVOc34T5ew9/eHBtGFs3zHdPYauu10p76gpjI\nNHnL7LMifPU2CBLLIPal/0OEZzOshLymbaOuILij18LVQW/mrUePnhPExWNOJYXO\nKg/27yqme+Mo47aMKUWZno6adyg0jz2bByVB1/adwPjPdmAoil0Q1++wro8Yb2v+\nDAbjF7cE0vF8ZceSBkNTLgozrDySdXcq6G7sWBEpmc7eCSV6gQ5XiZ9o3Q1UU9sX\nNiINiuuWwzNx3JXlP38f4uGUxQXbOQeQM3B5Fc2i4QKBgQD8wVtegn9/NDPDsWVk\nElT7k8JhQMjVP7eGi+uQOvw7L765wpW/UQx/s6g1smjALqpSn+lbhoLJgBB6ZfOG\nxzK9JtQArPud7eIK7OGea/lUaE/EPA8zUsP5VXc2fu0Q5J1FZPrQTpHNmpqoCI1T\n48q7E7rCWWuv/9qiy2fwW3fBzQKBgQC72wVp5RycxETP/XhPNOTBUoOmeg1SONku\nLKQMbz8UkXqLbzdCNeHuT1Sf+kKcMV83dL9VXfG0p2DhLS+D/IChtEZKZegHy+IT\nG4TePqmi1meYB8C1x0QsLD7WmOUAyZ1iOQhkGVYBTyNzocchRIXPiaQwInFzNEuL\noo53uXIvewKBgG86B6NHeiPYLQ9o+V1YU92B4IA7qiVtrK2g1UDbNDQ3ho7oek1+\ntSldPiCjKkWoQ3uos2B7iQJzQM0cIFanQkTK2XCSrweIr3hvVboJeecTIEcSxv2m\n5mbKnXN1140fjbYEAfu5F6CK8JQRb2ADViuNOxpbj3Ab/3K0YED9f23hAoGAaucN\n4qBGMxQiELaus2xnTXiWgLNuRz8goH048faQ0DSlpxmoOZ6OLt6oSs3RAC+8fsOK\napsmhGbH4/yh0Jtt3BfJ9Gafr2ggBD2h1BOW15rpowOucAOw0O5w6BBkKZmSXaYV\nF1mvrtkJVLFYr57eAyfR7q57H1NANntQVeOLjmcCgYAlsyTJqLtSb30d3onq2ZlK\ndFXHCROdoZC8aQuFxLlvY9XxlcOQHXjFtj7TE1yKUMOfJlE53gJ/JBKic2eQJp04\nldx9UeDdbeODDan/M41SrgBr7LqTkxg7qpka17OAJnnGpqGh+Dk87g5nRUl25s2J\nofWzq2TVeZao35hepeMCwQ==\n-----END PRIVATE KEY-----\n",
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

            if (!empty($data)) {
                $message = $message->withData($data);
            }

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
