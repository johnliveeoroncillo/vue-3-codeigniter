<?php 
    require APPPATH . '/libraries/JWT.php';

    class CreatorJwt
    {

        var $CI;
        private $key;
        public function __construct() {
            $this->CI =& get_instance();
            $this->key = $this->CI->config->item('encryption_key');
        }
       

        /*************This function generate token private key**************/ 
        public function GenerateToken($data)  {          
            $jwt = JWT::encode($data, $this->key);
            return $jwt;
        }
        

       /*************This function DecodeToken token **************/

        public function DecodeToken($token) {          
            $decoded = JWT::decode($token, $this->key, array('HS256'));
            $decodedData = (array) $decoded;
            return $decodedData;
        }
    }
;?>