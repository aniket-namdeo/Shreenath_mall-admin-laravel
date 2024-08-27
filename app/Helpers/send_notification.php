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
                "private_key_id" => "2ac32a6baf28894f07e94d120505467d375eccfa",
                "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDHfV6u1qNrHEoo\nIzzSZb1y+7sx+YhJ5hSLVzonjFUjKtogcRQ/1059B2caMwiUqYnoNIqk7NCcn+Yo\nveuY57e5FKzeg/vDK0K711hVI1T4ofvkpvEb1nkC9Xv2lLDFg4loSH6Gd+jkSGVO\no9d0cmXcHQ8uP012IbzPSW6mFz7Ac2k6GPOsYKUiY+e4EG1kymKVb17ERA3J97Gf\nQDHSb/ZkKDyLabFgrLbprOnAxrGhsbGgTUM7d+7gaKIEM9FvXZNjVwza1Rgldc+f\nrQOvj+zNKQUCiEDJBEVrAzpCNix0vKeSzfA4x00+6Qlo5EOw5IXkBizy05SF09Vz\nzxV8GjOjAgMBAAECggEAQ8DSUBppHV9Z1mEFbsYMPom9zd7cyZCByMOC5ly0q8GJ\nnPwa7wXey/sgKtdLYkZkpr91mUcvIQrzvkGmy2Nj1FHv1pFICETgoPCmOSBLYziM\n119Vw2kn53fdtuVQVnzyxb7dbik6qZHnCnr+Gbgi3UvnVIM+eVFDEbn0gSei8fSH\nNPK9opi9BM/nlq4rUVETVt6/hm98M0rQFl3fHK8uQFrxKUWYea+xHmj3oLV5e0T6\nwXO08eqBcn1MaBx6ukW0FKpHgeHJVPjsN8sRTbJzEy7dk/u9VnEvGqcPGMrEmxvg\nT25zRxxkfCNF7mT+T6pakz78uuW6Cami+05pAF1gEQKBgQDkCYu0n6rZ7tUnVQ/v\nc2TezUVz2zYQYZw8wAtPEiyxW3KkAnvaJh+Fuj+/PceKrCE8hFb9ykItSEz8+TuF\nUDzWxCb5QGS7CsJaKnxon3aIxpDheGKoh94sylf6baDAomEk6BWJma03tvMasRON\npkp927aXtGOW2/urI0XOpn3rUQKBgQDf86utdSAdkRwFrj1uZLnulTfS5MmeiV8R\nvaQHL67qhlRKH3FQa2yPRRUOA/EFT0HM4DglTPbl2hIH5xTnGntv6QEXkzlqBGco\nUoQh2qxPW0XSUdm3rHpdec9oBHQNMmGiwHLp7564ixj4XZm9Fv+D8gyuPj4Qlwmz\nDCyYpqWKswKBgQDjxdki2J06Q8HrIJ7jKVrm5RhradltsWHymExzdY7otJQk2EpH\nku7Hj0qfRiErFVW5ceLGayGAw4gK4xOdzJCIYLMhIj27Sjro/yj3A9jNM7GBVNMO\nzW+RQ6du/9Oitk7cI2ln4PVRAk9/KMKEKUacwjp2+3rCNAcEYR4YFNsPkQKBgBz+\nqlqB0I+javJdVbzGM8Bs91ZJosTw2iss12DKzqW0kJMsMPqNffeqpQg0gG8EjOte\nmEZUCZ9GtZDqXS1yo0qg6zBHMmbEfSqeTFcpvadklMyfJkX+gbU6gRzhfrj6reNp\ncTdSe8U+1RPK4o21vY0yuGuSyWxSccIJsHhvEv27AoGBAJKeeq9WjTZUuv8vBptq\nIT01YkGgv8y/edrOitHUnALHHqbmKN7WwzWpUb8qBlyuapYMds+/tnV77d/TKlls\nYAWlWYFyNqzE+oLgab1ODuRsHw8v+dDaszejim7Rxyc/zF0o1NkMqHUcecFeVJvA\nZfdKVY72U58B7+TzVdAdsQhB\n-----END PRIVATE KEY-----\n",
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

            $report = $messaging->sendMulticast($message, $deviceTokens);

            $successCount = count($report->successes());
            $failureCount = count($report->failures());

            return [
                'success' => true,
                'failure_count' => $failureCount,
                'success_count' => $successCount,
                'failures' => $report->failures(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
