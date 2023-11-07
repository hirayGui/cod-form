<?php 

/**
 * @package CorisCDOPlugin
 */

 namespace Inc\api\callbacks;
 
 use Inc\base\BaseController;

 class AdminCallbacks extends BaseController{
    public function adminDashboard(){
        return require_once("$this->plugin_path/templates/admin.php");
    }

    public function adminWidget(){
        return require_once("$this->plugin_path/templates/widget.php");
    }

    public function corisCdoOptionsGroup($input){
        return $input;
    }

    // public function corisCdoAdminSection(){
    //     echo 'Configurações de Login Coris';
    // }

    public function corisCdoUser(){
        $value =  esc_attr(get_option('coris_user'));  
        echo '<input type="text" class="regular-text" name="coris_user" value="'. $value .'" placeholder="Insira seu usuário Coris"/>';
    }

    public function corisCdoPassword(){
        $value =  esc_attr(get_option('coris_password'));  
        echo '<input type="password" class="regular-text" name="coris_password" value="'. $value .'" placeholder="Insira sua senha Coris"/>';
    }
    
 }
