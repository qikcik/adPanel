<?php
    session_start();
    require_once("core/ActiveDirectory.php");

    class Session
    {
        public $AD;


        public function isLoginUser() { return $this->AD->isUserConnect(); }

        public function __construct(&$ad) 
        {
            $this->AD = &$ad;

            if( $this->AD->isConnect() )
            {
                $this->login();
            }
        }

        public function setUser($username,$passsword)
        {
            if( $this->isLoginUser() ) $this->logout();

            $_SESSION['user']['username'] = $username;
            $_SESSION['user']['password'] = $passsword;

            return $this->login();
        }

        public function updatePassword($pass)
        {
            if( $this->isLoginUser() ) 
            {
                $_SESSION['user']['password'] = $pass;
                return true;
            }
            return false;
        }

        private function login()
        {
            if( isset($_SESSION['user']['username']) && isset($_SESSION['user']['password']) )
            {
                if( $this->AD->loginUser($_SESSION['user']['username'],$_SESSION['user']['password']) )
                {
                    return true;
                }

                $this->logout();
                return false;
                
            }
            return false;
        }

        public function logout()
        {
            unset($_SESSION['user']);
            $this->AD->logoutUser();
        }

        public function setToken($username,$t)
        {
            $_SESSION['token'][$username] = $t;

            return true;
        }

        public function getToken($username)
        {
            if(isset($_SESSION['token'][$username] ))
                return $_SESSION['token'][$username];
            else return "";
        }
    }
?>