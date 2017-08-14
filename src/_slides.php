<?php

namespace PMVC\PlugIn\google_api;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\Slides';

/** 
 * 1. enable Sheets API
 * https://console.developers.google.com/apis/api/slides.googleapis.com/overview 
 */ 

class Slides extends BaseApi
{
    /**
     * @see https://developers.google.com/slides/how-tos/authorizing
     */
    const SCOPE_URI = 'https://www.googleapis.com/auth/presentations';
    const API_URI = 'https://slides.googleapis.com/v1/presentations/';

    public function read($id, $params)
    {
        $this->api = \PMVC\plug('url')->getUrl(
            self::API_URI
        );
        $this->api->set($id);
        $this->scope = self::SCOPE_URI;
        $this->method = 'get';
        return $this->process($params);
    }
}
