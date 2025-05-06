<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JSONController
{
    #[Route("/api/quote")]
    public function jsonQuote(): Response
    {

        $json_start_data = '[
            {"quote":"To see is to kind of believe", "author":"Limsang"},
            {"quote":"Far from tree, roots are few", "author":"Karl-Agne"},
            {"quote":"JSON gives, and JSON takes", "author":"JMan"},
            {"quote":"Lecture me not for my ignorance, but for my interest", "author":"Gudrun"},
            {"quote":"Efter regn kommer tids nog mer regn", "author":"Lurken"}
        ]';

        ## Testing to read from json string - should move to read from file instead
        $quote_data = json_decode($json_start_data);

        $max_index = (count($quote_data) - 1);
        $rand_index = random_int(0, $max_index);

        ## Time zone
        date_default_timezone_set("Europe/Stockholm");

        ## Prepare output data
        $rand_quote = $quote_data[$rand_index];
        $date_stamp = date("Y-m-d");
        $time_stamp = date("H:i:s");

        $data = [
            'quote' => $rand_quote->quote,
            'author' => $rand_quote->author,
            'date' => $date_stamp,
            'time' => $time_stamp
        ];

        ## Not using for now, but short if not pretty
        // return new JsonResponse($data);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
