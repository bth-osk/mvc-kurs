<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\DeckOfCards;
use App\Card\CardHand;

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
    ): Response {
        $data = [
            "session" => $session->all()
        ];

        return $this->render('card/session.html.twig', $data);
    }

    #[Route("/session/delete", name: "session_delete")]
    public function session_delete(
        SessionInterface $session
    ): Response {
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
        $deck = new DeckofCards();

        $data = [
            "card_graphics" => $deck
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "deck_shuffle")]
    public function card_deck_shuffle(
        SessionInterface $session
    ): Response {
        $deck = new DeckofCards();
        $deck->shuffleDeck();

        $session->set("deck", $deck);

        $data = [
            "card_graphics" => $deck
        ];

        return $this->render('card/shuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "deck_draw")]
    public function card_deck_draw(
        SessionInterface $session
    ): Response {
        if ($session->get("deck")) {
            $deck = $session->get("deck");
        } else {
            $deck = new DeckofCards();
            $deck->shuffleDeck();
            $session->set("deck", $deck);
        }

        if ($deck->getLength() >= 1) {
            $drawn_card = $deck->draw();
        } else {
            $this->addFlash(
                'warning',
                'Fler kort än antalet kvarvarande kort i kortleken har efterfrågats'
            );
            $drawn_card = "";
        }

        $data = [
            "card_graphics" => $deck,
            "remaining_cards" => $deck->getLength(),
            "drawn_card" => $drawn_card
        ];

        return $this->render('card/draw.html.twig', $data);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "draw_cardhand")]
    public function drawMulti(
        int $num,
        SessionInterface $session
    ): Response {
        if ($session->get("deck")) {
            $deck = $session->get("deck");
        } else {
            $deck = new DeckofCards();
            $deck->shuffleDeck();
            $session->set("deck", $deck);
        }

        if ($num > $deck->getLength()) {
            $this->addFlash(
                'warning',
                'Fler kort än antalet kvarvarande kort i kortleken har efterfrågats'
            );
            $hand = "";
        } else {
            $hand = new CardHand();
            for ($i = 1; $i <= $num; $i++) {
                $hand->add($deck->draw());
            }
        }

        $data = [
            "card_graphics" => $deck,
            "remaining_cards" => $deck->getLength(),
            "drawn_card" => $hand
        ];

        return $this->render('card/draw.html.twig', $data);
        ;
    }
}
