<?php

class TrelloList extends TrelloIntegration
{

    /**
     * @param $APIKey
     * @param $APIToken
     */
    public function __construct($APIKey = "", $APIToken = "")
    {
        parent::__construct($APIKey, $APIToken);
    }


    /**
     * Function to get list details by listId
     * @param $listId
     * @return false|mixed|string
     */
    public function getList($listId): mixed
    {
        return $this->sendRequest("/lists/{$listId}".$this->getParamString());
    }

    /**
     * Function to return a list of all cards in a list
     * @param $listId
     * @return false|mixed|string
     */
    public function getCardsInList($listId): mixed
    {
        return $this->sendRequest("/lists/{$listId}/cards".$this->getParamString());
    }

    //@Todo fix documentation here
    public function createTrelloList($boardId, $body)
    {
        $this->addQueryParam("idBoard", $boardId);
        $this->addQueryParam("name", $body->title);

        if(isset($body->pos)) {
            $this->addQueryParam("pos", $body->pos);
        }
        return $this->sendRequest("/lists".$this->getParamString());
    }
}