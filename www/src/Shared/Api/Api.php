<?php

namespace App\Shared\Api;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use stdClass;

class Api
{
    private static function post(
        string $enpoint,
        array $body
    ) {
        try {
            return (new Client())->post(self::getApiEndpoint($enpoint), [
                RequestOptions::JSON => $body,
                RequestOptions::HEADERS => [
                    'Accept' => 'application/json',
                ],
            ]);
        } catch (RequestException $th) {
            return $th->getResponse();
        }
    }

    private static function get(
        string $endpoint,
        ?string $token = null,
    ): ResponseInterface {
        $headers = [
            RequestOptions::HEADERS => [
                'Accept' => 'application/json',
            ],
        ];
        if ($token) {
            $headers[RequestOptions::HEADERS] = [
                'Authorization' => 'Bearer ' . $token,
            ];
        }

        try {
            return (new Client())->get(self::getApiEndpoint($endpoint), $headers);
        } catch (RequestException $th) {
            return $th->getResponse();
        }
    }

    private static function getApiEndpoint(string $uri): string
    {
        return $_ENV['API_URL'] . ltrim($uri, '/');
    }

    final public static function suscription(
        array $payload
    ): string {
        $url = '/api/client/web/suscription';

        $response = json_decode(self::post($url, $payload)->getBody()->getContents(), JSON_OBJECT_AS_ARRAY);
        if (isset($response['message'])) {
            return $response['message'];
        }

        $response =  'Ups! Prueba mas tarde :(';
        if (isset($response['error'])) {
            $response = $response['error'];
        }

        throw new Exception($response);
    }

    final public static function fidelizationMailingConfirm(
        string $id
    ): string {
        $url = '/api/client/web/suscription/' . $id . '/confirm';

        $response = json_decode(self::get($url)->getBody()->getContents(), JSON_OBJECT_AS_ARRAY);
        if (isset($response['message'])) {
            return $response['message'];
        }

        $response =  'Ups! Prueba mas tarde :(';
        if (isset($response['error'])) {
            $response = $response['error'];
        }

        throw new Exception($response);
    }

    final public static function contentBlogpostIndex(
        ?string $pattern = null,
        ?int $page = 1
    ): array {
        $url = '/api/client/web/list';
        if ($pattern) {
            $url = $url . '/' . $pattern;
        }
        $url = $url . '?page=' . $page;

        return json_decode(self::get($url)->getBody()->getContents(), JSON_OBJECT_AS_ARRAY);
    }

    final public static function contentBlogpostDetails(string $id): array
    {
        return json_decode(self::get('/api/client/web/detail/' . $id)->getBody()->getContents(), JSON_OBJECT_AS_ARRAY);
    }

    final public static function home(): array
    {
        return json_decode(self::get('/api/client/web/home')->getBody()->getContents(), JSON_OBJECT_AS_ARRAY);
    }

    final public static function contact(): array
    {
        return json_decode(self::get('/api/client/web/contact')->getBody()->getContents(), JSON_OBJECT_AS_ARRAY);
    }

    final public static function login(string $username, string $password): ResponseInterface
    {
        try {
            return (new Client())->post(self::getApiEndpoint('/api/login_check'), [
                RequestOptions::JSON => [
                    'email' => $username,
                    'password' => $password,
                ],
            ]);
        } catch (RequestException $th) {
            return $th->getResponse();
        }
    }
}
