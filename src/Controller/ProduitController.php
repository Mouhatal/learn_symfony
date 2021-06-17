<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Category;
use App\Form\ProduitType;
use App\Repository\CategoryRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/", name="produit_index", methods={"GET","POST"})
     */
    public function index(ProduitRepository $produitRepository, Request $request): Response
    {
        $categories = $produitRepository->getCategories();
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('produit_index');
        }

        // return $this->render('produit/new.html.twig', [
        //     'produit' => $produit,
        //     'form' => $form->createView(),
        // ]);
        return $this->render('produit/index.html.twig', [
            // 'categories' => $categoryRepository->findAll(),
            'categories' => $categories,
            'produit' => $produit,
            'form' => $form->createView(),
            'produits' => $produitRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="produit_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/add", name="addAction", methods={"GET","POST"})
     */
    public function addAction(CategoryRepository $categoryRepository, ProduitRepository $produitRepository, Request $request): Response
    {
        $categories = $produitRepository->getCategories();
        // $category_id=$produitRepository->findByCategoryId($request->get('category'));


        // $request = $this->get('request');

        // ($request->get('name'));

        // dd($category);
        if ($request->getMethod() == 'POST' && $_POST['name'] != null) {
            // Récupération de la valeur ici
            $produit = new Produit();
            $name = $request->get('name');
            $cost = $request->get('cost');
            $created_at = $request->get('created_at');
            $entityManager = $this->getDoctrine()->getManager();
            // dd($request->get('category'));
            // ->$request->get('category')
            // $category = $produit->getCategory();
            // $category = $entityManager->getRepository('App\Entity\Category')->findOneBy(array('id' => $request->get('category')));
            $category = $categoryRepository->findByCategoryId($request->get('category'));
            $produit->setName($name);
            $produit->setCost($cost);
            $produit->setCreatedAt(new \DateTime($created_at));
            $produit->setCategory($category);
            // dd($produit);
            $entityManager->persist($produit);
            $entityManager->flush();
            return $this->redirectToRoute('produit_index', ['produits' => $produitRepository->findAll()]);
        } else {
            return $this->redirectToRoute('produit_index', ['produits' => $produitRepository->findAll()]);
        }

        // dd('ici');
        // if ($form->isSubmitted() && $form->isValid()) {
        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($produit);
        //     $entityManager->flush();

        //     // dd('ici');
        //     return $this->redirectToRoute('produit_index', ['produits' => $produitRepository->findAll()]);
        // }

        // dd('la');
        return $this->render('produit/index.html.twig', [
            'categories' => $categories,
            'produits' => $produitRepository->findAll(),

        ]);
        // return $this->render('category/index.html.twig', [
        //     'categories' => $categoryRepository->findAll(),
        // ]);
    }

    /**
     * @Route("/{id}", name="produit_show", methods={"GET"})
     */
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="produit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Produit $produit): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="produit_delete", methods={"POST"})
     */
    public function delete(Request $request, Produit $produit): Response
    {
        if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('produit_index');
    }
}
