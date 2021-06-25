<?php

namespace App\Controller\Api;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ProductController extends AbstractController
{
    /**
     * @Route("/api/product", name="api_product_index",methods={"GET"})
     */
    public function index(ProduitRepository $produitRepository/* , SerializerInterface $serializer */): Response
    {

        $product = $produitRepository->findAll();

        // $productNormalise = $normalize->normalize($product);

        // $json = json_encode($productNormalise);

        // $json = $serializer->serialize($product, 'json');

        // // $response = new Response($json, 200, [
        // //     "Content-Type" => "application/json"
        // // ]);

        // $response = new JsonResponse($json, 200, [], true);

        $response = $this->json($product, 200, []);

        return $response;
    }
}
