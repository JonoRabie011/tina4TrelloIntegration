<?php

class TrelloCard extends TrelloIntegration
{

    public function __construct(string $APIKey = "", string $APIToken = "")
    {
        parent::__construct($APIKey, $APIToken);
    }

    /**
     * This Function creates a new card
     * @param $listId
     * @param $cardTitle
     * @return false|mixed|string
     */
    public function createCard($listId, $cardTitle): mixed
    {
        $curlUrl = $this->getBaseUrl()."/cards";

        $this->addQueryParam("idList", $listId);
        $this->addQueryParam("name", $cardTitle);

        $curlHelper = new CurlHelper($curlUrl, $this->queryParams, "POST");

        return $curlHelper->doCurl();
    }


    /**
     * Get a card by cardId
     * @param $cardId
     * @return false|mixed|string
     */
    public function getCard($cardId): mixed
    {
        $curlUrl = $this->getBaseUrl()."/cards/".$cardId;

        $curlHelper = new CurlHelper($curlUrl, $this->queryParams);

        return $curlHelper->doCurl();
    }


    /**
     * @param $cardId
     * @param $cardParams
     * @return false|mixed|string
     */
    public function moveCard($cardId, $cardParams): mixed
    {
        $curlUrl = $this->getBaseUrl()."/cards/{$cardId}";

        $this->addQueryParams($cardParams);

        $curlHelper = new CurlHelper($curlUrl, $this->queryParams, "PUT");

        return $curlHelper->doCurl();
    }
}