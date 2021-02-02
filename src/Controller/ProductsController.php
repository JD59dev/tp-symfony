<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductsController extends AbstractController
{
    /**
     * @Route("/products", name="products")
     */
    public function index(Request $request): Response
    {

        $repository = $this->getDoctrine()->getRepository(Product::class);

        $prices = $repository->findAllWithFilters(
            $request->get('price')
        );

        return $this->render('products/index.html.twig', [
            'prices' => $prices,
        ]);
    }

    /**
     * @Route("/products/{slug}_{id}", name="products_show")
     */
    public function show(Product $property) {
        return $this->render('product/show.html.twig', [
            'property' => $property,
            'name' => $property->getName(),
        ]);
    }

    public function create(Request $request, SluggerInterface $slugger): Response {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        // Linking the form to the query (to retrieve $_POST)
        $form->handleRequest($request);

        // We must check if the form is valid and submitted
        if ($form->isSubmitted() && $form->isValid()) {
            // Here we're going to add the product in the D-base

            $slug = $slugger->slug($product->getName())->lower(); // Product's name will be product-name
            $product->setSlug($slug);

            // Upload
            /** @var UploadedFile $image */
            $image = $form->get('image')->getData(); // Retrieving the field's value
            if ($image) {
                $fileName = uniqid().'.'.$image->guessExtension();
                $image->move($this->getParameter('upload_directory'), $fileName);
                $product->setImage($product);
            } else {
                $product->setImage('default.png');
            }

            // Binding the product to the user who is connected
            $product->setBuyer($this->getUser());

            // Adding the product into the D-Base
            $entityManager = $this->getDoctrine()->getManager();
            // Put the product on hold
            $entityManager->persist($product);
            // Execute the query
            $entityManager->flush();

            // Redirect after the addition et displays a success message
            $this->addFlash('success', 'Votre produit '.$product->getId().' a bien été ajouté.');

            return $this->redirectToRoute('products');
        }
    }
}
