<?php
require_once(dirname(__FILE__) . '/config.php');

class Database
{
    // {{{ private members
    var $_conn;
    var $_error;
    var $_errmsg;
    // }}}

    // {{{ constructor
    function Database()
    {
        $this->_connect();
    }
    // }}}

    // {{{ public functions
    /**
     * execute $query and return the result handler
     */
    function query($query)
    {
        $res = @mysql_query($query, $this->_conn);
        if (!$res) {
            $this->_errorout('Query error: ' . mysql_error($this->_conn));
            return false;
        }

        $this->_errorok();
        return $res;
    }

    /**
     * get number of rows for resource link identifier
     */
    function num_rows($res)
    {
        return mysql_num_rows($res);
    }

    /**
     * fetch next row
     */
    function fetch($res)
    {
        return mysql_fetch_assoc($res);
    }

    /**
     * execute $query and return first row
     */
    function select($query)
    {
        $res = $this->query($query);
//echo $query."<br/>";
        if (!$res) return false;

        $this->_errorok();
        return @mysql_fetch_assoc($res);
    }

    /**
     * execute $query and return all rows
     */
    function selectMultiple($query)
    {
        $res = $this->query($query);
        if (!$res) return false;

        $arr = array();
        while ($row = @mysql_fetch_assoc($res)) $arr[] = $row;

        $this->_errorok();
        return $arr;
    }

    /**
     * execute $query and return all rows indexed by a given $key
     * (if $excludeKey is true, the $key is not included in the returned rows)
     */
    function selectMultipleByKey($query, $key = 'id', $excludeKey = false)
    {
        $res = $this->query($query);
        if (!$res) return false;

        $arr = array();
        while ($row = @mysql_fetch_assoc($res)) {
            $k = $row[$key];
            if ($excludeKey) unset($row[$key]);
            $arr[$k] = $row;
        }

        $this->_errorok();
        return $arr;
    }

    /**
     * Return an entire $table in a multiple array
     */
    function getTable($table, $order = '', $desc = false)
    {
        $sql = "SELECT * FROM `$table`";
        if (!empty($order)) {
            $sql .= " ORDER BY `$order`";
            if ($desc) $sql .= ' DESC';
        }
        return $this->selectMultiple($sql);
    }

    /**
     * Return an entire $table in a multiple array, indexed by a given $key
     */
    function getTableByKey($table, $key = 'id', $order = '', $desc = false)
    {
        $sql = "SELECT * FROM `$table`";
        if (!empty($order)) {
            $sql .= " ORDER BY `$order`";
            if ($desc) $sql .= ' DESC';
        }
        return $this->selectMultipleByKey($sql, $key, false);
    }

    /**
     * insert a row in a $table. $fields si an array of field names and $values
     *  is an array of values indexed by field names
     */
    function insert($table, $fields, $values)
    {
        $keys = array();
        $vals = array();
        foreach ($fields as $field) {
            $keys[] = "`$field`";
            $vals[] = "'" . $this->escape($values[$field]) . "'";
        }
        $sql = "INSERT INTO `$table` (" . implode(', ', $keys)
                        . ") VALUES (" . implode(', ', $vals) . ")";

		//echo $sql . "<br/>";
        //die(print_r($sql));
        return $this->query($sql);
    }

    /**
     * update rows in a $table. $fields si an array of field names and $values
     *  is an array of values indexed by field names
     *  $where is the WHERE condition for row selection
     */
    function update($table, $fields, $where = array())
    {
        $sets = array();
        foreach ($fields as $key => $value) {
            $sets[] = "`$key` = '" . $this->escape($value) . "'";
        }
        $sql = "UPDATE `$table` SET " . implode(', ', $sets);
        
        if (!empty($where)) $sql .= " WHERE ".$where['field']."='".$where['value']."'";
	    return $this->query($sql);
    }

    /**
     * delete rows in a $table. $where is the WHERE condition for row selection
     */
    function delete($table, $where)
    {
        $sql = "DELETE FROM `$table`";
        if (!empty($where)) $sql .= " WHERE $where";
        return $this->query($sql);
    }

    /**
     * escape string for use in sql queries
     */
    function escape($str)
    {
        return mysql_real_escape_string($str, $this->_conn);
    }

	
    
    /**
     * get ID of last inserted row
     */
    function insert_id()
    {
        return @mysql_insert_id($this->_conn);
    }

    /**
     * check error state for last executed function
     */
    function isError()
    {
        return $this->_error;
    }

    /**
     * get error message for last executed function
     */
    function error()
    {
        if ($this->_error) {
            return $this->_errmsg;
        } else {
            return false;
        }
    }
    // }}}

    // {{{ private functions
    function _connect()
    {
        if (!($this->_conn = @mysql_connect(MYSQL_HOST,
                                            MYSQL_USER,
                                            MYSQL_PASS))) {
            $this->_errorout('Could not connect: '.mysql_error());
            return false;
        }

        if (!@mysql_select_db(MYSQL_DB, $this->_conn)) {
            $this->_errorout('Could not select db: '.mysql_error($this->_conn));
            return false;
        }

        $this->_errorok();
        return true;
    }

    function _errorout($error)
    {
        $this->_error = true;
        $this->_errmsg = $error;
    }

    function _errorok()
    {
        $this->_error = false;
        $this->_errmsg = '';
    }

   function getLastID($table) {
	
		$lastID = $this->select("SELECT id FROM $table ORDER BY id DESC LIMIT 1");
	
		return $lastID['id'];
   }
    // }}}
}
?>
