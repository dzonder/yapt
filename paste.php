<?php

/**
 * Save the paste and redirect.
 *
 * @author    Michal Olech <me@dzonder.net>
 * @copyright 2011 YAPT
 */

include_once 'libs/config.inc.php';

if (!isset($_POST['passwd'], $_POST['lang'], $_POST['code'])) {
    die('POST values undefined!');
}

$passwd = $_POST['passwd'];
$lang = $_POST['lang'];
$code = $_POST['code'];

if (strlen(trim($code)) == 0) {
    die('Code empty!');
}

// Establish MySQL connection
mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);
mysql_select_db(MYSQL_DATABASE);

// Encrypt if password supplied
if (strlen($passwd) > 0) {
    $flags = 'ENC_3DES';
    $hash = mhash(MHASH_SHA1, $passwd);
    $code = mcrypt_encrypt(MCRYPT_3DES, $hash, $code, MCRYPT_MODE_ECB);
} else {
    $flags = 'ENC_PLAIN';
}

// Insert into database
mysql_query("INSERT INTO pastes 
    (flags, language, code)
    VALUES (
        '$flags', 
        '" .mysql_escape_string($lang) ."',
        '" .mysql_escape_string($code) ."' 
    )");

// Redirect to paste
$id = mysql_insert_id();
header('Location: ' .CONF_URL .dechex($id));

mysql_close();

?>
