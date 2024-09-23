<?php


if (!function_exists('sendOneSignalNotification')) {

    function sendOneSignalNotification($title, $body, $deviceTokens = [], $image = null, $data = [], $launchUrl = null, $category = null)
    {
        try {
            $appId = '01f02ebf-ec00-4a29-a4d7-ff4baed66a14'; 
            $apiKey = 'MzUwYjhjYTMtODQ1YS00YjY4LTkzYTItNjc1YzRiMWIxNjZj';

            $content = [
                "en" => $body
            ];

            $heading = [
                "en" => $title
            ];

            $fields = [
                'app_id' => $appId,
                'include_player_ids' => $deviceTokens,
                'headings' => $heading,
                'contents' => $content,
                'data' => array_merge($data, [
                    'navigate_to' => 'open_latest_order',
                    'launchUrl' => 'com.shreenathdelivery.app://open_popup',
                    'category' => 'delivery order'
                ]),
                'ios_badgeType' => 'Increase',
                'ios_badgeCount' => 1,
                'big_picture' => $image,
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json; charset=utf-8',
                'Authorization: Basic ' . $apiKey
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $response = curl_exec($ch);
            curl_close($ch);

            $responseData = json_decode($response, true);
            $successCount = $responseData['recipients'] ?? 0;

            return [
                'success' => true,
                'success_count' => $successCount,
                'response' => $responseData,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
