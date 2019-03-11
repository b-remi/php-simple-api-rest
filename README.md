php-simple-api-rest
==============

Php-simple-api-rest is a very simple and fast PHP framework to serve REST API with Json body response and html status code.
No more dependency or install required, just clone this repository and start coding your api server.


Installation
------------

 - clone or download the repository
 - update the `.htaccess` if you are using apache or make your rewrite rule depend on server configuration
 - goto `api/routes/` directory and make your own `.routes.php`
 - don't forget to delete the `example.routes.php` file


Include in Framework
------------

  - `Fmk\Lang` : Translator system to serve text to client in the specific language
  - `Fmk\DB` : coming soon...
  - `Fmk\JWT` : coming soon...
  - `Fmk\FCM` : coming soon...


Usage
------------

### show the example.routes.php


```php

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


```


License
------------

Licensed under the MIT License. See the LICENSE file for more details.

