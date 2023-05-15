<?php

class TrelloList extends TrelloIntegration
{

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
        $curlUrl = $this->getBaseUrl()."/lists/{$listId}";

        $curlHelper = new CurlHelper($curlUrl, $this->queryParams);

        return $curlHelper->doCurl();
    }

    /**
     * Function to return a list of all cards in a list
     * @param $listId
     * @return false|mixed|string
     */
    public function getCardsInList($listId): mixed
    {
        $curlUrl = $this->getBaseUrl()."/lists/{$listId}/cards";

        $curlHelper = new CurlHelper($curlUrl, $this->queryParams);

        return $curlHelper->doCurl();
    }

    public function createTrelloList($boardId, $body)
    {
        $curlUrl = $this->getBaseUrl()."/lists";

        $this->addQueryParam("idBoard", $boardId);
        $this->addQueryParam("name", $body->title);

        if(isset($body->pos)) {
            $this->addQueryParam("pos", $body->pos);
        }


        $curlHelper = new CurlHelper($curlUrl, $this->queryParams, "POST");
        return $curlHelper->doCurl();
    }
}