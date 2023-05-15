<?php

use \Tina4\Get;
use \Tina4\Response;
use \Tina4\Request;

Get::add("/trello/{boardId}", function ($boardId, Response $response) {

    $boardId = "644680c3625d1df750b993e1";

    $trello = new TrelloBoard("9fb154545893f22de9ed873aec6312b1","ATTAcd49628822d900315bcff3aebb7fa8a94ec050a9718cca01091b8b6db6996ad2B612A3B8");

    $trelloBoard = $trello->getBoard($boardId);

    return $response(\Tina4\renderTemplate("/trello-integration/trello-board.twig", [
        "board" => $trelloBoard
    ]), HTTP_OK, TEXT_HTML);
});
