<?php

use Psr\Log\LogLevel;
use \Tina4\Debug;

class TrelloCurlHelper
{
    public bool $HeaderAuth = False;
    public string $HeaderAuthType = "BASIC";

    private string $curlUrl = "";
    private string $requestType;
    private array $headers;
    private bool $isJsonResponse;
    private mixed $body;

    /**
     * @param $apiUrl "The api endpoint you want to hit up"
     * @param array $queryParams "Any inline query params needed" e.g. ["key"=>value,"key2"=>value]
     * @param string $requestType "GET" or "POST" or "UPDATE" etc
     * @param array $headers "This is where you could pass in the Auth headers"
     * e.g [ "Authorization: Bearer ".base64_encode($_ENV["API_USERNAME"].":".$_ENV["API_PASSWORD"]),  "Sending_host: {$_SERVER["SERVER_NAME"]}" ]
     * @param bool $jsonResponse "If the response must be json parsed"
     * @param $body "Only Needed for POST or UPDATE"
     */
    public function __construct($apiUrl, array $queryParams = [], string $requestType = "GET", array $headers = [], bool $jsonResponse = true, $body = null)
    {

        if(!empty($queryParams))
        {
            $paramArray = [];
            foreach ($queryParams as $key => $param ) {
                $param = urlencode($param);
                $paramArray[] = "{$key}={$param}";
            }
            $apiUrl .= "?".implode("&", $paramArray);
        }

        $headers[] = "Accept: application/json";

//        $headers[] = "Sender: {$_SERVER["SERVER_NAME"]}";
//        $headers[] = "Authorization: Bearer ".base64_encode($_ENV["API_USERNAME"].":".$_ENV["API_PASSWORD"]);

        $this->curlUrl = $apiUrl;
        $this->requestType = $requestType;
        $this->headers = $headers;
        $this->isJsonResponse = $jsonResponse;
        $this->body = $body;
    }

    /**
     * @return false|mixed|string
     */
    public function doCurl(): mixed
    {
        $curl = curl_init();

        //@TODO Fix ssl on new php install on my laptop
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        //Not sure of this
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        if(!empty($this->curlUrl)) {
            //set Curl Url
            curl_setopt($curl, CURLOPT_URL, $this->curlUrl);
        } else {
            Debug::message(print_r("CURL ERROR IN ".__LINE__.", File:".__FILE__."::API URL NOT SET", 1), LogLevel::WARNING);
            return false;
        }

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->requestType);

        //Set headers
        if(!empty($this->headers)) {
            Debug::message("CURL REQUEST HEADERS::".print_r($this->headers,1));
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        }

        //Add Body
        if(!empty($this->body) and in_array($this->requestType, ["POST", "PATCH", "PUT"])) {
            Debug::message("CURL REQUEST BODY::".print_r($this->body,1));
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($this->body));
        }

        //Set to return data
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        try {

            $curlResponse = curl_exec($curl);

            if(!empty(curl_error($curl)) || is_bool($curlResponse)) {
                Debug::message(print_r("CURL ERROR \"".$this->curlUrl." \"", 1)."::".print_r(curl_error($curl), 1), LogLevel::WARNING);
                curl_close($curl);
                return false;
            }

            Debug::message(print_r("CURL RESPONSE FOR \"".$this->curlUrl." \"", 1)."::".print_r($curlResponse, 1), 'CURL_LOG');

            if($this->isJsonResponse) {
                $curlResponse = json_decode($curlResponse);
            }

            curl_close($curl);

            return $curlResponse;
        } catch (\Exception $err) {
            Debug::message(print_r("CURL ERROR \"".$this->curlUrl." \"", 1)."::".print_r($err, 1),LogLevel::WARNING);
            return false;
        }

    }

}