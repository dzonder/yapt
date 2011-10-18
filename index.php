<?php

/**
 * Index page with submit form.
 *
 * @author    Michal Olech <me@dzonder.net>
 * @copyright 2011 YAPT
 */

include_once 'libs/config.inc.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title><?php echo CONF_TITLE; ?> - Add new paste</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  </head>
  <body>
    <h1><?php echo CONF_TITLE; ?></h1>
    <h2>Add new paste</h2>
    <form method="post" action="paste">
      <div>
        <label for="frm-passwd">Password</label>
        <input type="password" name="passwd" id="frm-passwd" />
        <p class="description">If supplied, pasted code will be encrypted in database, otherwise everyone can view the paste.</p>
      </div>
      <div>
        <label for="frm-lang">Highlight</label>
        <select name="lang" id="frm-lang">
          <option value="none">None</option>
<?php
    foreach ($languages as $lang) {
        echo '<option value="' .$lang .'">' .ucfirst($lang) .'</option>';
    }
?>
        </select>
      </div>
      <div>
        <textarea name="code" rows="20" cols="85"></textarea>
      </div>
      <div>
        <input type="submit" value="Submit" />
      </div>
    </form>
    <p>Copyright &copy; 2011 by <a href="mailto:<?php echo CONF_FOOTER_EMAIL; ?>"><?php echo CONF_FOOTER_NAME; ?></a></p>
    <p><a href="http://validator.w3.org/check?uri=referer"><img src="valid-xhtml10.png" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a></p>
  </body>
</html>
