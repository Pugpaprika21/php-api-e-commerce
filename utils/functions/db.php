<?php

function db_connect(): mysqli
{
    global $env;
    if (isset($env)) {
        $conn = mysqli_connect($env['DB_HOST'], $env['DB_USERNAME'], $env['DB_PASSWORD'], $env['DB_NAME']);
        mysqli_set_charset($conn, $env['DB_CHARSET']);
        return (!$conn) ? false : $conn;
    }
    return false;
}


/**
 * #db_select('USER_TB');
 *
 * @param string $tbl_or_sql|$full_select
 * @param string $fields
 * @param string $condi
 * @return array
 */
function db_select($tbl_or_sql, $fields = '*', $condi = '', $to_arr = false)
{
    $items = [];
    $conn = db_connect();
    $wheres = ($condi != '') ? "WHERE 1=1 {$condi}" : "";
    $sql_select = "SELECT {$fields} FROM {$tbl_or_sql} {$wheres}";

    if (preg_match('/^SELECT/i', $tbl_or_sql)) {
        unset($sql_select);
        $sql_select = $tbl_or_sql;
    }

    $query_ = mysqli_query($conn, $sql_select);

    while ($rows = mysqli_fetch_assoc($query_)) {
        array_push($items, $rows);
    }

    mysqli_close($conn);

    if ($to_arr) {
        return $items;
    }

    return !empty($items[0]) ? $items[0] : $items;
}

/**
 * #db_insert('USER_TB', ['NAME' => 'alex', 'PASS' => '1234']);
 *
 * @param string $tbl
 * @param array $data
 * @param string $primary
 * @return array|bool
 */
function db_insert($tbl, $data, $primary = '?')
{
    $conn = db_connect();
    $fields = implode(", ", array_keys($data));
    $values = "'" . implode("', '", array_values($data)) . "'";
    $sql_insert = "INSERT INTO {$tbl}({$fields}) VALUES({$values})";

    $query_ = mysqli_query($conn, $sql_insert);

    if ($query_) {
        if ($primary != '?') {
            return db_select("SELECT * FROM {$tbl} ORDER BY {$primary} DESC LIMIT 1");
        }

        mysqli_close($conn);
        return true;
    }
    return false;
}

/**
 * #db_update('USER_TB', ['NAME' => 'alex', 'PASS' => '1234'], "USR_ID = '1'");
 *
 * @param string $tbl
 * @param array $data
 * @param string $condi
 * @return bool
 */
function db_update($tbl, $data, $condi)
{
    $fields = '';
    foreach ($data as $fields_ => $values_) {
        $fields .= !empty($fields) ? ', ' : '';
        $fields .= "{$fields_} = '{$values_}'";
    }

    $conn = db_connect();
    $sql_upd = "UPDATE {$tbl} SET {$fields} WHERE {$condi}";

    $query_upd = mysqli_query($conn, $sql_upd);

    mysqli_close($conn);
    return ($query_upd) ? true : false;
}

/**
 * #db_delete('USER_TB', "USR_ID = '1'");
 *
 * @param string $tbl
 * @param string $condi
 * @return bool
 */
function db_delete($tbl, $condi)
{
    $conn = db_connect();
    $sql_del = "DELETE FROM {$tbl} WHERE {$condi}";

    $query_del = mysqli_query($conn, $sql_del);

    mysqli_close($conn);
    return ($query_del) ? true : false;
}
