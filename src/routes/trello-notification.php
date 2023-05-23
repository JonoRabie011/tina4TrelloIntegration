<?php

use Tina4\Get;
use Tina4\Post;
Use Tina4\Response;
use Tina4\Request;

Get::add("/trello/member/notifications/{memberId}", function ($memberId, Response $response, Request $request) {

    $trelloMember = new TrelloMember();

    TrelloToolbox::setTokensFromRequest($trelloMember, $request);

    $trelloNotifications = $trelloMember->getMemberNotifications($memberId);

    $todayDate = Date("l, d M");

    return $response(\Tina4\renderTemplate("/trello-integration/notifications/trello-notifications-list.twig", [
        "today" => $todayDate,
        "notifications" => $trelloNotifications["body"]
    ]),
    HTTP_OK, TEXT_HTML);
});