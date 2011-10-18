<?php
include 'config.inc.php';
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
      <div><label for="password">Password</label></div>
      <div><input type="password" name="password" id="password" /></div>
      <div>If supplied, pasted code will be encrypted in database, otherwise everyone can view the paste.</div>
      <div><label for="language">Language</label></div>
      <div></div>
      <div><textarea name="code" rows="20" cols="85"></textarea></div>
      <div><input type="submit" value="Submit" /></div>
    </form>
    <p>Copyright &copy; 2011 by <a href="mailto:<?php echo CONF_FOOTER_EMAIL; ?>"><?php echo CONF_FOOTER_NAME; ?></a></p>
  </body>
</html>
