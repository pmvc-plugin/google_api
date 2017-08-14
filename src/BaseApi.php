<?php

namespace PMVC\PlugIn\google_api;

class BaseApi
{
    protected $api;
    protected $scope;
    protected $method;

    protected $apiUri;
    protected $scopeUri;

    public function __invoke()
    {
        $this->api = $this->apiUri;
        $this->scope = $this->scopeUri;
        $this->method = 'get';
        return $this;
    }

    public function process($params)
    {
        if (empty($params)) {
            return !trigger_error('[Base Api] Empty params.');
        }
        $caller = $this->caller;
        $oUrl = \PMVC\plug('url')->getUrl($this->api);
        $oUrl->query($params);
        $accessToken = $caller->getAccessToken($this->scope);
        $oUrl->query->access_token = $accessToken['token'];
        $curl = \PMVC\plug($caller['curl']);
        $result = null;
        $curl->{$this->method}(
            $oUrl,
            function($r) use (&$result){
                $result = \PMVC\fromJson($r->body); 
            }
        );
        $curl->process();
        return $result;
    }
}
