<?php

namespace PMVC\PlugIn\google_api;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\Analytics';

/**
 * Params
 * @see https://developers.google.com/analytics/devguides/reporting/core/v3/reference#q_summary
 */
class Analytics extends BaseApi
{
     protected $scopeUri = 'https://www.googleapis.com/auth/analytics.readonly';
     protected $apiUri = 'https://www.googleapis.com/analytics/v3/data/ga';
}
