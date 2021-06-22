<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\DetailVente;
use App\Entity\Facture;
use App\Form\DetailVenteType;
use App\Repository\ProduitRepository;
use App\Repository\DetailVenteRepository;
use PhpParser\Node\Expr\Cast\Double;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/vente")
 */
class DetailVenteController extends AbstractController
{
    /**
     * @Route("/", name="detail_vente_index", methods={"GET"})
     */
    public function index(DetailVenteRepository $detailVenteRepository, ProduitRepository $produitRepository): Response
    {
        return $this->render('detail_vente/index.html.twig', [
            'detail_ventes' => $detailVenteRepository->findAll(),
            'produits' => $produitRepository->findAll(),
        ]);
    }
    /**
     * @Route("/add", name="addPanierAction", methods={"GET","POST"})
     */
    public function addPanierAction(Request $request): Response
    {


        if ($request->getMethod() == 'POST') {
            // Récupération de la valeur ici
            // $produit = new Produit();
            $facture = new Facture;
            $detailVente = new DetailVente;
            $quantite = $request->get('quantite');
            $pu = (float) $request->get('pu');
            $nomClient = $request->get('name');
            $tel = (string)$request->get('numClient');
            dd($tel);
            $date = new \DateTime('@' . strtotime('now'));


            $entityManager = $this->getDoctrine()->getManager();
            $produit = $this->getDoctrine()->getManager()->getRepository('App\Entity\Produit')
                ->findOneBy(['id' => $request->get('produit')]);
            $montant = $pu * $quantite;

            // persiste 
            $facture->setClient($nomClient);
            $facture->setNumClient($tel);
            $facture->setMontant($montant);
            $facture->setDateFacture($date);
            $entityManager->persist($facture);
            $entityManager->flush();

            if ($facture->getId()) {
                $detailVente->setFacture($facture);
                $detailVente->setQuantite($quantite);
                $detailVente->setPu($pu);
                $detailVente->setProduit($produit);
                $entityManager->persist($detailVente);
                $entityManager->flush();
            }
            //dd($detailVente);

            //return $this->redirectToRoute('produit_index', ['produits' => $produitRepository->findAll()]);
        } else {
            //return $this->redirectToRoute('produit_index', ['produits' => $produitRepository->findAll()]);
        }


        return $this->render('detail_vente/index.html.twig', [
            'detail_ventes' => $this->getDoctrine()->getManager()->getRepository('App\Entity\Produit')
                ->findAll(),
            'produits' => $this->getDoctrine()->getManager()->getRepository('App\Entity\Produit')->findAll()
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
        if ($this->isCsrfTokenValid('delete' . $detailVente->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($detailVente);
            $entityManager->flush();
        }

        return $this->redirectToRoute('detail_vente_index');
    }
}
