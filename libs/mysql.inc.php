<?php

/**
 * Establishing MySQL connection.
 *
 * @author    Michal Olech <me@dzonder.net>
 * @copyright 2011 YAPT
 */

$link = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);

if ($link === false) {
    throw new Exception('MySQL connection error: ' .mysql_error($link));
}

mysql_select_db(MYSQL_DATABASE, $link);

?>
