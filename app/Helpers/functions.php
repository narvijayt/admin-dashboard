<?php
/**
 * Define Custom Functions
 * 
 */

if(!function_exists('se_languages')){
    function se_languages(){
        return [
            'ja'    =>  'Japanese',
            'es'    =>  'Spanish',
        ];
    }
}

/**
 * Get current controller name
 */
if (!function_exists('getControllerName')) {
    function getControllerName() {
        $controller_path = Route::getCurrentRoute()->getActionName();
        list($controller, $action) = explode('@', $controller_path);
        return preg_replace('/.*\\\/', '', $controller);
    }
}

/**
 * Get users accountTypes
 */
if (!function_exists('getUsersAccountTypes')) {
    function getUsersAccountTypes() {
        return ['ADMIN','TRANSLATORS'];
    }
}

/**
 * Get current controller name
 */
if (!function_exists('pr')) {
    function pr($array = []) {
        echo '<pre>'; print_r($array); echo '</pre>';
    }
}