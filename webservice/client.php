<?php

$soap = new SoapClient('http://localhost/webservice/wsdl.xml');
// var_dump($soap->__getFunctions());
echo $soap->sum('zhangsan');