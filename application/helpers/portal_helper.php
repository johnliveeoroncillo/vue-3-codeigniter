<?php defined('BASEPATH') OR exit('No direct script access allowed');

function loadChangeLogs(){
    $changelogs = array();
    return $changelogs;
}

function checkAuth() {
	$ci =& get_instance();
    if(empty($ci->session->userdata('vue-ci-session'))) {
        return false;
    }
	else {
        return true;
	}
}

function encrypt($string){
	$ci =& get_instance();
	$encrypted = $ci->encryption->encrypt($string);
	$encrypted = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted);
	return $encrypted;
}

function decrypt($string){
	$ci =& get_instance();
	$decrypted = str_replace(array('-', '_', '~'), array('+', '/', '='), $string);
	$decrypted = $ci->encryption->decrypt($decrypted);
	return $decrypted;
}

//ISNULL HELPER BY JL BASED ON POWERBUILDER EXISTING FUNCTION
function isNull($string, $based = ''){
    if(is_int($based) == true){
        $based = strval($based);
    }
    
    if((empty($string)) || ($string == null || $string == 'undefined')) {
        return $based;
    }
    else{
        $based = null;
        return $string;
    }
}
