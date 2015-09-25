<?php

/**
 * @author DjJustin
 * @copyright 2015
 */

/*
$authCheck=function() use ($app){

    //$app->redirect('/login');
};
*/

class Auth {
    var $userID;
    var $userRole;
    var $userName;
    var $userFIO;
    var $userIDKey;
    public function __construct(){
        
        $this->userRole="guest";
        $this->userID=0;
        $this->userName="";
        $this->userFIO="";
        $this->userIDKey=computer_name();
        
        if(isset($_SESSION['userid'])){
            $user = Model::factory('User')->find_one($_SESSION['userid']); 
            if ($user instanceof User) {
                $this->userID=$user->id;
                $this->userRole=$user->role;
                $this->userName=$user->name;
                $this->userFIO=$user->fio;
            }
            
        }
    }
    public function isLogged() {
        return isset($_SESSION['userid'])? true:false;
        
    }
    public function login($username, $password){
       $user = Model::factory('User')->where(array(
                'name' => $username,
                'password' => md5(md5($password))))->find_one(); 
        if (!$user instanceof User)
        {
            return false; 
        } else {
            $_SESSION['userid'] = $user->id;
            return true;
        }
    }
    public function logout(){
        unset($_SESSION['userid']);
    }
}

?>