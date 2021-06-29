<?php

namespace App\Controller\Api;

use DateTime;
use App\Entity\PriseService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PriseServiceController extends AbstractController
{
    /**
     * @Route("/api/priseservice/", name="api_prise_service", methods={"GET"})
     * @param String $login
     * @param String $datedeb
     */
    public function connexion(Request $request, NormalizerInterface $normalizer): Response
    {
        $login = $request->query->get('login');
        $datedeb = $request->query->get('datedeb');
        $date = new DateTime();
        $valeurdate = "" . $date->getTimestamp();
        $timestamp = strtotime($datedeb);
        $tableau = null;
        $row =  $this->getService($login);
        $rowNormalize = $normalizer->normalize($row);

        // dd($rowNormalize['dateFin']);
        if ($rowNormalize['dateFin'] == "") {
            dd('ok');
            return $this->json([
                'service' => "Non",
                'priseService' => $this->getService($login)
            ], 200);
        } else {
            $prise_service = $this->priseService($login,  date("Y-m-d H:i:s", $timestamp));
            // $update = $this->updateCoordonneFirst($id_col, date("Y-m-d H:i:s"));
            return $this->json([
                'service' => "Oui",
                'priseService' => $prise_service
            ], 200);
        }
    }

    public function getService($login)
    {

        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('App\Entity\PriseService')
            ->findOneBy(['login' => $login]);
    }

    public function priseService($login, $datedeb)
    {
        $em = $this->getDoctrine()->getManager();
        //set value
        $prise_service = new PriseService();
        $prise_service->setLogin($login);
        $prise_service->setDateDebut(new \DateTime($datedeb));
        $prise_service->setStatus("1");

        $em->persist($prise_service);

        $em->flush();

        return $this->json([
            'success' => 'ok',
            'priseService' => $prise_service
        ], 200);
    }
}
