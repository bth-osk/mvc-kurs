<?php

namespace App\Card;

use App\Card\CardGraphic;

class DeckOfCards
{
    private $cards = [];

    private $card_types = array(
        "SA",
        "S2",
        "S3",
        "S4",
        "S5",
        "S6",
        "S7",
        "S8",
        "S9",
        "S10",
        "SJ",
        "SQ",
        "SK",

        "HA",
        "H2",
        "H3",
        "H4",
        "H5",
        "H6",
        "H7",
        "H8",
        "H9",
        "H10",
        "HJ",
        "HQ",
        "HK",

        "DA",
        "D2",
        "D3",
        "D4",
        "D5",
        "D6",
        "D7",
        "D8",
        "D9",
        "D10",
        "DJ",
        "DQ",
        "DK",

        "CA",
        "C2",
        "C3",
        "C4",
        "C5",
        "C6",
        "C7",
        "C8",
        "C9",
        "C10",
        "CJ",
        "CQ",
        "CK"
    );

    public function __construct()
    {
        foreach ($this->card_types as $type) {
            $this->cards[] = new CardGraphic($type);
        }
    }

    public function shuffleDeck(): void
    {
        shuffle($this->cards);
    }

    public function getLength(): int
    {
        return count($this->cards);
    }

    public function draw(): CardGraphic
    {
        $cards_left = $this->getLength();

        if ($cards_left >= 1) {
            $random_entry = array_rand($this->cards);
            $drawn_card = $this->cards[$random_entry];
            unset($this->cards[$random_entry]);
            return $drawn_card;
        } else {
            throw new \Exception("Not enough cards in deck for requested number of drawn cards!");
        }
    }

    public function __toString(): string
    {
        $out_string = "";

        foreach ($this->cards as $card) {
            $out_string = $out_string . $card;
        }

        return $out_string;
    }

    public function getPossibleCardNames(): string
    {
        return implode(",", $this->card_types);
        ;
    }

}
