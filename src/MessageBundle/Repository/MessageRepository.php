<?php

namespace MessageBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;
use MessageBundle\Contract\MessageRepositoryContract;
use MessageBundle\Entity\Message;
use Doctrine\Common\Persistence\ObjectRepository ;

class MessageRepository implements MessageRepositoryContract
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ObjectRepository
     */
    private $objectRepo;

    /**
     * MessageRepository constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->objectRepo = $this->em->getRepository(Message::class);
    }

    /**
     * @inheritdoc
     */
    public function findAll(): array
    {
        return $this->objectRepo->findAll();
    }

    /**
     * @inheritdoc
     */
    public function save(Message $message): void
    {
        $this->em->persist($message);
        $this->em->flush();
    }
}