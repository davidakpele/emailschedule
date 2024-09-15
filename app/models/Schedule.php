<?php

class Schedule
{
    private $_connect_db;
    public function __construct(){
        $this->_connect_db = new Database;
    }

    public function createSchedule($recipientEmail, $subject, $body, $schedule_time, $user_id){
        $this->_connect_db->query(/** @lang text */"INSERT INTO `scheduled_emails`(`user_id`, `recipient_email`, `subject`, `body`, `scheduled_time`, `status`)VALUES (:user_id, :recipientEmail, :subject, :body, :schedule_time, 'pending')");
        $this->_connect_db->bind(':recipientEmail', $recipientEmail);
        $this->_connect_db->bind(':subject', $subject);
        $this->_connect_db->bind(':body', $body);
        $this->_connect_db->bind(':schedule_time', $schedule_time);
        $this->_connect_db->bind(':user_id', $user_id);
        if($this->_connect_db->execute()) {
            return true;
        }else {
            return false;
        }
    }

    public function getPendingEmails() {
        $this->_connect_db->query(/** @lang text */"SELECT * FROM `scheduled_emails` WHERE `status` = 'pending' AND `scheduled_time` <= NOW()");
        $row =$this->_connect_db->resultSet();
        if(!empty($row)) {
            return $row;
        }else {
            return [];
        }
    }

    public function updateEmailStatus($emailId, $status) {
        $this->_connect_db->query(/** @lang text */"UPDATE `scheduled_emails` SET `status` = :status WHERE `id` = :emailId");
        $this->_connect_db->bind(':status', $status);
        $this->_connect_db->bind(':emailId', $emailId);
        if($this->_connect_db->execute()) {
            return true;
        }else {
            return false;
        }
    }

    public function updateAttempt($attempts, $emailId){
        $this->_connect_db->query(/** @lang text */"UPDATE `scheduled_emails` SET `attempts` = :attempts WHERE `id` = :emailId");
        $this->_connect_db->bind(':attempts', $attempts);
        $this->_connect_db->bind(':emailId', $emailId);
        if($this->_connect_db->execute()) {
            return true;
        }else {
            return false;
        }
    }

}
