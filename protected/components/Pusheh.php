<?php

/**
 * Class Pusheh
 * @property resource $_curl
 */
class Pusheh extends CComponent
{
    private static $token = '9ba3c9257d1c86f3b053f2304095dd2358f9ac40';

    private static $curl;

    private static function send($url, $data)
    {
        self::$curl = curl_init();

        curl_setopt_array(self::$curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Token " . self::$token,
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec(self::$curl);
        $err = curl_error(self::$curl);

        curl_close(self::$curl);

        if ($err)
            return ['status' => false, 'error' => $err];
        else
            return ['status' => true, 'response' => $response];
    }

    /**
     * @param string $to
     * @param string $title
     * @param string $text
     * @param array $options
     * @return boolean
     * @throws Exception if request has been error.
     */
    public static function sendNotificationToUser($to, $title, $text, $options = [])
    {
        $params = [
            'app_ids' => ['ir.rahbod.habibi'],
            'filters' => [
                'pushe_id' => [$to]
            ],
            'data' => [
                'title' => $title,
                'content' => $text,
            ],
        ];

        /**
         * To see the options, see the following URL:
         * https://docs.push-pole.com/docs/api/#api_send_push_notification_to_single_users
         */
        if ($options)
            $params['notification'] = array_merge($params['notification'], $options);

        $result = self::send('https://api.push-pole.com/v2/messaging/notifications/', $params);

        if ($result['status']) {
            $response = json_decode($result['response'], true);
            if ($response['success'] == 1)
                return true;
            return false;
        } else
            throw new Exception($result['error']);
    }

    public static function sendDataToUser($to, $content, $options = [])
    {
        $params = [
            'app_ids' => ['ir.rahbod.habibi'],
            'data' => [
                'show_app' => true
            ],
            'filters' => [
                'pushe_id' => [$to]
            ],
            'custom_content' => $content,
            'priority' => 2
        ];

        /**
         * To see the options, see the following URL:
         * https://docs.push-pole.com/docs/api/#api_send_push_notification_to_single_users
         */
        if ($options)
            $params['notification'] = array_merge($params['notification'], $options);

        $result = self::send('https://api.push-pole.com/v2/messaging/notifications/', $params);

        if ($result['status']) {
            $response = json_decode($result['response'], true);
            if ($response['status'] == 1)
                return true;
            return false;
        } else
            throw new Exception($result['error']);
    }
}