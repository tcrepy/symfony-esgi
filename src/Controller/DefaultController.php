<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package App\Controller
 * @Route(name="app_default_")
 */
class DefaultController extends AbstractController
{
    /**
     * @return Response
     * @Route(name="index", path="/", methods={"GET"})
     */
    public function index()
    {
        return $this->render(
            'default/index.html.twig',
            ['bar' => 'foo']
        );
    }

    /**
     * @return Response
     * @Route(name="say_my_name", path="/say-my-name/{name}", methods={"GET"})
     */
    public function sayMyName($name = 'User')
    {
        return $this->render('default/say-my-name.html.twig', ['name' => $name]);
    }
}