<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Produit;
use Doctrine\ORM\EntityManager;

class ProduitPersster implements DataPersisterInterface
{

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    public function supports($data): bool
    {
        return $data instanceof Produit;
    }

    public function persist($data)
    {
        $data->setCreatedAt(new \DateTime());

        $this->em->persist($data);

        $this->em->flush();
    }

    public function remove($data)
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}
