<?php

declare(strict_types=1);

namespace App\Controller\Contact;

use App\Controller\Base\BaseWebActionController;
use App\Shared\Api\Api;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactIndexController extends BaseWebActionController
{
    #[Route('/contact', name: 'contact_index', methods: ['GET'])]
    public function execute(Request $request): Response
    {
        return $this->getRender('contact/index.html.twig', Api::contact());
    }
}
