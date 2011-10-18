<?php

/**
 * Display the paste.
 *
 * @author    Michal Olech <me@dzonder.net>
 * @copyright 2011 YAPT
 */

include_once 'config.inc.php';

function _die($msg=false) {
    if ($msg) echo $msg;
    mysql_close();
    exit;
}

if (!isset($_GET['id'])) {
    die('ID undefined!');
}

// Establish MySQL connection
mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);
mysql_select_db(MYSQL_DATABASE);

$result = mysql_query("SELECT id, flags, raw_code, highlighted_code FROM pastes WHERE id=" .hexdec($_GET['id']));
$paste = mysql_fetch_assoc($result);

if (!isset($paste['id'])) {
    _die('ID does not exist!');
}

if (isset($_GET['raw'])) {
    $code = $paste['raw_code'];
} else {
    $code = $paste['highlighted_code'];
}

if (strpos($paste['flags'], 'ENC_3DES') !== false) {
    if (!isset($_POST['passwd'])) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title><?php echo CONF_TITLE; ?> - Display encrypted paste</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  </head>
  <body>
    <h1><?php echo CONF_TITLE; ?></h1>
    <h2>Display encrypted paste</h2>
    <p>This paste is encrypted. Enter password to view the code. If you enter wrong password you will see thrash.</p>
    <form method="post" action="<?php echo $_GET['id']; ?>">
      <div>
        <label for="frm-passwd">Password</label>
        <input type="password" name="passwd" id="frm-passwd" />
      </div>
      <div>
        <input type="submit" value="Submit" />
      </div>
    </form>
    <p>Copyright &copy; 2011 by <a href="mailto:<?php echo CONF_FOOTER_EMAIL; ?>"><?php echo CONF_FOOTER_NAME; ?></a></p>
    <p><a href="http://validator.w3.org/check?uri=referer"><img src="valid-xhtml10.png" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a></p>
  </body>
</html>
<?php
        _die();
    } else {
        $hash = mhash(MHASH_SHA1, $_POST['passwd']);
        $code = mcrypt_decrypt(MCRYPT_3DES, $hash, $code, MCRYPT_MODE_ECB);
    }
}

if (isset($_GET['raw'])) {
    echo $code;
} else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title><?php echo CONF_TITLE; ?> - Paste ID <?php echo dechex($paste['id']); ?></title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  </head>
  <body>
    <?php echo $code; ?>
  </body>
</html>
<?php
}

mysql_close();

?>
