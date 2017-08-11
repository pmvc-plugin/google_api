<?php

namespace PMVC\PlugIn\google_api;

use PMVC\PlugIn;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\google_api';

class google_api extends PlugIn
{
    const GRANT_TYPE = 'urn:ietf:params:oauth:grant-type:jwt-bearer';
    const TOKEN_URI = 'https://accounts.google.com/o/oauth2/token';
    const TTL = 3600;

    public function getAccessToken($scopeUri)
    {
        $key = $this['key'];
        $key['grantType'] = self::GRANT_TYPE;
        $key['tokenUri'] = self::TOKEN_URI;
        $key['ttl'] = self::TTL;
        $key['scopeUri'] = $scopeUri;
        $jwt = $this->jwt();
        $token = $jwt->getAccessToken($key);
        return $token;
    }
}
