<?php

include('ESMSWS.php');

$session = createSession('', 'esmsusr_OsnbfGmX', 'mhirmBJj', '');
sendMessages($session, $_POST['SENDER_ID'], $_POST['MSG'], array($_POST['MOBILE']), 1);
closeSession($session);

echo "SUCCESS";

?>
