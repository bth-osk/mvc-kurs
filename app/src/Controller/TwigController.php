<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TwigController extends AbstractController
{

    #[Route("/", name: "index")]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route("/lucky", name: "lucky")]
    public function lucky(): Response
    {
        $rand_int = random_int(1, 50);

        if ($rand_int <= 15) {
            $lucky_class = "unlucky";
            $lucky_image = "lucky1.png";
        } elseif ($rand_int > 15 && $rand_int < 25) {
            $lucky_class = "lucky";
            $lucky_image = "lucky2.png";
        } else {
            $lucky_class = "too-lucky";
            $lucky_image = "lucky3.png";
        }

        $data = [
            'number' => $rand_int,
            'lucky_class' => $lucky_class,
            'lucky_image' => $lucky_image
        ];

        return $this->render('lucky.html.twig', $data);
    }

    #[Route("/api", name: "api")]
    public function apiOverview(): Response
    {
        return $this->render('api.html.twig');
    }
}
