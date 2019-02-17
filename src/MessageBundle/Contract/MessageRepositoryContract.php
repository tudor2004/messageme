<?php

namespace MessageBundle\Contract;

use MessageBundle\Entity\Message;

interface MessageRepositoryContract
{
    /**
     * Find all messages.
     *
     * @return array
     */
    public function findAll(): array;

    /**
     * Save a message.
     *
     * @param Message $message
     *
     * @return void
     */
    public function save(Message $message): void;
}
