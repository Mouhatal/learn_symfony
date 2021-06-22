<?php

namespace App\Controller;

use App\Entity\DetailVente;
use App\Form\DetailVenteType;
use App\Repository\DetailVenteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/detail/vente")
 */
class DetailVenteController extends AbstractController
{
    /**
     * @Route("/", name="detail_vente_index", methods={"GET"})
     */
    public function index(DetailVenteRepository $detailVenteRepository): Response
    {
        return $this->render('detail_vente/index.html.twig', [
            'detail_ventes' => $detailVenteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="detail_vente_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $detailVente = new DetailVente();
        $form = $this->createForm(DetailVenteType::class, $detailVente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($detailVente);
            $entityManager->flush();

            return $this->redirectToRoute('detail_vente_index');
        }

        return $this->render('detail_vente/new.html.twig', [
            'detail_vente' => $detailVente,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="detail_vente_show", methods={"GET"})
     */
    public function show(DetailVente $detailVente): Response
    {
        return $this->render('detail_vente/show.html.twig', [
            'detail_vente' => $detailVente,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="detail_vente_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DetailVente $detailVente): Response
    {
        $form = $this->createForm(DetailVenteType::class, $detailVente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('detail_vente_index');
        }

        return $this->render('detail_vente/edit.html.twig', [
            'detail_vente' => $detailVente,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="detail_vente_delete", methods={"POST"})
     */
    public function delete(Request $request, DetailVente $detailVente): Response
    {
        if ($this->isCsrfTokenValid('delete'.$detailVente->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($detailVente);
            $entityManager->flush();
        }

        return $this->redirectToRoute('detail_vente_index');
    }
}
