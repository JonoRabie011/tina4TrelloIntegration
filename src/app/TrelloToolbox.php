<?php

use Tina4\Request;

class TrelloToolbox
{


    public static function setTokensFromRequest(TrelloIntegration &$trelloIntegrationClass, Request $request): void
    {
        if (isset($request->params["token"]) && isset($request->params["key"]))
        {
            $trelloIntegrationClass->setAuthTokens($request->params["key"], $request->params["token"]);
        }
    }
}