<?php

class Conn
{

    protected $mysqli;
    protected $stmt;
    protected $insetId;

    function __construct()
    {

        if ($config = parse_ini_file("dbconfig.ini")) {

            $ip = $config['ip'];

            $user = $config['user'];
            $pwd = $config['password'];
            $dbname = $config['dbname'];

            $this->mysqli = new mysqli($ip, $user, $pwd, $dbname);
            $this->mysqli->set_charset('utf8');
        }

    }

    public function getConnectErrno()
    {

        return $this->mysqli->connect_errno;

    }

    public function setResultQuery($query, $param = array())
    {

        $array = null;
        if (!$this->mysqli->connect_errno) {
            $this->stmt = $this->setStatment($query, $param);
            try {

                if ($this->stmt != null) {
                    if ($this->stmt->execute()) {
                        $this->stmt->store_result();
                        $variables = array();
                        $data = array();
                        $meta = $this->stmt->result_metadata();
                        while ($field = $meta->fetch_field()) {
                            $variables[] = &$data[$field->name];
                        }
                        call_user_func_array(array($this->stmt, 'bind_result'), $variables);
                        $i = 0;
                        while ($this->stmt->fetch()) {

                            $array[$i] = array();
                            foreach ($data as $k => $v) {
                                $array[$i][$k] = $v;
                            }
                            ++$i;
                        }
                        $this->stmt->close();
                    }

                }

            } catch (Exception $e) {
                $array = null;
            }
        }
        return $array;
    }

    private function refValues($param)
    {
        //Reference is required for PHP 5.3+
        if (strnatcmp(phpversion(), '5.3') >= 0) {
            $refs = array();
            foreach ($param as $key => $value)
                $refs[$key] = &$param[$key];
            return $refs;
        }
        return $param;
    }

    private function setStatment($query, $param)
    {

        try {
            $stmt = $this->mysqli->prepare($query);
            if ($stmt != null && count($param) != 0) {

                call_user_func_array(array($stmt, "bind_param"),
                    $this->refValues($param));

            }

        } catch (Exception $e) {
            if ($stmt != null) {
                $stmt->close();
            }
        }
        return $stmt;
    }

    function getInsertId(){

        if(isset($this->insetId)){

            return $this->insetId;

        }
        return false;

    }

    function setNoResultQuery($query, $param = array())
    {

        $validtion = FALSE;
        if (!$this->mysqli->connect_errno) {

            try {

                $this->stmt = $this->setStatment($query, $param);
                if ($this->stmt != null) {

                    if ($this->stmt->execute()) {
                        $this->insetId = $this->stmt->insert_id;
                        $this->stmt->close();
                        $validtion = true;

                    }

                }

            } catch (Exception $e) {
                $validtion = false;
            }

        }

        return $validtion;
    }

    function setNoResultMultiQuery($query, $param = array())
    {

        $validtion = TRUE;
        if (!$this->mysqli->connect_errno) {

            try {

                $this->stmt = $this->mysqli->prepare($query);
                if ($this->stmt != null) {
                    foreach ($param as $v) {

                        call_user_func_array(array($this->stmt, "bind_param"),
                            $this->refValues($v));

                        $validtion = $validtion && $this->stmt->execute();
                    }

                    $this->stmt->close();

                }

            } catch (Exception $e) {
                $validtion = false;
            }

        } else {
            $validtion = false;
        }
        return $validtion;
    }

    public function beginTransaction()
    {

        $this->mysqli->autocommit(FALSE);
        //$this->mysqli->begin_transaction(0);

    }

    public function rollback()
    {

        $this->mysqli->rollback();
        $this->mysqli->autocommit(TRUE);

    }

    public function commit()
    {

        $res = $this->mysqli->commit();
        $this->mysqli->autocommit(true);
        return $res;
    }

}

