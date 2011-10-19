<?php

/**
 * Save the paste and redirect.
 *
 * @author    Michal Olech <me@dzonder.net>
 * @copyright 2011 YAPT
 */

include_once 'libs/config.inc.php';

if (!isset($_POST['passwd'], $_POST['lang'], $_POST['code'])) {
    throw new Exception('POST values undefined!');
}

$passwd = $_POST['passwd'];
$lang = $_POST['lang'];
$code = $_POST['code'];
$flags = array();

if (strlen(trim($code)) == 0) {
    throw new Exception('Code empty!');
}

// Establish MySQL connection
$link = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);

if ($link === false) {
    throw new Exception('MySQL connection error: ' .mysql_error());
}

mysql_select_db(MYSQL_DATABASE, $link);

// Encrypt if password supplied
if (strlen($passwd) > 0) {
    array_push($flags, 'ENC_3DES');
    $passwd_hash = mhash(MHASH_SHA1, $passwd);
    $code = mcrypt_encrypt(MCRYPT_3DES, $passwd_hash, $code, MCRYPT_MODE_ECB);
} else {
    array_push($flags, 'ENC_PLAIN');
}

// Insert into database
mysql_query("INSERT INTO pastes 
    (flags, language, code)
    VALUES (
        '$flags', 
        '" .mysql_escape_string($lang) ."',
        '" .mysql_escape_string($code) ."' 
    )", $link);

// Redirect to paste
$id = mysql_insert_id($link);
header('Location: ' .CONF_URL .dechex($id));

mysql_close($link);

?>
