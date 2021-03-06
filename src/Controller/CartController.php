<?php

namespace App\Controller;

use App\Entity\Product;
use SuperCart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(): Response
    {
        return $this->render('cart/index.html.twig');
    }
}
