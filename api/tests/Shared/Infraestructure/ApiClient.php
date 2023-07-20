<?php

declare(strict_types=1);

namespace Codigito\Tests\Shared\Infraestructure;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class ApiClient
{
    public function login(string $email, string $password): string
    {
        $response = $this->post(
            '/api/login_check',
            ['json' => [
                'email'    => $email,
                'password' => $password,
            ]]
        );

        return json_decode($response->getBody()->getContents())->token;
    }

    public function getAdminOptions(string $token): array
    {
        return [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
                'Accept'        => 'application/json',
            ],
        ];
    }

    public function requestGetErrors(string $endpoint, array $options): array
    {
        $response = $this->get($endpoint.'NO_VALID_VALUE', $options);

        return json_decode($response->getBody()->getContents())->errors;
    }

    public function requestGetId(string $endpoint, array $options): string
    {
        $response = $this->get($endpoint.'NO_VALID_VALUE', $options);

        return json_decode($response->getBody()->getContents())->id;
    }

    public function delete(string $endpoint, array $options = []): ResponseInterface
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
            $this->composeEndpointUrl($endpoint),
            $options
        );
    }

    public function post(string $endpoint, array $options = []): ResponseInterface
    {
        return (new Client(
            [
                'timeout'     => 2.0,
                'http_errors' => false,
            ]
        ))->request(
            'POST',
            $this->composeEndpointUrl($endpoint),
            $options
        );
    }

    public function postAsAdmin(string $endpoint, string $token, array $options = []): ResponseInterface
    {
        return $this->post(
            $endpoint,
            array_merge($options, $this->getAdminOptions($token))
        );
    }

    public function patch(string $endpoint, array $options = []): ResponseInterface
    {
        return (new Client(
            [
                'timeout'     => 2.0,
                'http_errors' => false,
            ]
        ))->request(
            'PATCH',
            $this->composeEndpointUrl($endpoint),
            $options
        );
    }

    public function patchAsAdmin(string $endpoint, string $token, array $options = []): ResponseInterface
    {
        return $this->patch(
            $endpoint,
            array_merge($options, $this->getAdminOptions($token))
        );
    }

    public function get(string $endpoint, array $options = []): ResponseInterface
    {
        return (new Client(
            [
                'timeout'     => 2.0,
                'http_errors' => false,
            ]
        ))->request(
            'GET',
            $this->composeEndpointUrl($endpoint),
            $options
        );
    }

    public function getAsAdmin(string $endpoint, string $token, array $options = []): ResponseInterface
    {
        return $this->get(
            $endpoint,
            array_merge($options, $this->getAdminOptions($token))
        );
    }

    public function composeEndpointUrl($uri): string
    {
        return $_ENV['API_URL'].ltrim($uri, '/');
    }
}
