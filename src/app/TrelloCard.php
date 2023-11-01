<?php

class TrelloCard extends TrelloIntegration
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
     * This Function creates a new card on a trello list
     * @param string $listId The ID of the list the card should be created in
     * @param string $cardTitle The name for the card
     * @param string $cardPosition The position of the new card. top, bottom, or a positive float default is "bottom"
     * @param string $cardDescription The description for the card
     * @param null $cardDueDate A due date for the card "Format must be date"
     * @param array $cardMembers "Array of strings" Comma-separated list of member IDs to add to the card
     * @return false|mixed|string
     */
    public function createCard(string $listId,
                               string $cardTitle,
                               string $cardPosition= "bottom",
                               string $cardDescription = "",
                               $cardDueDate = null,
                               array $cardMembers = []): mixed
    {

        $this->addQueryParam("idList", $listId);
        $this->addQueryParam("name", $cardTitle);
        $this->addQueryParam("pos", $cardPosition);

        if (!empty($cardDescription))
        {
            $this->addQueryParam("desc", $cardDescription);
        }

        if(!empty($cardDueDate))
        {
            $this->addQueryParam("due", $cardDueDate);
        }

        if (!empty($cardMembers))
        {
            $this->addQueryParam("idMembers", implode(",",$cardMembers));
        }


        return $this->sendRequest("/cards".$this->getParamString(), "POST");
    }

    /**
     * Function to add a list of member to a card
     * @param string $cardId The ID of the Card
     * @param array $cardMembers Comma-separated list of member IDs
     * @return array|mixed
     */
    public function addMembersToCard(string $cardId, array $cardMembers): mixed
    {
        $this->addQueryParam("value", implode(",",$cardMembers));

        return $this->sendRequest("/cards/{$cardId}/idMembers".$this->getParamString(), "POST");
    }


    /**
     * Get a card by cardId
     * @param string $cardId
     * @return array | mixed
     */
    public function getCard(string $cardId): mixed
    {
        return $this->sendRequest("/cards/{$cardId}".$this->getParamString());
    }


    /**
     * @param $cardId
     * @param $cardParams
     * @return mixed
     */
    public function moveCard($cardId, $cardParams): mixed
    {
        $this->addQueryParams($cardParams);

        return $this->sendRequest("/cards/{$cardId}".$this->getParamString(), "PUT");
    }


    /*
     *  This Section is all function related to the attachments on a card
     */

    /**
     * Function to list all attachments on a card
     * @param string $cardId ID of targeted card
     * @return array|mixed
     */
    public function getAttachmentsOnCard(string $cardId): mixed
    {
        return $this->sendRequest("/cards/{$cardId}/attachments".$this->getParamString());
    }

    /**
     * Returns a single attachment by card ID
     * @param string $cardId ID of targeted card
     * @param string $attachmentId ID of attachment card
     * @return mixed
     */
    public function getAttachmentOnCard(string $cardId, string $attachmentId): mixed
    {
        return $this->sendRequest("/cards/{$cardId}/attachments/{$attachmentId}".$this->getParamString());
    }


    /**
     * Create an attachment on a card.
     * <br>
     * <i>You need to supply a '$file' or '$url' or both for the method to work, else response is an HTTP 400 error.</i>
     * @param string $cardId ID of targeted card
     * @param string $fileName Custom file name for attachment
     * @param string $file Binary string for card
     * @param string $mimeType The mimeType of the attachment. Max length 256
     * @param string $fileUrl A URL to attach. Must start with 'http://' or 'https://'
     * @return mixed
     */
    public function createAttachmentOnCard(string $cardId, string $fileName, string $file ="", string $mimeType = "", string $fileUrl = ""): mixed
    {
        if (!empty($file)) {
            $this->addQueryParam("file", $file);
            if (!empty($mimeType))
                $this->addQueryParam("mimeType", $mimeType);
        }

        if (!empty($fileUrl))
            $this->addQueryParam("url", $fileUrl);

        return $this->sendRequest("/cards/{$cardId}/attachments".$this->getParamString(), "POST");
    }
}