<?php

class TrelloIntegration
{
    private string $APIKey = "";
    private string $APIToken = "";
    private string $trelloBaseUrl = "https://api.trello.com/1";
    public array $queryParams = [];


    /**
     * If API Key or token is not set it will look for ENV variables -> <br>
     * <i>"TRELLO_API_KEY" & "TRELLO_API_TOKEN"</i>
     * @param string $APIKey
     * @param string $APIToken
     */
    public function __construct(string $APIKey = "", string $APIToken = "")
    {
        if(empty($APIKey))
        {
            $this->APIKey = $_ENV["TRELLO_API_KEY"];
        }
        else
        {
            $this->APIKey = $APIKey;
        }

        if(empty($APIToken))
        {
            $this->APIToken = $_ENV["TRELLO_API_TOKEN"];
        }
        else
        {
            $this->APIToken = $APIToken;
        }

        $this->queryParams = [
            "key" => $this->APIKey,
            "token" => $this->APIToken
        ];
    }

    /**
     * Get Base Url
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->trelloBaseUrl;
    }

    /**
     * Get Api Key
     * @return string
     */
    public function getAPIKey(): string
    {
        return $this->APIKey;
    }

    /**
     * Get Api Token
     * @return string
     */
    public function getAPIToken(): string
    {
        return $this->APIToken;
    }

    /**
     * Update Base url? Change to rather use V2
     * @param string $baseUrl "New base url to use"
     * @return void
     */
    public function setBaseUrl(string $baseUrl): void {
        $this->trelloBaseUrl = $baseUrl;
    }

    /**
     * This Function adds a single param to the queryParams
     * @param $key
     * @param $value
     * @return void
     */
    public function addQueryParam($key,$value): void
    {
        $this->queryParams = array_merge($this->queryParams, [
            $key => $value
        ]);
    }

    /**
     * Set Multiple params at once
     * @param array $params ["key1" => "Value1", "key2" => "Value2"]
     * @return void
     */
    public function addQueryParams(array $params): void
    {
        $this->queryParams = array_merge($this->queryParams, $params);
    }


    /**
     * Rest Query Params
     * @param array $params ["key1","key2"]
     * @return void
     */
    public function restQueryParams(array $params): void
    {
        $this->queryParams = [
            "key" => $this->APIKey,
            "token" => $this->APIToken
        ];
    }

    public function validateObject(array $keyChecks, array $body): array
    {
//        $keyChecks = array_merge(["key", "token"], $keyChecks);

        $missingParams = [];

        foreach ($body as $key => $param)
        {
            if(!in_array($key, $keyChecks))
            {
              $missingParams[] = $key . " is missing";
            }
        }

        return $missingParams;
    }


}