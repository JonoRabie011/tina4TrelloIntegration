<?php

class TrelloBoard extends TrelloIntegration
{

    public function __construct($APIKey = "", $APIToken = "")
    {
        parent::__construct($APIKey, $APIToken);
    }


    /**
     * Get Full Trello board
     * @param $boardId
     * @return false|mixed|string
     */
    public function getBoard($boardId): mixed
    {
        $curlUrl = $this->getBaseUrl()."/boards/{$boardId}";

        $this->addQueryParam("lists", "open"); //Used to flag that lists com back
        $this->addQueryParam("cards", "open"); //Used to flag that cards com back

//        $this->queryParams = array_merge($this->queryParams, [
//            "lists" => "open", //Used to flag that lists com back
//            "cards" => "open" //Used to flag that cards com back
//        ]);

        $curlHelper = new TrelloCurlHelper($curlUrl, $this->queryParams);

        return $curlHelper->doCurl();
    }


    /**
     * Get All Lists on a board using Board Id
     * @param $boardId
     * @return false|mixed|string
     */
    public function getListOnBoard($boardId): mixed
    {
        $curlUrl = $this->getBaseUrl()."/boards/{$boardId}/lists";

        $curlHelper = new TrelloCurlHelper($curlUrl, $this->queryParams);

        return $curlHelper->doCurl();
    }

}