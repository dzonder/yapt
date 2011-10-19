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
include_once 'libs/mysql.inc.php';

$tpl = new RainTPL();
$tpl->configure('base_url', CONF_URL);

if (!isset($_GET['id'])) {
    throw new Exception('ID undefined!');
}

$raw = isset($_GET['raw']);
$tpl->assign('id', $_GET['id']);

$result = mysql_query("SELECT * FROM pastes WHERE id=" .hexdec($_GET['id']));
$paste = mysql_fetch_assoc($result);

if (!isset($paste['id'])) {
    throw new Exception('ID does not exist!');
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
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=raw.' .$conf_languages[$paste['language']]['extension']);
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' .mb_strlen($code, '8bit'));
    echo $code;
} else {
    // Highlight using GeSHi
    $geshi = new GeSHi($code, $paste['language']);
    $geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
    $code = $geshi->parse_code();

    $tpl->assign('subtitle', 'Paste ' .dechex($paste['id']));
    $tpl->assign('lang', $conf_languages[$paste['language']]['label']);
    $tpl->assign('code', $code);

    $tpl->draw('display');
}

?>
