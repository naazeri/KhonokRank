<?php
/*
 * Poll Management Class
 * This class is used to manage the online poll & voting system
 * @author    CodexWorld.com
 * @url       http://www.codexworld.com
 * @license   http://www.codexworld.com/license
 */
class Poll {
    private $dbHost  = 'localhost';
    private $dbUser  = 'nazeryir_pyreza';
    private $dbPwd   = 'F,r*J^_90tNBoc?v~,';
    private $dbName  = 'nazeryir_poll_system';            
    private $db      = false;
    private $pollTbl = 'polls';
    private $optTbl  = 'poll_options';
    private $voteTbl = 'poll_votes';
    
    public function __construct() {
        if (!$this->db) {
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUser, $this->dbPwd, $this->dbName);
            if ($conn->connect_error) {
                die("Failed to connect with MySQL: " . $conn->connect_error);
            } else {
                $conn->query("SET NAMES 'utf8'");
                $conn->query("SET CHARACTER SET 'utf8'");
                $conn->query("SET character_set_connection = 'utf8'");
                $this->db = $conn;
            }
        }
    }
    
    /*
     * Runs query to the database
     * @param string SQL
     * @param string count, single, all
     */
    private function getQuery($sql,$returnType = '') {
        $data = '';
        $result = $this->db->query($sql);
        if($result){
            switch($returnType){
                case 'count':
                    $data = $result->num_rows;
                    break;
                case 'single':
                    $data = $result->fetch_assoc();
                    break;
                default:
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $data[] = $row;
                        }
                    }
            }
        }
        return !empty($data)?$data:false;
    }
    
    /*
     * Get polls data
     * Returns single or multiple poll data with respective options
     * @param string single, all
     */
    public function getPolls($pollType = 'single'){
        $pollData = array();
        $sql = "SELECT * FROM ".$this->pollTbl." WHERE status = '1' ORDER BY created DESC";
        $pollResult = $this->getQuery($sql, $pollType);
        if(!empty($pollResult)){
            if($pollType == 'single'){
                $pollData['poll'] = $pollResult;
                $sql2 = "SELECT * FROM ".$this->optTbl." WHERE poll_id = ".$pollResult['id']." AND status = '1'";
                $optionResult = $this->getQuery($sql2);
                $pollData['options'] = $optionResult;
            }else{
                $i = 0;
                foreach($pollResult as $prow){
                    $pollData[$i]['poll'] = $prow;
                    $sql2 = "SELECT * FROM ".$this->optTbl." WHERE poll_id = ".$prow['id']." AND status = '1'";
                    $optionResult = $this->getQuery($sql2);
                    $pollData[$i]['options'] = $optionResult;
                }
            }
        }
        return !empty($pollData)?$pollData:false;
    }
    
    /*
     * Submit vote
     * @param array of poll option data
     */
    public function vote($data = array()) {
        if (!isset($data['poll_id']) || !isset($data['poll_option_id']) || isset($_COOKIE[$data['poll_id']])) {
            return false;
        } else {
            $sql = "SELECT * FROM ".$this->voteTbl." WHERE poll_id = ".$data['poll_id']." AND poll_option_id = ".$data['poll_option_id'];
            $preVote = $this->getQuery($sql, 'count');
            if ($preVote > 0) {
                $query = "UPDATE ".$this->voteTbl." SET vote_count = vote_count+1 WHERE poll_id = ".$data['poll_id']." AND poll_option_id = ".$data['poll_option_id'];
                $update = $this->db->query($query);
            } else {
                $query = "INSERT INTO ".$this->voteTbl." (poll_id,poll_option_id,vote_count) VALUES (".$data['poll_id'].",".$data['poll_option_id'].",1)";
                $insert = $this->db->query($query);
            }
            return true;
        }
    }
    
    /*
     * Get poll result
     * @param poll ID
     */
    public function getResult($pollID){
        $resultData = array();
        if(!empty($pollID)){
            $sql = "SELECT p.subject, SUM(v.vote_count) as total_votes FROM ".$this->voteTbl." as v LEFT JOIN ".$this->pollTbl." as p ON p.id = v.poll_id WHERE poll_id = ".$pollID;
            $pollResult = $this->getQuery($sql,'single');
            if(!empty($pollResult)){
                $resultData['poll'] = $pollResult['subject'];
                $resultData['total_votes'] = $pollResult['total_votes'];
                $sql2 = "SELECT o.id, o.name, v.vote_count FROM ".$this->optTbl." as o LEFT JOIN ".$this->voteTbl." as v ON v.poll_option_id = o.id WHERE o.poll_id = ".$pollID;
                $optResult = $this->getQuery($sql2);
                if(!empty($optResult)){
                    foreach($optResult as $orow){
                        $resultData['options'][$orow['name']] = $orow['vote_count']; 
                    }
                }
            }
        }
        return !empty($resultData)?$resultData:false;
    }
}