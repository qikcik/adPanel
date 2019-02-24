<?php

    class Usefull
    {
        public static function checkIsEmail($mail)
        {
            $find1 = strpos($mail, '@');
            $find2 = strpos($mail, '.');
            return ($find1 !== false && $find2 !== false && $find2 > $find1 ? true : false);
        }

        public static function checkPassword($pass)
        {
            if(strlen($pass) < 8)
                return false;
            return true;
        }

        public static function refresh()
        {
            header("Location: ?");
        }

        public static function myAdress()
        {
            return "192.168.55.103";
        }
    }

?>