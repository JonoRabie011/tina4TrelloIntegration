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
