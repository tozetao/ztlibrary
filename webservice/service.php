<?php
function sum($term){
	return $term.' is success';
}

$soap = new SoapServer('./wsdl.xml');
$soap->addFunction('sum');
$soap->handle();