<?php

$call = explode("/",trim($_SERVER['DOCUMENT_URI'],'/'));
echo "Calling type: $call[0]<br/>Calling method: $call[1]";

?>
