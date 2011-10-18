<?php

/**
 * Configuration file.
 *
 * @author    Michal Olech <me@dzonder.net>
 * @copyright 2011 YAPT
 */

/**
 * Page url - used in redirection
 */
define('CONF_URL', 'http://localhost/yapt/');

/**
 * Page title
 */
define('CONF_TITLE', 'Yet Another Paste Tool');

/**
 * Name in copyright - page footer
 */
define('CONF_FOOTER_NAME', 'dzonder');

/**
 * Email in copyright - page footer
 */
define('CONF_FOOTER_EMAIL', 'me(at)dzonder(dot)net');

/**
 * Enabled language highlighters
 */
// TODO cache languages scan
$languages = array_map(
    create_function('$s', 'return substr($s, 0, -4);'), 
    array_filter(
        scandir('geshi/languages'),
        create_function('$s', 'return $s != "." && $s != "..";')
    )
);

/**
 * MySQL server. Specify port by adding :port
 */
define('MYSQL_HOST', 'localhost');

/**
 * MySQL user name
 */
define('MYSQL_USER', 'yapt');

/**
 * MySQL password
 */
define('MYSQL_PASSWORD', 'yapt');

/**
 * MySQL database to use by default
 */
define('MYSQL_DATABASE', 'yapt');

?>
