<?php

/**
 * Display the paste.
 *
 * @author    Michal Olech <me@dzonder.net>
 * @copyright 2011 YAPT
 */

include_once 'libs/config.inc.php';
include_once 'libs/rain.tpl.class.php';
include_once 'libs/mysql.inc.php';

$tpl = new RainTPL();

$result = mysql_query("SELECT id, timesent 
    FROM pastes 
    WHERE encryption = 'ENC_PLAIN' 
    ORDER BY timesent DESC 
    LIMIT " .CONF_LATEST_LIMIT);

$pastes = array();
while ($row = mysql_fetch_assoc($result)) {
    array_push($pastes, $row);
}

$tpl->assign('subtitle', 'Latest pastes');
$tpl->assign('subdescription', 'only unencrypted pastes are visible');
$tpl->assign('pastes', $pastes);

$tpl->draw('latest');

?>
