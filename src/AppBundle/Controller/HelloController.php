<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HelloController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/hello/{name}", name="hello")
     */
    public function helloAction(Request $request, $name = "rom2")
    {

        return $this->render('hello/hello.html.twig', array(
            'name'=> $name,
        ));
    }
}
