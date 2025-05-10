<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Card\DeckOfCards;
use App\Card\CardHand;

class JSONCardController
{
    #[Route("/api/deck")]
    public function jsonDeck(): Response
    {

        $deck = new DeckofCards();

        $data = [
            "deckUTF8Graphics" => $deck->__toString(),
            "deckAllowedCardNames" => $deck->getPossibleCardNames()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/shuffle")]
    public function jsonDeckShuffle(
        SessionInterface $session
    ): Response {

        $deck = new DeckofCards();
        $deck->shuffleDeck();

        $session->set("deck", $deck);

        $data = [
            "shuffledDeckUTF8Graphics" => $deck->__toString(),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw")]
    public function jsonDeckDraw(
        SessionInterface $session
    ): Response {

        if ($session->get("deck")) {
            $deck = $session->get("deck");
        } else {
            $deck = new DeckofCards();
            $deck->shuffleDeck();
            $session->set("deck", $deck);
        }

        $cards_left = $deck->getLength();

        if ($cards_left >= 1) {
            $drawn_card = $deck->draw();
            $cards_left = $cards_left - 1;
        } else {
            $drawn_card = null;
        }

        $data = [
            "drawnCardUTF8Graphics" => $deck->__toString(),
            "cardsLeftInDeck" => $cards_left
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw/{num<\d+>}")]
    public function jsonDeckDrawMulti(
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

        $cards_left = $deck->getLength();

        if ($cards_left >= $num) {
            $hand = new CardHand();
            for ($i = 1; $i <= $num; $i++) {
                $hand->add($deck->draw());
            }
            $cards_left = $cards_left - $num;

            $data = [
            "drawnCardsUTF8Graphics" => $hand->__toString(),
            "cardsLeftInDeck" => $cards_left
            ];
        } else {
            $data = [
            "drawnCardsUTF8Graphics" => null,
            "cardsLeftInDeck" => $cards_left
        ];
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
