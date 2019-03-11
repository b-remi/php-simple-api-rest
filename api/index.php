<?php

use Fmk\Lang;
use Fmk\Response;

require_once 'autoload.php';

Response::set_headers();

// TODO : get lang variant from server variable (fr,en...)
$lang = 'en';
require_once "i18n/lang.{$lang}.php";
Lang::load($_lang);

// include and check all declared routes
foreach (glob("routes/*.routes.php") as $filename) {
    include $filename;
}

// no routes founds
Response::send_error(404, 'no routes found');
