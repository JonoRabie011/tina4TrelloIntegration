<?php

class TrelloOrganization extends TrelloIntegration
{

    public function __construct($APIKey = "", $APIToken = "")
    {
        parent::__construct($APIKey, $APIToken);
    }


    public function createOrganization($displayName, $optionalParams = [])
    {
//        $optionalParams = [
//            "desc" => "The description for the organizations",
//            "name" => "A string with a length of at least 3. Only lowercase letters, underscores, and numbers are allowed.
//                        If the name contains invalid characters, they will be removed. If the name conflicts with an existing name,
//                        a new name will be substituted.Min length: 3",
//            "website" => "A URL starting with http:// or https://"
//        ];

        $curlUrl = $this->getBaseUrl()."/organizations";

        $this->queryParams = array_merge($this->queryParams, [
            "displayName" => $displayName
        ]);

        $curlHelper = new TrelloCurlHelper($curlUrl, $this->queryParams, "POST");

        return $curlHelper->doCurl();
    }
}