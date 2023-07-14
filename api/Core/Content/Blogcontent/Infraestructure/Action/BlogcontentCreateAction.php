<?php

declare(strict_types=1);

namespace Core\Content\Blogcontent\Infraestructure\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Core\Shared\Domain\Helper\ParametersValidator;
use Core\Shared\Infraestructure\Action\BaseAction;
use Core\Content\Shared\Domain\ValueObject\BlogpostId;
use Core\Shared\Infraestructure\Command\CommandStaticBus;
use Core\Content\Blogcontent\Domain\ValueObject\BlogcontentId;
use Core\Content\Blogcontent\Domain\ValueObject\BlogcontentHtml;
use Core\Content\Blogcontent\Domain\ValueObject\BlogcontentYoutube;
use Core\Content\Blogcontent\Domain\ValueObject\BlogcontentBase64Image;
use Core\Content\Blogcontent\Application\BlogcontentCreate\BlogcontentCreateCommand;
use Core\Content\Blogcontent\Domain\Exception\InvalidBlogcontentCreateEmptyRequestException;

class BlogcontentCreateAction extends BaseAction
{
    public function __construct(
        private readonly CommandStaticBus $bus
    ) {
    }

    #[Route('/api/admin/content/blogposts/{blogpost_id}/blogcontents', name: 'content_blogcontents_create', methods: ['POST'])]
    public function execute(
        string $blogpost_id,
        Request $request
    ): Response {
        $this->setParametersFromRequest(
            $request,
            [
                'html'        => '',
                'base64image' => '',
                'youtube'     => '',
            ]
        );
        $errors = $this->validateParameters($blogpost_id);
        if (count($errors) > 0) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $this->parameters['id'] = BlogcontentId::random()->value;
        try {
            $this->bus->execute($this->createCommandFromParameters());

            $result = $this->json(
                ['id' => $this->parameters['id']],
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            $result = $this->getErrorResponseFromException($th);
        }

        return $result;
    }

    private function validateParameters(string $blogpost_id): array
    {
        if (isset($this->parameters['youtube']) && '' === $this->parameters['youtube']) {
            unset($this->parameters['youtube']);
        }
        if (isset($this->parameters['html']) && '' === $this->parameters['html']) {
            unset($this->parameters['html']);
        }
        if (isset($this->parameters['base64image']) && '' === $this->parameters['base64image']) {
            unset($this->parameters['base64image']);
        }

        $hasYoutube     = (isset($this->parameters['youtube']) && '' !== $this->parameters['youtube']);
        $hasHtml        = (isset($this->parameters['html']) && '' !== $this->parameters['html']);
        $hasBase64Image = (isset($this->parameters['base64image']) && '' !== $this->parameters['base64image']);
        $hasContent     = ($hasHtml || $hasBase64Image || $hasYoutube);
        if (false === $hasContent) {
            return [InvalidBlogcontentCreateEmptyRequestException::PREFIX.' '.$blogpost_id];
        }
        $validator = new ParametersValidator();
        $validator->register('blogpost_id', BlogpostId::class);

        if ($hasYoutube) {
            $validator->register('youtube', BlogcontentYoutube::class);
        }
        if ($hasHtml) {
            $validator->register('html', BlogcontentHtml::class);
        }
        if ($hasBase64Image) {
            $validator->register('base64image', BlogcontentBase64Image::class);
        }

        $this->parameters['blogpost_id'] = $blogpost_id;

        return $validator->validate($this->parameters);
    }

    private function createCommandFromParameters(): BlogcontentCreateCommand
    {
        $youtube = null;
        if (isset($this->parameters['youtube'])) {
            $youtube = $this->parameters['youtube'];
        }
        $html = null;
        if (isset($this->parameters['html'])) {
            $html = $this->parameters['html'];
        }
        $base64image = null;
        if (isset($this->parameters['base64image'])) {
            $base64image = $this->parameters['base64image'];
        }

        return new BlogcontentCreateCommand(
            $this->parameters['id'],
            $this->parameters['blogpost_id'],
            $html,
            $base64image,
            $youtube
        );
    }
}
