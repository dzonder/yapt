<?php

/**
 * Index page with submit form.
 *
 * @author    Michal Olech <me@dzonder.net>
 * @copyright 2011 YAPT
 */

include_once 'libs/config.inc.php';
include_once 'libs/rain.tpl.class.php';

$tpl = new RainTPL();

$tpl->assign('subtitle', 'New paste');

$tpl->draw('index');

?>
