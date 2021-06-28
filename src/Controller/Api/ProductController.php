<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
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

        $response = $this->json([
            'message' => 'ok',
            'products' => $product
        ], 200, []);

        return $response;
    }


    /**
     * @Route("/api/product",name="add_product", methods={"POST"})
     */
    public function store(Request $request, SerializerInterface $serializer)
    {
        $jsonRecu = $request->getContent();

        $data = \json_decode($jsonRecu, true);

        try {
            $product = $serializer->deserialize($jsonRecu, Produit::class, 'json');

            $product->setCreatedAt(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();

            $category =  $entityManager->getRepository('App\Entity\Category')->findOneBy(['id' => $data['category_id']]);
            $product->setCategory($category);

            $entityManager->persist($product);

            $entityManager->flush();

            $response = $this->json([
                'message' => 'Product created',
                'product' => $product
            ], 201, []);

            return $response;
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
