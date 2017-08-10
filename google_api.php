<?php

namespace PMVC\PlugIn\google_api;

use PMVC\PlugIn;

// \PMVC\l(__DIR__.'/xxx.php');

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\google_api';

class google_api extends PlugIn
{
    public function init()
    {
        echo "I'm init\n";
    }
}
