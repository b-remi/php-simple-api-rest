<?php

spl_autoload_register(function ($class_name) {
    require_once dirname(__FILE__) . '/' . str_replace('\\', '/', strtolower($class_name)) . '.php';
});
