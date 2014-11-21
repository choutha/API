<?php

class Database {

    private $dbn;

    public function __construct($type="mysql", $database="webnew", $username = "gewisapi", $password = "97f85e750585840024b3a9ab2211b604a0129067", $location = "gewis.nl") {
        $this->dbn = new PDO("$type:host=$location;dbname=$database", $username, $password);
        $this->dbn->setAttribute(PDO::ATTR_AUTOCOMMIT, TRUE);
        $this->dbn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE);
    }

    public function nquery($szQuery, $arr = array()) {
        $pStatement = $this->dbn->prepare($szQuery);
        $pStatement->execute($arr);
        return array();
    }

    public function getError() {
        print_r($this->dbn->errorInfo());
        return array();
    }

    public function query($szQuery, $arr = array(), $flags = PDO::FETCH_NUM) {
        $pStatement = $this->dbn->prepare($szQuery);
        $pStatement->execute($arr);
        $aResult = $pStatement->fetchAll($flags); // Without fetch num this will default to AND the column index and column name.
        return $aResult;
    }

    public function tquery(){
        $p = func_get_args();
        $num = func_num_args();
        $type = PDO::FETCH_NUM;
        if($num<1){
            return array();
        } else if($num>=2){
            if(gettype($p[0])=="integer"){
                $type = array_shift($p);
            }
        }
        $pStatement = $this->dbn->prepare(array_shift($p));
        $pStatement->execute($p);
        return $pStatement->rowCount()?$pStatement->fetchAll($type):array();
    }

    public function first(){
        $p = func_get_args();
        $num = func_num_args();
        $type = PDO::FETCH_NUM;
        if($num<1){
            return array();
        } else if($num>=2){
            if(gettype($p[0])=="integer"){
                $type = array_shift($p);
            }
        }
        $pStatement = $this->dbn->prepare(array_shift($p));
        $pStatement->execute($p);
        return $pStatement->rowCount()==1?$pStatement->fetch($type):array();
    }

    public function dquery($szQuery, $arr = array(), $flags = PDO::FETCH_NUM) {
        $pStatement = $this->dbn->prepare($szQuery);
        $pStatement->execute($arr);
        $aResult = $pStatement->rowCount();
        return $aResult;
    }

    public function Q() {
        require_once("query.php");
        return new Query($this);
    }

    public function getDBN() {
        return $this->dbn;
    }

}

?>

