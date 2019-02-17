<?php

namespace MessageBundle\Controller;

use MessageBundle\Contract\MessageRepositoryContract;
use MessageBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @var MessageRepositoryContract
     */
    private $repo;

    /**
     * @param MessageRepositoryContract $repo
     */
    public function __construct(MessageRepositoryContract $repo)
    {
        $this->repo = $repo;
    }

    public function indexAction()
    {
        return new Response($this->get('jms_serializer')->serialize($this->repo->findAll(), 'json'));
    }

    public function createAction(Request $request)
    {
        // TODO return data
    }
}
