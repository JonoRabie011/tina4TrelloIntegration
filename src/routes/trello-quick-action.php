<?php

use \Tina4\Get;
use \Tina4\Post;
use \Tina4\Response;
use \Tina4\Request;

Get::add("/trello/quick-action/card/add/{memberId}",
    function ($memberId, Response $response, Request $request) {

    $trelloMember = new TrelloMember();

    TrelloToolbox::setTokensFromRequest($trelloMember, $request);

    $trelloOrganizations = $trelloMember->getMemberOrganization($memberId, "all", "id,name,displayName");

    $trelloBoards = $trelloMember->getMemberBoards($memberId,
                                            "id,name",
                                                 "all",
                                              "open",
                                         true);

    if($trelloBoards["httpCode"] === 200) {
        return $response(\Tina4\renderTemplate("/trello-integration/quick-actions/trello-quick-action-new-card.twig",
                [
                    "organizations" => $trelloOrganizations["body"],
                    "boards" => $trelloBoards["body"],
                    "member" => $memberId,
                    "token" => $trelloMember->getApiToken(),
                    "key" => $trelloMember->getAPIKey()
                ])
            ,HTTP_OK, TEXT_HTML);
    }
    else
    {
        return $response(\Tina4\renderTemplate("/trello-integration/trello-error.twig",
            [
                "error" => $trelloBoards["error"],
                "body" => $trelloBoards["body"]
            ]), $trelloBoards["httpCode"], TEXT_HTML);
    }
});

Post::add("/trello/quick-action/card/add/{memberId}",
    function ($memberId, Response $response, Request $request) {

    $trelloCard = new TrelloCard();

    TrelloToolbox::setTokensFromRequest($trelloCard, $request);

    if(!empty($request->params["list"]) && !empty($request->params["title"]))
    {
        $trelloCardCreate = $trelloCard->createCard(
            $request->params["list"],
            $request->params["title"]
        );

        if($trelloCardCreate["httpCode"] === 200) {
            return $response(\Tina4\renderTemplate("/trello-integration/trello-success.twig",
                    [
                        "body" => "<script>" .
                                     "window.open('{$trelloCardCreate['body']['shortUrl']}', '_blank');" .
                                     "window.location.href = '/trello/quick-action/card/add/{$memberId}?token={$trelloCard->getAPIToken()}&key={$trelloCard->getAPIKey()}'" .
                                  "</script>"
                    ])
                ,HTTP_OK, TEXT_HTML);
        }
        else
        {
            return $response(\Tina4\renderTemplate("/trello-integration/trello-error.twig",
                [
                    "error" => $trelloCardCreate["error"],
                    "body" => $trelloCardCreate["body"]
                ]), $trelloCardCreate["httpCode"], TEXT_HTML);
        }
    }
});