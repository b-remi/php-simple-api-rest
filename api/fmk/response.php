<?php

namespace Fmk;

class Response
{
    private static $datas = array();

    public static function set_headers()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");
        header("Access-Control-Allow-Headers: X-Requested-With,content-type,x-access-token");
    }

    public static function add_data($key, $value)
    {
        self::$datas[$key] = $value;
    }

    public static function send_json($data)
    {
        $response = self::encode_response($data);
        self::send(200, $response);
    }

    public static function send_error($code, $message = '')
    {
        if (!empty($message)) {
            $response = self::encode_response(array('message' => $message));
        } else {
            $response = self::encode_response(array());
        }

        self::send($code, $response);
    }

    private static function encode_response($data)
    {
        $oData = (object) $data;
        if (!empty(self::$datas)) {
            foreach (self::$datas as $key => $value) {
                $oData->$key = $value;
            }
        }
        $jsonData = json_encode($oData);
        if (json_last_error() !== 0) {
            throw new \Exception('JSON encode error - ' . json_last_error_msg());
        }
        return $jsonData;
    }

    private static function send($code, $response)
    {
        http_response_code($code);

        if (!empty($response)) {
            echo $response;
        }

        exit();
    }
}
