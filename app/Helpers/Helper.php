<?php
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

if (!function_exists('route_qs')) {
    function route_qs($name, $parameters = [], $absolute = true, $qs = [])
    {
        return Str::finish(route($name, $parameters, $absolute), '?') . Arr::query($qs);
    }
}


