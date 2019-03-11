<?php

namespace Fmk;

use Fmk\Response;

class Router
{
    public static function get_route_match($value, $requiredParams, $callback)
    {
        return self::route_match('GET', $value, $requiredParams, $callback);
    }

    public static function post_route_match($value, $requiredParams, $callback)
    {
        return self::route_match('POST', $value, $requiredParams, $callback);
    }

    public static function put_route_match($value, $requiredParams, $callback)
    {
        return self::route_match('PUT', $value, $requiredParams, $callback);
    }

    public static function delete_route_match($value, $requiredParams, $callback)
    {
        return self::route_match('DELETE', $value, $requiredParams, $callback);
    }

    private static function route_match($type, $value, $requiredParams, $callback)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method !== 'OPTIONS' && $method !== $type) {
            return false;
        }

        $route = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        if ($method === 'POST' || $method === 'PUT') {
            $request_body = file_get_contents('php://input');
            $params = (object) array_merge($_REQUEST, (array) json_decode($request_body));
        } else {
            $params = (object) $_REQUEST;
        }

        $arr_regexp = array();
        $arr_params_id = array();
        $arr = explode('/', $value);
        foreach ($arr as $check) {
            if (empty($check)) {
                continue;
            }

            $matches = array();
            if (preg_match('/^\{(.*)\}$/', $check, $matches) === 1) {
                $arr_regexp[] = '([^\/]+)';
                $arr_params_id[] = $matches[1];
            } else {
                $arr_regexp[] = $check;
            }
        }

        $regexp = '/^[\/]{0,1}' . implode('\/', $arr_regexp) . '[\/]{0,1}$/';
        $matches = array();
        if (preg_match($regexp, $route, $matches) == 1) {
            for ($i = 0; $i < count($arr_params_id); $i++) {
                $params->{$arr_params_id[$i]} = $matches[$i + 1];
            }
            if ($method === 'OPTIONS') {
                Response::send_json(array('success' => true));
            } else {
                if (!empty($requiredParams)) {
                    foreach ($requiredParams as $name) {
                        if (!isset($params->{$name})) {
                            Response::send_error(400, 'bad request');
                        }
                    }
                }
                call_user_func($callback, $params);
            }
            return true;
        }

        return false;
    }
}
