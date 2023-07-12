<?php

declare(strict_types=1);

namespace Codigoce\Test\Shared\Fixture;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

trait TestApiClientFactory
{
    public static string $BASE_URL       = 'http://codigito.api';
    public static string $ENDPOINT_LOGIN = '/api/login_check';

    protected function login(string $email, string $password): string
    {
        $response = $this->post(
            self::$ENDPOINT_LOGIN,
            ['json' => [
                'email'    => $email,
                'password' => $password,
            ]]
        );

        return json_decode($response->getBody()->getContents())->token;
    }

    protected function getAdminOptions(string $token): array
    {
        return [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
                'Accept'        => 'application/json',
            ],
        ];
    }

    protected function requestGetErrors(string $endpoint, array $options): array
    {
        $response = $this->get($endpoint.'NO_VALID_VALUE', $options);

        return json_decode($response->getBody()->getContents())->errors;
    }

    protected function requestGetId(string $endpoint, array $options): string
    {
        $response = $this->get($endpoint.'NO_VALID_VALUE', $options);

        return json_decode($response->getBody()->getContents())->id;
    }

    protected function delete(string $endpoint, array $options = []): ResponseInterface
    {
        return (new Client(
            [
                'verify'          => true,
                'connect_timeout' => 10,
                'read_timeout'    => 10,
                'timeout'         => 10,
                'http_errors'     => false,
            ]
        ))->request(
            'DELETE',
            self::$BASE_URL.$endpoint,
            $options
        );
    }

    protected function post(string $endpoint, array $options = []): ResponseInterface
    {
        return (new Client(
            [
                'timeout'     => 2.0,
                'http_errors' => false,
            ]
        ))->request(
            'POST',
            self::$BASE_URL.$endpoint,
            $options
        );
    }

    protected function postAsAdmin(string $endpoint, string $token, array $options = []): ResponseInterface
    {
        return $this->post(
            $endpoint,
            array_merge($options, $this->getAdminOptions($token))
        );
    }

    protected function patch(string $endpoint, array $options = []): ResponseInterface
    {
        return (new Client(
            [
                'timeout'     => 2.0,
                'http_errors' => false,
            ]
        ))->request(
            'PATCH',
            self::$BASE_URL.$endpoint,
            $options
        );
    }

    protected function patchAsAdmin(string $endpoint, string $token, array $options = []): ResponseInterface
    {
        return $this->patch(
            $endpoint,
            array_merge($options, $this->getAdminOptions($token))
        );
    }

    protected function get(string $endpoint, array $options = []): ResponseInterface
    {
        return (new Client(
            [
                'timeout'     => 2.0,
                'http_errors' => false,
            ]
        ))->request(
            'GET',
            self::$BASE_URL.$endpoint,
            $options
        );
    }

    protected function getAsAdmin(string $endpoint, string $token, array $options = []): ResponseInterface
    {
        return $this->get(
            $endpoint,
            array_merge($options, $this->getAdminOptions($token))
        );
    }
}