<?php

$auth = new \Core\Auth;
$auth->clear_auth_cookie();

$util = new \Core\Util();
$util->redirect( '/login' );

exit;