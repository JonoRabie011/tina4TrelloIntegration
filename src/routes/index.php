<?php

//\Tina4\Get::add("/", function (\Tina4\Response $response) {
//    \Tina4\redirect("/trello/644680c3625d1df750b993e1");
//});

\Tina4\Get::add("add/trello/card", function (\Tina4\Response $response) {

    echo "<pre>";
//    $trelloOrganization = new TrelloOrganization();
//    $trelloOrganization->

    $trelloMember = new TrelloMember();
    $trelloBoard = new TrelloBoard();

//    $trelloMemberInfo = $trelloMember->getMemberOrganization("jonathanrabie");
    $trelloBoardsWithLists = $trelloMember->getMemberBoards(  "jonathanrabie",
                                                    "id,name",
                                                         "all",
                                                      "open");

    print_r($trelloBoardsWithLists);
//
//    foreach ($trelloMemberInfo["body"] as $trello)
//    {
//        echo "<br>";
//        echo "ID::".print_r($trello["id"], 1);
//        echo "<br>";
//        echo "Name::".print_r($trello["name"], 1);
//
//        echo print_r($trelloBoard->getBoard($trello["id"], true));
//    }

//    print_r($trelloMemberInfo["body"]);

//


//    print_r($trelloBoardWithList);

    $trelloCard = new TrelloCard();
//    $trelloCard->createCard($listId, "Card Title");
});

\Tina4\Get::add("/test/create-a-card/{listId}/{cardTitle}/{cardPosition}/{cardDescription}/{cardDueDate}/{cardMembers}",
    function ($listId,$cardTitle,$cardPosition,$cardDescription,$cardDueDate,$cardMembers, \Tina4\Response $response, \Tina4\Request $request)
{
    echo "<pre>";
    print_r((new TrelloCard)->createCard($listId, $cardTitle, $cardPosition, $cardDescription, $cardDueDate, [$cardMembers]));
    exit;
});

\Tina4\Get::add("test/add-member-to-card/{cardId}/{memberId}", function ($cardId, $memberId, \Tina4\Response $response, \Tina4\Request $request) {
    echo "<pre>";
    print_r((new TrelloCard)->addMembersToCard($cardId,[$memberId]));
    exit;
});

\Tina4\Get::add("test/get-card-attachments/{cardId}", function ($cardId, \Tina4\Response $response, \Tina4\Request $request) {
    echo "<pre>";
    print_r((new TrelloCard)->getAttachmentsOnCard($cardId));
    exit;
});

\Tina4\Get::add("test/add-card-attachment/{cardId}/{fileName}", function ($cardId,$fileName, \Tina4\Response $response, \Tina4\Request $request) {
    echo "<pre>";
    print_r((new TrelloCard)->createAttachmentOnCard($cardId,$fileName,"", "", "https://www.w3schools.com/html/pic_trulli.jpg"));
    exit;
});

\Tina4\Get::add("test/get-card-attachment/{cardId}/{attachmentId}", function ($cardId, $attachmentId, \Tina4\Response $response, \Tina4\Request $request) {
    echo "<pre>";
    print_r((new TrelloCard)->getAttachmentOnCard($cardId, $attachmentId));
    exit;
});

\Tina4\Get::add("test/get-card/{cardId}", function ($cardId, \Tina4\Response $response, \Tina4\Request $request) {
    echo "<pre>";
    print_r((new TrelloCard)->getCard($cardId));
    exit;
});

\Tina4\Get::add("test/get-organization-members/{orgId}", function ($orgId, \Tina4\Response $response, \Tina4\Request $request) {
    echo "<pre>";
    print_r((new TrelloOrganization())->getOrganizationMembers($orgId));
    exit;
});

\Tina4\Get::add("test/get-organization-boards/{orgId}", function ($orgId, \Tina4\Response $response, \Tina4\Request $request) {
    echo "<pre>";
    print_r((new TrelloOrganization())->getOrganizationBoards($orgId));
    exit;
});

\Tina4\Get::add("test/get-member-organizations/{memberId}", function ($memberId, \Tina4\Response $response, \Tina4\Request $request) {
    echo "<pre>";
    print_r((new TrelloMember())->getMemberOrganization($memberId));
    exit;
});