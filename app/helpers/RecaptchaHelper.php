<?php

class Recaptcha {
    private $siteKey;
    private $secretKey;
    
    public function __construct($siteKey, $secretKey) {
        $this->siteKey = $siteKey;
        $this->secretKey = $secretKey;
    }
    
    public function getWidget() {
        return '<div class="g-recaptcha" data-sitekey="' . $this->siteKey . '" data-theme="dark"></div>';
    }
    
    public function getScript() {
        return '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
    }
    
    public function verify($response) {
        if (empty($response)) {
            return false;
        }
        
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $this->secretKey,
            'response' => $response,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ];
        
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        
        if ($result === FALSE) {
            return false;
        }
        
        $json = json_decode($result, true);
        return $json['success'] ?? false;
    }
}