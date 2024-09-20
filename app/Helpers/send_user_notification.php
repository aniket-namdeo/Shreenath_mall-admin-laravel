<?php

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

if (!function_exists('sendUserNotification')) {
    function sendUserNotification($title, $body, $deviceTokens = [], $image = null, $data = [])
    {
        try {

            $firebaseCredential =
            [
                "type"=>"service_account",
                "project_id"=>"smed-432809",
                "private_key_id"=>"0e4a9d14a15a1c2e5d3cc44d3434037663e9cd49",
                "private_key"=>"-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDZ4D1ZqovtVQBH\nml3z7IgbddT2Tqh5yzvs/rtL8Llo26vcrlCapXne3mk8yXtdhLGLVCA7ITFnZ2lE\nXcXrgdnvmotR9egAei4H8awU9+nWK2J+ukK8M0Y+j0aNMZs/TzCUhl2GERxgtKGb\n1DFg2G/N38elIM5kBHYNzJdFLLL7y0NOcslCuoS0Q1IF1LpZE4ugToglU0kkRX+N\ncWdgDXhnOmrljRuOXFiTEtzthy7wKtI1HiiIiJ++HQWqvkxTg+pSNARbFivJZD6V\nYUeSSMAOOVoxwwYS5lTZ5TBAz5tCKX/NFFU7ykNMKkLt5ndk96PQo0g7UofGRdYh\nO2Ler5LLAgMBAAECggEAQhgFZHMZOakEibQpdjq122a2cPXRpAjkJ/Pqi5H+HPIu\nw6ZZq2AxhUuBL0CL3QXI+lRN5sIeA5laVLQBu3zLySTfyMBJXgOyfRRyOHYwiJjm\nqz0Dy6XeVFIQe/qlduImAZh1PJtqOWfycpw/Unq2CAUvwkcedTbpPSxoY0K5FSq3\nspWsHVuxr3vT7VRXOqtRe3s3kzNQHw6f5bjOTiZb/W0ujNYK4UxQjD1APShyjKtM\nJbumGRMzGBd/i+KGEEXGbNVgiyNrNKNWvg5ak8ht/bFxdqgOs0PP5r1ZfMutfKG1\nTqGi5SNCcmAuwuJwgk3zlwa5YMXruKA8Z3yIPbGsCQKBgQD7TKKO/yvJH1T0l3Qx\nqYeTXnnZ1oqGpUxtgsjY8lBpr4zf7Paoo+uDb57tQTpW6HWfW6IOc+Dz+QLrXqsE\nTfTLPDqA+fmpwwluysnifkiviQHcnmf/Ilul58W7/DD+Xw7MSrDoV+ycim5CuAdg\naGySEeZXBK2tCRHsSmYayFL51wKBgQDd843g1d03FD+ccoHMxvMLjITe80I4gWJW\nX5Vh+qodO3Etdfj4tloyjRusekQDp5KtxPL+bN5rkDkTXVeKewWJ5wQk+WdRDegD\nAmxTyHdHdpvtFfghTojQavrECWx0bMC4X1AuUApQFsa898cfED0Qa0fZl2HTRsbw\nMOFP1g6YLQKBgAMDjkeMw+ermoc8ccZOtDOORIPaUNsAjIQbt3Dypwg9dMESxHqN\nTLvM0OkjiSGVtCNvI+hsd1w1tlVAU2i/zpnJZSI63UWt8yUDBZzTyudgC0esFq82\nqEa7GuIASk4isbi9hJWkyE+wUVY3gs8jMXonAM42XibfHvnogoT7thMNAoGBANmh\nSDvu2CN6ykjYCqhFZ+mqFlsagZMwYsE4phxVklppf7dI1yDghR7OOBVuKaS/ulaD\nKJULISitWRnAy+awbCTlDa5HkuPqU9YnmRqqFTNQfOIDSbM283YRf+ObLeoW/P2M\nD+3pc8NGIgcGmgu+e3HPD7uu8TAeVVENTNBgnxzdAoGBALtUMdJJhZKCj7ZQo6SP\nbWvcPMI2PX6vZtkRPS7R8cxAhKNH1EOnryb8p8xTbVAypuPoG9M6+nBHn4pu2igx\nMkf8OY05ndnRv6r1WVN62U3gXd/eM854x9E1DmTmezeT1fNB3CnYRt068Ejspdqw\n+u1RowiM2IYtan5vzSSMjc4m\n-----END PRIVATE KEY-----\n",
                "client_email"=>"firebase-adminsdk-7xiyx@smed-432809.iam.gserviceaccount.com",
                "client_id"=>"110472758747748632847",
                "auth_uri"=>"https://accounts.google.com/o/oauth2/auth",
                "token_uri"=>"https://oauth2.googleapis.com/token",
                "auth_provider_x509_cert_url"=>"https://www.googleapis.com/oauth2/v1/certs",
                "client_x509_cert_url"=>"https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-7xiyx%40smed-432809.iam.gserviceaccount.com",
                "universe_domain"=>"googleapis.com"
            ];

            $firebase = (new Factory)
                ->withServiceAccount($firebaseCredential);

            $messaging = $firebase->createMessaging();

            $sound = "custom_notification_sound";
            
            $notification = Notification::create($title, $body, $sound);

            $message = CloudMessage::new()->withNotification($notification);

            if (!empty($data)) {
                $message = $message->withData($data);
            }

            if ($image) {
                $message = $message->withData(['image' => $image]);
            }

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
