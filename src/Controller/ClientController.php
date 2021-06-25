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
        $date = $request->get('date');


        $response = $client->get('localhost:3000/apitranspaytest/index.php/api/connexion?login=' . $login . '&datedeb=' . $date->format('Y-m-d H:i:s'));

        $data = json_decode($response->getBody()->getContents(), true);

        if ($data['service'] == 'Non') {
            $msg = 'Vous avez déjà un service en cours';
            return $this->render('client/response.html.twig', [
                'response' => $msg,
            ]);
        } else {
            return $this->redirectToRoute('getallservice');
        }
    }

    /**
     * @Route( "/services" ,name="getallservice" ,methods={"GET","POST"})
     */
    public function getAllService(Request $request, Client $client): Response
    {


        $base_uri = 'localhost:3000/apitranspaytest/index.php/api/';
        $response = $client->get($base_uri . 'services');
        $data = json_decode($response->getBody()->getContents(), true);
        $services = array();
        foreach ($data['priseService'] as $item) {
            $services[] = array(
                'cat' => $item,
            );
        }
        return $this->render('client/show.html.twig', [
            'controller_name' => 'ClientController',
            'services' => $services
        ]);
    }
}
