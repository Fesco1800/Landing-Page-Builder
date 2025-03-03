<?php

class Database
{
    private $dbconn;

    function __construct()
    {
        $this->openDatabaseConnection();
    }

    /**
     * Open the database connection with the credentials from application/config/config.php
     */
    private function openDatabaseConnection()
    {
        // set the (optional) options of the PDO connection. in this case, we set the fetch mode to
        // "objects", which means all results will be objects, like this: $result->user_name
        // For example, fetch mode FETCH_ASSOC would return results like this: $result["user_name]
        // @see http://www.php.net/manual/en/pdostatement.fetch.php
        $options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING];

        // generate a database connection, using the PDO connector
        $this->dbconn = new PDO(DB_TYPE . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_USER, DB_PASS, $options);
    }

    function customQry($sql, $wParamData = null, $selectOne = false)
    {
        $query = $this->dbconn->prepare($sql);

        if ($wParamData) {
            $param = [];
            foreach ($wParamData as $k => $v) {
                $param[":" . $k] = $v;
            }
            $query->execute($param);
        } else {
            $query->execute();
        }

        if ($selectOne) {
            return $query->fetch();
        } else {
            return $query->fetchAll();
        }
    }

    function select($col, $tbl, $where, $wParamData = null)
    {
        $query = $this->dbconn->prepare("SELECT $col FROM $tbl WHERE $where");

        if ($wParamData) {
            $param = [];
            foreach ($wParamData as $k => $v) {
                $param[":" . $k] = $v;
            }
            $query->execute($param);
        } else {
            $query->execute();
        }

        return $query->fetchAll();
    }

    function selectOne($col, $tbl, $where, $wParamData = null)
    {
        $query = $this->dbconn->prepare("SELECT $col FROM $tbl WHERE $where LIMIT 1");

        if ($wParamData) {
            $param = [];
            foreach ($wParamData as $k => $v) {
                $param[":" . $k] = $v;
            }
            $query->execute($param);
        } else {
            $query->execute();
        }

        return $query->fetch();
    }

    function add($tbl, $data, $getID = false, $cleanXss = true)
    {
        $col = [];
        $val = [];
        $param = [];
        foreach ($data as $k => $v) {
            array_push($col, $k);
            array_push($val, ":" . $k);
            if (is_string($v) && $cleanXss) $v = cleanXss($v);
            $param[":" . $k] = $v;
        }
        $col = implode(",", $col);
        $val = implode(",", $val);

        // add IGNORE if getting ID for integrity constraint violation or inserting duplicate data for unique column
        $sql = ($getID) ? "INSERT IGNORE INTO $tbl ($col) VALUES ($val)" : "INSERT INTO $tbl ($col) VALUES ($val)";
        $query = $this->dbconn->prepare($sql);

        if ($getID) {
            $query->execute($param);
            return $this->dbconn->lastInsertId();
            // will return "0" if there's an error, e.g. Integrity constraint violation or inserting duplicate data for unique column
        } else {
            return $query->execute($param);
        }
    }

    function update($tbl, $data, $where, $wParamData = null, $cleanXss = true)
    {
        $colVal = [];
        $param = [];
        foreach ($data as $k => $v) {
            array_push($colVal, $k . "=:" . $k);
            if (is_string($v) && $cleanXss) $v = cleanXss($v);
            $param[":" . $k] = $v;
        }
        $colVal = implode(",", $colVal);

        if ($wParamData) {
            foreach ($wParamData as $k => $v) {
                $param[":" . $k] = $v;
            }
        }

        $sql = "UPDATE $tbl SET $colVal WHERE $where";
        $query = $this->dbconn->prepare($sql);
        return $query->execute($param);
    }

    function delete($tbl, $where, $wParamData = null)
    {
        $query = $this->dbconn->prepare("DELETE FROM $tbl WHERE $where");

        if ($wParamData) {
            $param = [];
            foreach ($wParamData as $k => $v) {
                $param[":" . $k] = $v;
            }
            return $query->execute($param);
        } else {
            return $query->execute();
        }
    }

    function deleteCustom($sql, $wParamData = null)
    {
        $query = $this->dbconn->prepare($sql);

        if ($wParamData) {
            $param = [];
            foreach ($wParamData as $k => $v) {
                $param[":" . $k] = $v;
            }
            return $query->execute($param);
        } else {
            return $query->execute();
        }
    }

    /**
     * @param array $data, in clause values
     * @param string $wparam_prefix, where parameter prefix for prepared statement
     */
    function prepareInClause($data, $wparam_prefix = 'id')
    {
        $r = [
            'w_param' => [],
            'collection' => ''
        ];

        if (!empty($data)) {
            $c = 0;
            $collection = [];
            foreach ($data as $v) {
                if ($v === '') continue;
                $param_name = 'wparam_' . $wparam_prefix . '_' . $c;
                $r['w_param'][$param_name] = $v;
                $collection[] = ':' . $param_name;
                ++$c;
            }
            $r['collection'] = implode(',', $collection);
        }

        return $r;
    }

    function setCharset($charset)
    {
        $qry = $this->dbconn->prepare('set names ' . $charset);
        $qry->execute();
    }
}
