<?php

/**
 * Save the paste and redirect.
 *
 * @author    Michal Olech <me@dzonder.net>
 * @copyright 2011 YAPT
 */

include_once 'libs/config.inc.php';
include_once 'libs/geshi/geshi.php';

if (!isset($_POST['passwd'], $_POST['lang'], $_POST['code'])) {
    die('POST values undefined!');
}

if (strlen(trim($_POST['code'])) == 0) {
    die('Code empty!');
}

// Establish MySQL connection
mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);
mysql_select_db(MYSQL_DATABASE);

$raw_code = $_POST['code'];

// Hightlight using GeSHi
$geshi = new GeSHi($_POST['code'], $_POST['lang']);
$geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
$highlighted_code = $geshi->parse_code();

// Encrypt if password supplied
if (strlen($_POST['passwd']) > 0) {
    $flags = 'ENC_3DES';
    $hash = mhash(MHASH_SHA1, $_POST['passwd']);
    $raw_code = mcrypt_encrypt(MCRYPT_3DES, $hash, $raw_code, MCRYPT_MODE_ECB);
    $highlighted_code = mcrypt_encrypt(MCRYPT_3DES, $hash, $highlighted_code, MCRYPT_MODE_ECB);
} else {
    $flags = 'ENC_PLAIN';
}

// Insert into database
mysql_query("INSERT INTO pastes 
    (timesent, flags, raw_code, highlighted_code)
    VALUES (
        NOW(), 
        '$flags', 
        '" .mysql_escape_string($raw_code) ."', 
        '" .mysql_escape_string($highlighted_code) ."'
    )");

// Redirect to paste
$id = mysql_insert_id();
header('Location: ' .CONF_URL .dechex($id));

mysql_close();

?>
