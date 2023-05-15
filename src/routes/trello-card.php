<?php

use \Tina4\Get;
use \Tina4\Post;
use \Tina4\Response;
use \Tina4\Request;

Get::add("/trello/card/{cardId}/details", function ($cardId ,Response $response) {

    if (!empty($cardId))
    {
        $trello = new TrelloCard("9fb154545893f22de9ed873aec6312b1","ATTAcd49628822d900315bcff3aebb7fa8a94ec050a9718cca01091b8b6db6996ad2B612A3B8");

        $trelloResponse = $trello->getCard($cardId);

        if (is_bool($trelloResponse))
        {
            return $response([
                "error" => true,
                "data" => "Failed to get card"
            ]);
        }
        else
        {
            $html = \Tina4\renderTemplate("/trello-integration/cards/trello-card-detail.twig", [
                "card" => $trelloResponse
            ]);

            return $response([
                "error" => false,
                "data" => $html
            ], HTTP_OK, APPLICATION_JSON);
        }
    }
    else
    {
        return $response([
            "message" => "Failed to get card"
        ]);
    }


});

Post::add("/trello/card/{cardId}/move", function($cardId, Response $response, Request $request) {

    $trello = new TrelloCard("9fb154545893f22de9ed873aec6312b1","ATTAcd49628822d900315bcff3aebb7fa8a94ec050a9718cca01091b8b6db6996ad2B612A3B8");

    $trelloResponse = $trello->moveCard($cardId, (array)$request->data);

    if (is_bool($trelloResponse))
    {
        return $response([
            "error" => true,
            "data" => "Failed to move card"
        ]);
    }
    else
    {
        $trelloList = new TrelloList($trello->getAPIKey(), $trello->getAPIToken());
        $trelloListCards = $trelloList->getCardsInList($request->data->idList);

        $html = "";
        foreach ($trelloListCards as $card )
        {
            $html .= \Tina4\renderTemplate("/trello-integration/cards/trello-card.twig", [
                "card" => $card
            ]);
        }
        return $response([
            "error" => false,
            "data" => $html
        ]);
    }


});

Post::add("/trello/card/create", function (Response $response, Request $request) {

    if(isset($request->data->list) && isset($request->data->title))
    {
        $trello = new TrelloCard("9fb154545893f22de9ed873aec6312b1","ATTAcd49628822d900315bcff3aebb7fa8a94ec050a9718cca01091b8b6db6996ad2B612A3B8");

        $trelloResponse = $trello->createCard($request->data->list, $request->data->title);

        if (is_bool($trelloResponse))
        {
            return $response([
                "message" => "Failed to create card"
            ]);
        }
        else
        {
            return $response(\Tina4\renderTemplate("/trello-integration/cards/trello-card.twig", [
                "card" => $trelloResponse
            ]), HTTP_OK, TEXT_HTML);
        }
    }


});
