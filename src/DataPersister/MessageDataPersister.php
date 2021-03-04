<?php

// src/DataPersister

namespace App\DataPersister;

use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class MessageDataPersister implements ContextAwareDataPersisterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $_entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->_entityManager = $entityManager;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Message;
    }

    public function persist($data, array $context = [])
    {

        $data->setDatetime(new \Datetime());
        
        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
    }

    public function remove($data, array $context = [])
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
}