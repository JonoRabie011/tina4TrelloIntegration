<?php

use \Tina4\Get;
use \Tina4\Response;
use \Tina4\Request;

Get::add("/trello/{boardId}", function ($boardId, Response $response) {

//    $boardId = "644680c3625d1df750b993e1";

    $trello = new TrelloBoard();

    $trelloBoard = $trello->getBoard($boardId, true, true);

    if (!empty($trelloBoard["body"]) && $trelloBoard["httpCode"] === 200)
    {
        return $response(\Tina4\renderTemplate("/trello-integration/trello-board.twig", [
            "board" => $trelloBoard["body"]
        ]), HTTP_OK, TEXT_HTML);
    }
    else
    {
        return $response(\Tina4\renderTemplate("/trello-integration/trello-error.twig", [
            "error" => $trelloBoard
        ]), HTTP_OK, TEXT_HTML);
    }

});
