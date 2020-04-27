<?php

$link = oci_connect('duser', 'v22n16m34', 'localhost/XE');
if (!$link) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}