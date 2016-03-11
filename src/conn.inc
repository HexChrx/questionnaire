<?php

class Conn{

    protected $mysqli;

    function __construct(){

        if($config = parse_ini_file("dbconfig.ini")) {

            $ip = $config['ip'];
            $user = $config['user'];
            $pwd = $config['password'];
            $dbname = $config['dbname'];

            $this->mysqli = new mysqli($ip, $user, $pwd, $dbname);
        }

    }

    public function getConnectErrno(){

        return $this->mysqli->connect_errno;

    }

    public function setResultQuery($query, $param = array()){

        $array = null;
        if(!$this->mysqli->connect_errno){
            $stmt = $this->setStatment($query,$param);
            try{

                if($stmt != null){

                    if($stmt->execute()){
                        $stmt->store_result();
                        $variables = array();
                        $data = array();
                        $meta = $stmt->result_metadata();
                        while($field = $meta->fetch_field()){
                            $variables[] = &$data[$field->name];
                        }
                        call_user_func_array(array($stmt, 'bind_result'), $variables);
                        $i = 0;
                        while($stmt->fetch()){

                            $array[$i] = array();
                            foreach($data as $k=>$v){
                                $array[$i][$k] = $v;
                            }
                            ++$i;
                        }
                        $stmt->close();
                    }

                }

            }catch (Exception $e){
                $array = null;
            }
        }
        return $array;
    }

    private function setStatment($query, $param){

        $stmt = null;
        try{
            $stmt = $this->mysqli->prepare($query);
            if($stmt != null && count($param) != 0){

                foreach ($param as $value) {
                    $stmt->bind_param('s',$value);
                }
                /*$stmt->bind_param()
                $method = $ref->getMethod('bind_param');
                $method->invokeArgs($stmt, $param);
                */
            }

        }catch (Exception $e){
            if($stmt != null){
                $stmt->close();
            }
        }
        return $stmt;
    }

    function setNoResultQuery($query, $param = array()){

        $validtion = FALSE;
        if(!$this->mysqli->connect_errno){

            try{

                $stmt = $this->setStatment($query, $param);
                if($stmt != null){

                    if($stmt->execute()){

                        $stmt->close();
                        $validtion = true;

                    }

                }

            }catch (Exception $e){
                $validtion = false;
            }

        }
        return $validtion;
    }

    function setNoResultMultiQuery($query, $param = array()){

        $validtion = TRUE;
        if(!$this->mysqli->connect_errno){

            try{

                $stmt = $this->mysqli->prepare($query);
                if($stmt != null){

                    foreach($param as $v){

                        foreach($v as $value){
                            $stmt->bind_param('s',$value);
                        }
                        $validtion = $validtion && $stmt->execute();
                    }

                    $stmt->close();

                }

            }catch (Exception $e){
                $validtion = false;
            }

        }else{
            $validtion = false;
        }
        return $validtion;
    }

    public function beginTransaction(){

        $this->mysqli->autocommit(FALSE);
        //$this->mysqli->begin_transaction(0);

    }

    public function rollback(){

        $this->mysqli->rollback();
        $this->mysqli->autocommit(TRUE);

    }

    public function commit(){

        $res = $this->mysqli->commit();
        $this->mysqli->autocommit(true);
        return $res;
    }

}

