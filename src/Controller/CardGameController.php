<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card")]
    public function home(): Response
    {
        return $this->render('card/home.html.twig');
    }
    
    #[Route("/session", name: "session")]
    public function session(
        SessionInterface $session
    ): Response
    {
            $data = [
                "session" => $session->all()
            ];

        return $this->render('card/session.html.twig', $data);
    }

    #[Route("/session/delete", name: "session_delete")]
    public function session_delete(
        SessionInterface $session
    ): Response
    {
        $session->clear();

        $this->addFlash(
            'notice',
            'nu är sessionen raderad'
        );
        
        return $this->redirectToRoute('session');
    }

    #[Route("/card/deck", name: "deck")]
    public function card_deck(): Response
    {
        return $this->render('card/tempo.html.twig');
    }

    #[Route("/card/deck/shuffle", name: "deck_shuffle")]
    public function card_deck_shuffle(): Response
    {
        return $this->render('card/tempo.html.twig');
    }

    #[Route("/card/deck/draw", name: "deck_draw")]
    public function card_deck_draw(): Response
    {
        return $this->render('card/tempo.html.twig');
    }
}
