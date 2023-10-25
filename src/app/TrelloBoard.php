<?php

class TrelloBoard extends TrelloIntegration
{


    /**
     * If API Key or token is not set it will look for ENV variables -> <br>
     * <i>"TRELLO_API_KEY" & "TRELLO_API_TOKEN"</i>
     * @param string $APIKey
     * @param string $APIToken
     */
    public function __construct(string $APIKey = "", string $APIToken = "")
    {
        parent::__construct($APIKey, $APIToken);
    }


    /**
     * Get Full Trello board
     * @param string $boardId ID of board you want to fetch
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