<?php 

/**
 * @package CDOForm
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

    public function cdoOptionsGroup($input){
        return $input;
    }

    // public function cdoCdoAdminSection(){
    //     echo 'Configurações de Login cdo';
    // }

    public function cdoUser(){
        $value =  esc_attr(get_option('cdo_user'));  
        echo '<input type="text" class="regular-text" name="cdo_user" value="'. $value .'" placeholder="Insira seu usuário cdo"/>';
    }

    public function cdoPassword(){
        $value =  esc_attr(get_option('cdo_password'));  
        echo '<input type="password" class="regular-text" name="cdo_password" value="'. $value .'" placeholder="Insira sua senha cdo"/>';
    }
    
 }
