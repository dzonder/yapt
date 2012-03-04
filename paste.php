<?php

/**
 * Save the paste and redirect.
 *
 * @author    Michal Olech <me@dzonder.net>
 * @copyright 2011 YAPT
 */

include_once 'libs/config.inc.php';
include_once 'libs/mysql.inc.php';

if (!isset($_POST['passwd'], $_POST['code'])) {
    throw new Exception('POST values undefined!');
}

$passwd = $_POST['passwd'];
$code = $_POST['code'];
$flags = array();

if (strlen(trim($code)) == 0) {
    throw new Exception('Code empty!');
}

// Encrypt if password supplied
if (strlen($passwd) > 0) {
    $encryption = 'ENC_3DES';
    $passwd_hash = mhash(MHASH_SHA1, $passwd);
    $code = mcrypt_encrypt(MCRYPT_3DES, $passwd_hash, $code, MCRYPT_MODE_ECB);
} else {
    $encryption = 'ENC_PLAIN';
}

// Insert into database
mysql_query("INSERT INTO pastes 
    (encryption, code)
    VALUES (
        '" .$encryption ."', 
        '" .mysql_escape_string($code) ."' 
    )");

// Redirect to paste
$id = mysql_insert_id($link);
header('Location: ' .CONF_URL .dechex($id));

?>
