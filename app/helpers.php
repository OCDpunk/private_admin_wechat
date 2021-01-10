<?php

if (!function_exists('result')) {
    function result(int $status = 200, string $msg = '', array $data = [], array $headers = [], $options = 0)
    {
        return response()->json(['code' => $status, 'msg' => $msg, 'data' => $data], $status, $headers, $options);
    }
}
