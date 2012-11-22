<?php

require_once(dirname(dirname(__FILE__)) . "/lib/okjson.php");
$json = new OKJson();


echo $json->to_json();
