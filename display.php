<?php

/**
 * Display the paste.
 *
 * @author    Michal Olech <me@dzonder.net>
 * @copyright 2011 YAPT
 */

include_once 'libs/config.inc.php';
include_once 'libs/rain.tpl.class.php';
include_once 'libs/geshi/geshi.php';

$tpl = new RainTPL();
$tpl->configure('base_url', CONF_URL);

if (!isset($_GET['id'])) {
    die('ID undefined!');
}

$raw = isset($_GET['raw']);
$tpl->assign('id', $_GET['id']);

// Establish MySQL connection
mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);
mysql_select_db(MYSQL_DATABASE);

$result = mysql_query("SELECT * FROM pastes WHERE id=" .hexdec($_GET['id']));
$paste = mysql_fetch_assoc($result);

mysql_close();

if (!isset($paste['id'])) {
    die('ID does not exist!');
}

$code = $paste['code'];

if (strpos($paste['flags'], 'ENC_3DES') !== false) {
    if (!isset($_POST['passwd'])) {
        $tpl->assign('subtitle', 'Display encrypted paste');
        $tpl->draw('password');
        die();
    } else {
        $hash = mhash(MHASH_SHA1, $_POST['passwd']);
        $code = trim(mcrypt_decrypt(MCRYPT_3DES, $hash, $code, MCRYPT_MODE_ECB));
    }
}

if ($raw) {
    echo $code;
} else {
    // Highlight using GeSHi
    $geshi = new GeSHi($code, $paste['language']);
    $geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
    $code = $geshi->parse_code();

    $tpl->assign('subtitle', 'Paste ID ' .dechex($paste['id']));
    $tpl->assign('code', $code);
    $tpl->draw('display');
}

?>
