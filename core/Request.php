<?php


namespace App\Core;

class Request
{
    public static function uri()
    {
        return trim(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
            '/'
        );
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function response($message = null, $code = 200)
    {
        header('Content-Type: application/json') ;
        $status = array(
            200 => '200 OK',
            400 => '400 Bad Request',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
        );

        http_response_code($status[$code]);
        return json_encode(array(
            'status' => $code,
            'data' => $message
        ), JSON_PRETTY_PRINT);
    }
}
