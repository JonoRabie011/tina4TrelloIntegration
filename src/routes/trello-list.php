<?php

use \Tina4\Get;
use \Tina4\Post;
use \Tina4\Response;
use \Tina4\Request;

Post::add("/trello/list/{boardId}/create", function ($boardId, Response $response, Request $request) {
    $trello = new TrelloList("9fb154545893f22de9ed873aec6312b1","ATTAcd49628822d900315bcff3aebb7fa8a94ec050a9718cca01091b8b6db6996ad2B612A3B8");
    $trelloListCreate = $trello->createTrelloList($boardId, $request->data);

    $html = \Tina4\renderTemplate("/trello-integration/lists/trello-list.twig", [
        "list" => $trelloListCreate
    ]);

    return $response([
        "error" => false,
        "data" => $html
    ], HTTP_OK, APPLICATION_JSON);
});
