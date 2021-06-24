<?php

namespace App\Controller;

use DateTime;
use GuzzleHttp\Client;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;

class ClientController extends AbstractController
{

    /**
     * @Route("/client", name="client")
     */
    public function index(): Response
    {
        // $client = $this->get('csa_guzzle.client.api_transpay');
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    /**
     * @Route( name="getService" ,methods={"GET","POST"})
     */
    public function getService(Request $request, Client $client): Response
    {

        $login = $request->get('login');
        $date = new DateTime();
        $response = $client->get('localhost:3000/apitranspaytest/index.php/api/connexion?login=' . $login . '&datedeb=' . $date->format('Y-m-d H:i:s'));

        dd($response);
        // if ($result == "") {
        //     $temp = $result;
        //     dd($temp);
        // }
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
            'response' => json_encode($response)
        ]);
    }
}
