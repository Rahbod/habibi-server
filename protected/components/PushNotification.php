<?php

/**
 * Class PushNotification
 * @property resource $_curl
 */
class PushNotification extends CComponent
{
    private static $serverKey = 'AAAAepSYZ9c:APA91bEkgncvfrj9K5WCJVm8fXWjRKy3kKWQ5S8VRK4Qhh-wNoQpAH2IWGQ0UchFSOoImwtCikVVcXap8XsxLXWHHByvMjcETTVRs_trlbdhLcgV-Kzpnu4Pyu410KnU8cmvwHEmRMIs';

    private static $curl;

    private static function send($data)
    {
        self::$curl = curl_init();

        curl_setopt_array(self::$curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "Authorization: key=" . self::$serverKey,
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
     * @param string $body
     * @param array $options
     * @return boolean
     * @throws Exception if request has been error.
     */
    public static function sendNotificationToUser($to, $title, $body, $options = [])
    {
        $params = [
            'to' => $to,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
        ];

        /**
         * To see the options, see the following URL:
         * https://firebase.google.com/docs/cloud-messaging/http-server-ref
         */
        if ($options)
            $params['notification'] = array_merge($params['notification'], $options);

        $result = self::send($params);

        if ($result['status']) {
            $response = json_decode($result['response'], true);
            if ($response['success'] == 1)
                return true;
            return false;
        } else
            throw new Exception($result['error']);
    }

    /**
     * @param string $to
     * @param array $data
     * @return boolean
     * @throws Exception if request has been error.
     */
    public static function sendDataToUser($to, $data)
    {
        $result = self::send([
            'to' => $to,
            'data' => $data,
        ]);

        if ($result['status']) {
            $response = json_decode($result['response'], true);
            if ($response['success'] == 1)
                return true;
            return false;
        } else
            throw new Exception($result['error']);
    }

    /**
     * @param string $group
     * @param string $title
     * @param string $body
     * @param array $options
     * @return boolean
     * @throws Exception if request has been error.
     */
    public static function sendNotificationToGroup($group, $title, $body, $options = [])
    {
        $params = [
            'to' => '/topics/' . $group,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
        ];

        /**
         * To see the options, see the following URL:
         * https://firebase.google.com/docs/cloud-messaging/http-server-ref
         */
        if ($options)
            $params['notification'] = array_merge($params['notification'], $options);

        $result = self::send($params);

        if ($result['status']) {
            $response = json_decode($result['response'], true);
            if ($response['success'] == 1)
                return true;
            return false;
        } else
            throw new Exception($result['error']);
    }

    /**
     * @param string $group
     * @param array $data
     * @return boolean
     * @throws Exception if request has been error.
     */
    public static function sendDataToGroup($group, $data)
    {
        $result = self::send([
            'to' => '/topics/' . $group,
            'data' => $data,
        ]);

        if ($result['status']) {
            $response = json_decode($result['response'], true);
            if ($response['success'] == 1)
                return true;
            return false;
        } else
            throw new Exception($result['error']);
    }

    /**
     * @param array $body
     * @return boolean
     * @throws Exception if request has been error.
     */
    public static function sendAbsolute($body)
    {
        $result = self::send($body);

        if ($result['status']) {
            $response = json_decode($result['response'], true);
            if ($response['success'] == 1)
                return true;
            return false;
        } else
            throw new Exception($result['error']);
    }
}