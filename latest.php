<?php

/**
 * Display the paste.
 *
 * @author    Michal Olech <me@dzonder.net>
 * @copyright 2011 YAPT
 */

include_once 'libs/config.inc.php';
include_once 'libs/rain.tpl.class.php';

$tpl = new RainTPL();
$tpl->configure('base_url', CONF_URL);

// Establish MySQL connection
$link = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);

if ($link === false) {
    throw new Exception('MySQL connection error: ' .mysql_error($link));
}

mysql_select_db(MYSQL_DATABASE, $link);

$result = mysql_query("SELECT id, timesent 
    FROM pastes 
    WHERE FIND_IN_SET('ENC_PLAIN', flags) 
    ORDER BY timesent DESC 
    LIMIT " .CONF_LATEST_LIMIT, $link);

$pastes = array();
while ($row = mysql_fetch_assoc($result)) {
    array_push($pastes, $row);
}

mysql_close($link);

$tpl->assign('subtitle', 'Latest pastes');
$tpl->assign('pastes', $pastes);
$tpl->draw('latest');

?>
