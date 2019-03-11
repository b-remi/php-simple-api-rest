<?php

/*
 * all files includes routes need to have a name ended with '.routes.php' for auto-include in index.php
 */

use Fmk\Lang;
use Fmk\Response;
use Fmk\Router;

Router::get_route_match('/test/', array(), function ($params) {

    try {
        Response::send_json(array(
            'success' => true,
            'message' => Lang::get('GetTestResultWithoutParams'),
        ));
    } catch (\Exception $e) {
        Response::send_error(500, $e->getMessage());
    }
});

Router::get_route_match('/test/{id}', array('id'), function ($params) {
    try {
        Response::send_json(array(
            'success' => true,
            'message' => Lang::get('GetTestResultWithParams', $params->id),
        ));
    } catch (\Exception $e) {
        Response::send_error(500, $e->getMessage());
    }
});

Router::post_route_match('/add/', array('id', 'name'), function ($params) {
    try {
        // you can also add a specific data in the response when you want (before send the response)
        Response::add_data('anotherMessage', Lang::get('AntoherMessage'));

        // and send the final result after
        Response::send_json(array(
            'success' => true,
            'message' => Lang::get('PostTestResult', $params->id, $params->name),
        ));
    } catch (\Exception $e) {
        Response::send_error(500, $e->getMessage());
    }
});

Router::put_route_match('/update/{id}', array('id'), function ($params) {
    try {
        Response::send_json(array(
            'success' => true,
            'message' => Lang::get('PutTestResult', $params->id),
        ));
    } catch (\Exception $e) {
        Response::send_error(500, $e->getMessage());
    }
});

Router::delete_route_match('/remove/{id}', array('id'), function ($params) {
    try {
        Response::send_json(array(
            'success' => true,
            'message' => Lang::get('DeleteTestResult', $params->id),
        ));
    } catch (\Exception $e) {
        Response::send_error(500, $e->getMessage());
    }
});
