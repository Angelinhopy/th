<?php
    class User {
        protected static $user;
        
        public static function login($username, $password){
            if(!empty($username) || !empty($password)){
                if($verif_login = tabUsuario::where('nombreusuario', '=', $username)->first()){
                    if(Hash::check($password, $verif_login->contrasena1) ){
                        self::$user = $verif_login;
                        return true;
                    }
                }
            }
            return false;
        }

        public static function genToken(){
            $permiso = viewPermiso::where('idperfil', '=', self::$user->idperfil)->get();
            $username = viewUsuario::get(self::$user->idusuario);
            $token = Auth::SignIn($username);
            $access_token = array('user' => $username, 'token' => $token, 'permiso' => $permiso);
            return $access_token;
        }

        public static function getUser(){
            return self::$user;
        }


    }
?>
