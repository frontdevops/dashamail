<?php declare(strict_types=1);

namespace DashaMail;

class CurlStub
{
    public static string $initUrl = '';
    public static array $options = [];
    public static string|false $response = '';
    public static string $error = '';
    public static int $httpCode = 200;
    public static bool $closed = false;

    public static function reset(): void
    {
        self::$initUrl = '';
        self::$options = [];
        self::$response = '';
        self::$error = '';
        self::$httpCode = 200;
        self::$closed = false;
    }
}

function curl_init(string $url)
{
    CurlStub::$initUrl = $url;
    return 'curl';
}

function curl_setopt_array($ch, array $options): void
{
    CurlStub::$options = $options;
}

function curl_exec($ch)
{
    return CurlStub::$response;
}

function curl_error($ch): string
{
    return CurlStub::$error;
}

function curl_getinfo($ch, $opt)
{
    return CurlStub::$httpCode;
}

function curl_close($ch): void
{
    CurlStub::$closed = true;
}

