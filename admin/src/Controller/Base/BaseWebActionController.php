<?php

declare(strict_types=1);

namespace App\Controller\Base;

use Psr\Http\Message\ResponseInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseWebActionController extends AbstractController
{
    private const TITLE = '{.".} ~ Codigo';
    private const TITLE_SHORT = '{.".}';
    private const AUTHOR = '{.".}~mArKit0s~{.".}';
    private ?int $tokenTimeout = null;
    private ?string $token = null;

    public function __construct(RequestStack $requestStack)
    {
        $session = $requestStack->getCurrentRequest()->getSession();

        $this->tokenTimeout = $session->get('token_timeout', null);
        $this->token = $session->get('token', null);
    }

    protected function getCdnUrl(?string $uri = null): string
    {
        return $_ENV['CDN_URL'].'/cdn/'.$uri;
    }

    protected function getToken(): string|null
    {
        return $this->token;
    }

    protected function getRender(
        string $view,
        array $model,
        string $menu,
        ?string $submenu = null
    ): Response {
        $jsFileForView = str_replace('.html.twig', '.js.html.twig', $view);
        $jsFileEmptyForInclude = '/shared/empty.html.twig';
        $jsFileForInclude = $jsFileEmptyForInclude;
        if (file_exists($this->getParameter('kernel.project_dir').DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$jsFileForView)) {
            $jsFileForInclude = DIRECTORY_SEPARATOR.$jsFileForView;
        }

        $model['title'] = self::TITLE;
        $model['title_short'] = self::TITLE_SHORT;
        $model['author'] = self::AUTHOR;
        $model['menu'] = $menu;
        $model['submenu'] = $submenu;
        $model['js_include'] = $jsFileForInclude;

        return $this->render($view, $model);
    }

    protected function extractErrorsFromResponseIfApply(ResponseInterface $response): array
    {
        $result = [];

        try {
            $data = json_decode($response->getBody()->getContents());
            if (is_object($data) && isset($data->errors) && count($data->errors) > 0) {
                $result = $data->errors;
            }
            if (is_object($data) && isset($data->code) && $data->code >= 400) {
                $result = [$data->message];
            }
        } finally {
        }

        return $result;
    }
}
