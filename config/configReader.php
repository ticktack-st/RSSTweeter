<?php
namespace Anunuka\RSStweeter;

class ConfigReader
{
    public function getTwitterClientKey()
    {
        require "config.php";
        return $constants["TWITTER_CLIENT_KEY"];
    }

    public function getTwitterClientSecret()
    {
        require "config.php";
        return $constants["TWITTER_CLIENT_SECRET"];
    }

    public function getTwitterClientIdAccessToken()
    {
        require "config.php";
        return $constants["TWITTER_CLIENT_ID_ACCESS_TOKEN"];
    }

    public function getTwitterClientIdAccessTokenSecret()
    {
        require "config.php";
        return $constants["TWITTER_CLIENT_ID_ACCESS_TOKEN_SECRET"];
    }

    public function getTwitterCallbackSecret()
    {
        require "config.php";
        return $constants["TWITTER_CALLBACK_SECRET"];
    }
}
