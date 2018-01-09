<?php

namespace PMVC\PlugIn\google_api;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\JWT';

class JWT
{
    public function __invoke()
    {
        return $this;
    }
    
    /**
     * @params array $data
     *  [
     *      'privateKey',
     *      'clientEmail',
     *      'grantType',
     *      'tokenUri',
     *      'ttl',
     *      'scopeUri'
     *  ]
     */
    public function getAccessToken($data)
    {
        $jwt = $this->generateSignedJWT($data);
        $params = [
            'grant_type'=>$data['grantType'],
            'assertion'=>$jwt['jwt'],
        ];
        $caller = $this->caller;
        $curl = \PMVC\plug($caller['curl']);
        $token = null;
        $curl->post(
            $data['tokenUri'],
            function($r, $curl) use(&$token){
                $json = \PMVC\fromJson($r->body);
                $token = \PMVC\get(
                    $json,
                    'access_token'
                );
                if (empty($token)) {
                    trigger_error('Get token failed. '. print_r([$r, $curl], true));
                }
            },
            $params
        );
        $curl->process();
        return [
            'token'=>$token,
            'expire'=>$jwt['expire']
        ];
    }

    public function generateSignedJWT($data)
    {
        $header = [
            'alg'=>'RS256',
            'typ'=>'JWT',
        ];
        $t = time();
        // <-- For cache to get same hash before expire. 
        $interval = floor($t/$data['ttl']);
        $t = $data['ttl'] * $interval;
        // -->
        $expire = $t + $data['ttl'];
        $params = [
            'iss'  => $data['clientEmail'],
            'scope'=> $data['scopeUri'],
            'aud'  => $data['tokenUri'],
            'exp'  => $expire,
            'iat'  => $t,
        ];
        $encodings = [
            base64_encode(json_encode($header)),
            base64_encode(json_encode($params)),
        ];
        $input = implode('.', $encodings);
        $sig = null;
        $privateKey = str_replace('\n', PHP_EOL, $data['privateKey']); 
        $key = openssl_pkey_get_private($privateKey);
        openssl_sign(
            $input,
            $sig,
            $key,
            'sha256'
        );
        $encodings[] = base64_encode($sig);
        $jwt = implode('.', $encodings);
        return [
            'jwt' =>$jwt,
            'expire'=>$expire
        ];
    }
}
