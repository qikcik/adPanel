<?php
    require_once __DIR__ . '/../vendor/autoload.php';

    class ActiveDirectory
    {
        protected $baseConfig = [  
            'hosts'    => ['192.168.0.100'],
            'base_dn'  => 'dc=zs1,dc=bochnia',
            'username' => "admin.ADPanel",
            'password' => "superSecret",
    
            'port'     => 636,
            'use_ssl'  => true,
            'schema'   => Adldap\Schemas\ActiveDirectory::class,
        ];

        protected $ad;

        private $connect = true;
        private $userConnect = false;
        public function isConnect() { return $this->connect; }
        public function isUserConnect() { return $this->userConnect; }

        public $usernameDC = null;
        public $userAsAdmin = null;
        public $userAsUser = null;
        public function getUserAsAdmin()
        {
            if( !$this->userAsAdmin )
            {
                if( !$this->usernameDC ) return null;
                if ( !$this->connect ) return null;
                $this->userAsAdmin = $this->ad->getProvider('admin')->search()->find($this->usernameDC);
            }
            return $this->userAsAdmin;
        } 
        public function getUserAsUser()
        {
            if( !$this->userAsUser ) 
            {
                if( !$this->usernameDC ) return null;
                if ( !$this->userConnect ) return null;
                $this->userAsUser = $this->ad->getProvider('user')->search()->find($this->usernameDC);
            }
            return $this->userAsAdmin;
        } 

        public function __construct() 
        {
            $this->ad = new \Adldap\Adldap();
            try
            {
                $this->ad->addProvider($this->baseConfig,'admin');
                $this->ad->connect('admin');
            }
            catch(Exception $e)
            {
                $this->connect = false;
            }
        }

        public function asAdmin()
        {
            if($this->connect) return $this->ad->getProvider('admin');
            return null;
        }

        //return bool 
        public function loginUser($username,$password)
        {
            if( !$this->connect ) return false;
            if( $this->userConnect ) return false;

            try
            {
                $this->usernameDC = $username;
                $user = $this->getUserAsAdmin();
                if( !$user ) return false;

                $config = $this->baseConfig;
                $config['username'] = strval($user);
                $config['password'] = $password;

                $this->ad->addProvider($config,'user');
                if( !$this->ad->connect('user') )
                    return false;
            }
            catch(Exception $e)
            {
                return false;
            }

            $this->userConnect = true;
            return true;
        }

        public function logoutUser()
        {
            if( !$this->userConnect ) return false;

            $this->ad->removeProvider('user');
            $this->userConnect = false;
            return true;

        }

        public function asUser()
        {
            if($this->userConnect) return $this->ad->getProvider('user');
            return null;
        }
    }
?>
