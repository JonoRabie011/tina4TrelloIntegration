<?php

class TrelloIntegration extends \Tina4\Api
{
    private string $APIKey = "";

    private string $APIToken = "";

    /**
     * @var string|null Base url for the Api
     */
    public $baseURL = "https://api.trello.com/1";

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
            $this->APIKey = $_ENV["TRELLO_API_KEY"]?? "";
        }
        else
        {
            $this->APIKey = $APIKey;
        }

        if(empty($APIToken))
        {
            $this->APIToken = $_ENV["TRELLO_API_TOKEN"]?? "";
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
     * Update Auth Tokens for Object
     * @param string $APIKey
     * @param string $APIToken
     * @return void
     */
    public function setAuthTokens(string $APIKey, string $APIToken): void
    {
        if (!empty($APIToken) && $APIKey)
        {
            $this->APIKey = $APIKey;
            $this->APIToken = $APIToken;

            $this->queryParams["key"] = $this->APIKey;
            $this->queryParams["token"] = $this->APIToken;
        }
    }

    /**
     * Update Base url?
     * @param string $baseUrl "New base url to use"
     * @return void
     */
    public function setBaseUrl(string $baseUrl): void {
        $this->baseURL = $baseUrl;
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
     * Function used to get full url with query params appended
     * @return string
     */
    public function getParamString() : string
    {
        if(!empty($this->queryParams))
        {
            $paramArray = [];
            foreach ($this->queryParams as $key => $param ) {
                $param = urlencode($param);
                $paramArray[] = "{$key}={$param}";
            }
            return "?".implode("&", $paramArray);
        }
        else
        {
            return "";
        }
    }


    /**
     * Rest Query Params
     * @return void
     */
    public function restQueryParams(): void
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