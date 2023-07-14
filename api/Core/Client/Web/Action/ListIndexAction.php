<?php

declare(strict_types=1);

namespace Core\Client\Web\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Core\\Shared\Domain\Filter\Page;
use Symfony\Component\Routing\Annotation\Route;

class ListIndexAction extends BaseAction
{
    #[Route('/api/client/web/list/{pattern?}', name: 'client_web_list_index', methods: ['GET'])]
    public function execute(
        ?string $pattern = null,
        Request $request
    ): Response {
        $page = (int) $request->query->get('page', Page::FIRST_PAGE);
        if (false === is_numeric($page)) {
            $page = Page::FIRST_PAGE;
        }

        $previousPage = null;
        if ($page > 1) {
            $previousPage = $page - 1;
        }

        return $this->json([
            'blogposts'        => $this->getBlogposts($pattern, $page),
            'tags'             => $this->getTags(),
            'selected_pattern' => $pattern,
            'current_page'     => $page,
            'previous_page'    => $previousPage,
            'next_page'        => $page + 1,
        ]);
    }
}
