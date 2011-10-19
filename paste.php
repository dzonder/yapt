<?php

/**
 * Save the paste and redirect.
 *
 * @author    Michal Olech <me@dzonder.net>
 * @copyright 2011 YAPT
 */

include_once 'libs/config.inc.php';
include_once 'libs/mysql.inc.php';

if (!isset($_POST['passwd'], $_POST['lang'], $_POST['code'])) {
    throw new Exception('POST values undefined!');
}

$passwd = $_POST['passwd'];
$lang = $_POST['lang'];
$code = $_POST['code'];
$flags = array();

if (!isset($conf_languages[$lang])) {
    throw new Exception('Language does not exist!');
}

if (strlen(trim($code)) == 0) {
    throw new Exception('Code empty!');
}

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
        '" .implode($flags, ',') ."', 
        '" .mysql_escape_string($lang) ."',
        '" .mysql_escape_string($code) ."' 
    )");

// Redirect to paste
$id = mysql_insert_id($link);
header('Location: ' .CONF_URL .dechex($id));

?>
