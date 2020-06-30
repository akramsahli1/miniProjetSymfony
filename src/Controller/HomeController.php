<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/home",name="home")
     */
    public function index(): Response
    {
        return $this->render('pages/home.html.twig',[
        ]);
    }
    /**
     * @Route("/contact",name="contact")
     */
    public function contact(): Response
    {
        return $this->render('pages/contact.html.twig',[
        ]);
    }

}
?>