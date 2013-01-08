<?php

require_once(dirname(dirname(__FILE__)) . "/lib/okjson.php");
$json = new OKJson(__DIR__);
echo $json->to_json();

?>
