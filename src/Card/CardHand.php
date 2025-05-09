<?php

namespace App\Card;

use App\Card\CardGraphic;

class CardHand
{
    private $hand = [];

    public function add(CardGraphic $card): void
    {
        $this->hand[] = $card;
    }

    public function __toString(): string
    {
        $out_string = "";

        foreach ($this->hand as $card) {
            $out_string = $out_string . $card;
        }

        return $out_string;
    }

}
