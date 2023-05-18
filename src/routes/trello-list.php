<?php

use \Tina4\Get;
use \Tina4\Post;
use \Tina4\Response;
use \Tina4\Request;

Post::add("/trello/list/{boardId}/create", function ($boardId, Response $response, Request $request) {
    $trello = new TrelloList();
    $trelloListCreate = $trello->createTrelloList($boardId, $request->data);

    $html = \Tina4\renderTemplate("/trello-integration/lists/trello-list.twig", [
        "list" => $trelloListCreate
    ]);

    return $response([
        "error" => false,
        "data" => $html
    ], HTTP_OK, APPLICATION_JSON);
});
