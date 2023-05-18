<?php

use \Tina4\Get;

Get::add("/trello/quick-action/card/add/{memberId}", function ($memberId, \Tina4\Response $response) {

    $trelloMember = new TrelloMember();

    $trelloOrganizations = $trelloMember->getMemberOrganization($memberId, "all", "id,name,displayName");

    $trelloBoards = $trelloMember->getMemberBoards($memberId,
                                            "id,name",
                                                 "all",
                                              "open",
                                         true);

    return $response(\Tina4\renderTemplate("/trello-integration/quick-actions/trello-quick-action-new-card.twig",
        [
            "organizations" => $trelloOrganizations["body"],
            "boards" => $trelloBoards["body"]
        ])
        ,HTTP_OK, TEXT_HTML);
});