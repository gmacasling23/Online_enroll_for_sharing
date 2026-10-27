/* ============================================================
   2. ADMIN: Admin/includes/conn.php
   Replaces removed mysql_* functions for PHP 7/8 compatibility.
   ============================================================ */

<?php
require_once __DIR__ . '/../../conn.php';

if (!function_exists('mysql_connect')) {
    $GLOBALS['legacyMysqli'] = $mysqli;

    function mysql_connect($host = null, $user = null, $password = null)
    {
        return $GLOBALS['legacyMysqli'];
    }

    function mysql_select_db($database, $connection = null)
    {
        return $GLOBALS['legacyMysqli']->select_db($database);
    }

    function mysql_query($query, $connection = null)
    {
        return $GLOBALS['legacyMysqli']->query($query);
    }

    function mysql_fetch_array($result, $mode = MYSQLI_BOTH)
    {
        return $result->fetch_array($mode);
    }

    function mysql_num_rows($result)
    {
        return $result->num_rows;
    }

    function mysql_insert_id($connection = null)
    {
        return $GLOBALS['legacyMysqli']->insert_id;
    }

    function mysql_error($connection = null)
    {
        return $GLOBALS['legacyMysqli']->error;
    }

    function mysql_real_escape_string($value, $connection = null)
    {
        return $GLOBALS['legacyMysqli']->real_escape_string($value);
    }
}
?>