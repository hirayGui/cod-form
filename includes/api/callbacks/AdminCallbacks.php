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
 }
