<?php

declare(strict_types=1);

namespace App\Controller\Content\Blogpost;

use App\Controller\Base\BaseWebActionController;
use App\Shared\Api\Api;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContentBlogpostCreateController extends BaseWebActionController
{
    #[Route('/content/blogpost/create', name: 'content_blogpost_create', methods: ['GET', 'POST'])]
    public function execute(Request $request): Response
    {
        $responseFromSubmit = $this->analyzeSubmitAndRequestRedirectIfApplyt($request);
        if (is_object($responseFromSubmit)) {
            return $responseFromSubmit;
        }

        return $this->getRender('/content/blogpost/create.html.twig', [
            'tags' => json_decode(Api::contentTagAll($this->getToken())->getBody()->getContents())->tags,
        ], 'tag');
    }

    private function analyzeSubmitAndRequestRedirectIfApplyt(Request $request): ?Response
    {
        if ('do_submit' !== $request->get('do_submit')) {
            return null;
        }

        $base64Cover = base64_encode(file_get_contents($request->files->get('imagen')->getPathname()));
        $youtube = $request->request->get('youtube');
        $name = $request->request->get('name');
        $tags = implode(',', $request->get('tags'));
        $response = Api::contentBlogpostCreate(
            $this->getToken(),
            $tags,
            $base64Cover,
            $youtube,
            $name
        );
        $id = json_decode($response->getBody()->getContents())->id;
        if (Response::HTTP_CREATED !== $response->getStatusCode()) {
            $errors = $this->extractErrorsFromResponseIfApply($response);
            $this->addFlash(
                'error',
                'Error creando blog post!. detalles: '
                    . implode("\n", $errors)
            );

            return null;
        }

        $this->addFlash(
            'info',
            'Recurso creado!'
        );

        return $this->redirectToRoute('content_blogcontent_index', ['blogpost_id' => $id]);
    }
}
