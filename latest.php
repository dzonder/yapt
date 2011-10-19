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
$tpl->configure('base_url', CONF_URL);

$result = mysql_query("SELECT id, timesent 
    FROM pastes 
    WHERE FIND_IN_SET('ENC_PLAIN', flags) 
    ORDER BY timesent DESC 
    LIMIT " .CONF_LATEST_LIMIT);

$pastes = array();
while ($row = mysql_fetch_assoc($result)) {
    array_push($pastes, $row);
}

$tpl->assign('subtitle', 'Latest pastes');
$tpl->assign('pastes', $pastes);

$tpl->draw('latest');

?>
