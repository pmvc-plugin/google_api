<?php

namespace PMVC\PlugIn\google_api;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\Analytics';

class Analytics
{
    const SCOPE_URI = 'https://www.googleapis.com/auth/analytics.readonly';
    const GA_API_URI = 'https://www.googleapis.com/analytics/v3/data/ga';
    public function __invoke($params)
    {
        if (empty($params)) {
            return !trigger_error('[Analytics] Empty params.');
        }
        $oUrl = \PMVC\plug('url')->getUrl(self::GA_API_URI);
        $oUrl->query($params);
        $oUrl->query->access_token = $this->caller->getAccessToken(self::SCOPE_URI);
        $curl = \PMVC\plug('curl');
        $curl->get(
            $oUrl,
            function($r){
                \PMVC\d($r->body); 
            }
        );
        $curl->process();
    }
}
