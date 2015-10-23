<?php

namespace Meetupos\AuthApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MeetuposAuthApiBundle:Default:index.html.twig', array('name' => $name));
    }
}
