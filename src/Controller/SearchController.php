<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("api/search/{query}", name="api_search")
     */
    public function index($query = '', ProductRepository $repository): Response
    {
        // Searching for products thanks to the Repository
        $products = $repository->search($query);
        // Returning JSON because it's an API
        return $this->json([
            'html' => $this->renderView('product/_product.html.twig',
                ['products' => $products]),
        ]);
    }
}
