<?php

class TrelloBoard extends TrelloIntegration
{

    public function __construct($APIKey = "", $APIToken = "")
    {
        parent::__construct($APIKey, $APIToken);
    }


    /**
     * Get Full Trello board
     * @param string $boardId Id of board you want to fetch
     * @param bool $fetchLists "true" if you want to retrieve lists for board
     * @param bool $fetchCards "true" if you want to retrieve card for board
     * @return array | mixed
     */
    public function getBoard(string $boardId, bool $fetchLists = false, bool $fetchCards = false): mixed
    {

        if($fetchLists)
        {
            $this->addQueryParam("lists", "open"); //Used to flag that lists com back
        }

        if($fetchCards)
        {
            $this->addQueryParam("cards", "open"); //Used to flag that cards com back
        }

        return $this->sendRequest("/boards/{$boardId}".$this->getParamString());
    }


//    /**
//     * Get All Lists on a board using Board Id
//     * @param $boardId
//     * @return false|mixed|string
//     */
//    public function getListOnBoard($boardId): mixed
//    {
//        $curlUrl = $this->getBaseUrl();
//
//        $trelloCurl = new \Tina4\Api($curlUrl);
//
//        return $trelloCurl->sendRequest("/boards/{$boardId}/lists");
//    }

}