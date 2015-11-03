<?php

namespace Meetupos\ApiBundle\Controller;

use Meetupos\Application\Command\SignUp;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\Annotations\View;
use JMS\Serializer\SerializationContext;

class UserController
{
    public function indexAction($name)
    {
        die($name);
    }
    
    /**
     * Create a new User
     *      
     * @ApiDoc(
     *   section = "Contacts",
     *   resource = true
     * )
     *
     */
    public function postUserAction(Request $request)
    {
        $json = <<<"JSON"
{
    "firstname": "Javier",
    "lastname": "Seixas",
    "email": "javier@realfunding.com",
    "password": "1234"
}
JSON;

        $json = json_decode($json, true);

        $command = new SignUp(
            $json['firstname'],
            $json['lastname'],
            $json['email'],
            $json['password']
        );

        $this->get('command_bus')->handle($command);

        $view = $this->view();
        $view->setStatusCode(Response::HTTP_CREATED);
        $sc = SerializationContext::create();
        $sc->setGroups(array('self'));
        $view = $view->setSerializationContext($sc);

        return $this->handleView($view);
    }
}