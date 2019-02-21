<?php

namespace MessageBundle\Controller;

use MessageBundle\Contract\MessageRepositoryContract;
use MessageBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;

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
        return new Response($this->get('jms_serializer')
                                 ->serialize($this->repo->findAll(), 'json'));
    }

    public function createAction(Request $request)
    {
        $validator = $this->get('validator');

        $message = new Message();

        $message->setSender($request->get('sender'))
                ->setBody($request->get('body'));

        $errors = $validator->validate($message);

        if (count($errors) > 0) {
            $errorList = [];

            /** @var ConstraintViolation $error */
            foreach ($errors as $error) {
                $errorList[] = $error->getMessage();
            }

            return new JsonResponse([
                'type'   => 'validation_errors',
                'errors' => $errorList,
            ], 400);
        }

        $this->repo->save($message);

        return new Response($this->get('jms_serializer')
                                 ->serialize($message, 'json'));
    }
}
