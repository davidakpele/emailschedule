<?php


class User
{

    private $_connect_db;
    public function __construct(){
        $this->_connect_db = new Database;
    }
    
    public function process_login($username, $password){
        $this->_connect_db->query(/** @lang text */ 'SELECT a.* FROM users a WHERE a.username = :username');
        // Bind the values
        $this->_connect_db->bind(':username', $username);
        $row = $this->_connect_db->single();
        if(!empty($row)){
            $hashedPassword = $row->password;
            if(password_verify($password, $hashedPassword)){
                return $row;
            }else {
                return false;
            }
        }else {
            return false;
        }
    }

    public function verifyEmail($email):bool{
        $this->_connect_db->query(/** @lang text */ 'SELECT a.* FROM users a WHERE a.email = :email');
        $this->_connect_db->bind(':email', $email);
        if($this->_connect_db->rowCount() > 0){
			return true;
		}else{
			return false;
		}
    }
    
    public function verifyUsername($username):bool{
        $this->_connect_db->query(/** @lang text */ 'SELECT a.* FROM users a WHERE a.username = :username');
        $this->_connect_db->bind(':username', $username);
        if($this->_connect_db->rowCount() > 0){
			return true;
		}else{
			return false;
		}
    }

    public function process_registration($email, $username, $mobile, $password){
        $this->_connect_db->query(/** @lang text */"INSERT INTO `users`(`email`, `username`, `mobile`, `password`)VALUES (:email, :username, :mobile, :password)");
        $this->_connect_db->bind(':email', $email);
        $this->_connect_db->bind(':username', $username);
        $this->_connect_db->bind(':mobile', $mobile);
        $this->_connect_db->bind(':password', $password);
        if($this->_connect_db->execute()) {
            return true;
        }else {
            return false;
        }

    }
}
