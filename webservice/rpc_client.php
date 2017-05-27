<?php

class rpcclient {
    protected $url;

    public function __construct($url = '') {
        $this->url = $url;
    }

    protected function query($request) {
        $context = stream_context_create(array(
            'http' => array(
                'method' => "POST",
                'header' => "Content-Type: text/xml",
                'content' => $request
            )
        ));
        $xml = file_get_contents($this->url, false, $context);
        return xmlrpc_decode($xml);
    }

    public function __call($method, $args) {
        $request = xmlrpc_encode_request($method, $args);
        return $this->query($request);
    }
}
$rpc = new rpcclient('http://localhost/webservice/rpc_server.php');
var_dump($rpc->hello());
var_dump($rpc->sum(4, 5, 6));

