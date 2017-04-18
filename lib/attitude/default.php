<?php
#author: BAO
#Class used for rating parks
class Attitude{

    #Init class with db string
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    #search all attitude for current park
    public function getAttitude($parkId) {
        $attitudeQuery = 'SELECT * FROM attitude WHERE park_id = :park_id';
        $attitudeStmt = $this->db->prepare($attitudeQuery);
        $attitudeStmt->bindValue(':park_id', $parkId, PDO::PARAM_INT);
        $attitudeStmt->execute();
        return $attitudeStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    #update rate for user
    public function updateRate($parkId, $userId, $rateNum) {
        #insert or update
        $rateQuery = 'INSERT INTO attitude (park_id, user_id, attitude_rate) VALUES (:parkId, :userId, :attitudeRate) ON DUPLICATE KEY UPDATE attitude_rate = :attitudeRate';
        try{
            $rateStmt = $this->db->prepare($rateQuery);
            $rateStmt->bindValue(':parkId', $parkId, PDO::PARAM_INT);
            $rateStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
            $rateStmt->bindValue(':attitudeRate', $rateNum, PDO::PARAM_INT);
            $this->db->beginTransaction();
            $rateStmt->execute();
            $this->db->commit();
            return 1;
        } catch(PDOExecption $e) {
            $this->db->rollback();
            return 0;
        }
    }

    #update worth for user
    public function updateWorth($parkId, $userId, $worthNum) {
        if ($worthNum != '0' && $worthNum != 1) {
            $worthNum = null;
        }
        #insert or update
        $worthQuery = 'INSERT INTO attitude (park_id, user_id, attitude_worth) VALUES (:parkId, :userId, :attitudeWorth) ON DUPLICATE KEY UPDATE attitude_worth = :attitudeWorth';
        try{
            $worthStmt = $this->db->prepare($worthQuery);
            $worthStmt->bindValue(':parkId', $parkId, PDO::PARAM_INT);
            $worthStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
            $worthStmt->bindValue(':attitudeWorth', $worthNum);
            $this->db->beginTransaction();
            $worthStmt->execute();
            $this->db->commit();
            return 1;
        } catch(PDOExecption $e) {
            $this->db->rollback();
            return 0;
        }
    }

    #update back for user
    public function updateBack($parkId, $userId, $backNum) {
        if ($backNum != '0' && $backNum != 1) {
            $backNum = null;
        }
        #insert or update
        $backQuery = 'INSERT INTO attitude (park_id, user_id, attitude_back) VALUES (:parkId, :userId, :attitudeBack) ON DUPLICATE KEY UPDATE attitude_back = :attitudeBack';
        try{
            $backStmt = $this->db->prepare($backQuery);
            $backStmt->bindValue(':parkId', $parkId, PDO::PARAM_INT);
            $backStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
            $backStmt->bindValue(':attitudeBack', $backNum);
            $this->db->beginTransaction();
            $backStmt->execute();
            $this->db->commit();
            return 1;
        } catch(PDOExecption $e) {
            $this->db->rollback();
            return 0;
        }
    }

    /**
     * Function to delete all attitudes of a user
     *
     * @param $sUserId
     *
     * author: Irfaan
     */
    public function deleteAllAttitudeOfUser($sUserId) {
        $deleteQuery = 'DELETE FROM attitude WHERE user_id = :userId';
        $deleteStmt = $this->db->prepare($deleteQuery);
        $deleteStmt->bindValue(':userId', $sUserId, PDO::PARAM_INT);
        $deleteStmt->execute();
    }

}
