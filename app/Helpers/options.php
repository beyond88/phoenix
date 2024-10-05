<?php

use App\Models\Option;

if (!function_exists('add_option')) {
    function add_option($name, $value)
    {
        return Option::add($name, $value);
    }
}

if (!function_exists('update_option')) {
    function update_option($name, $value)
    {
        return Option::updateOption($name, $value);
    }
}

if (!function_exists('get_option')) {
    function get_option($name, $default = null)
    {
        return Option::getOption($name, $default);
    }
}

if (!function_exists('delete_option')) {
    function delete_option($name)
    {
        return Option::deleteOption($name);
    }
}