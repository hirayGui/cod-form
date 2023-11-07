<?php 

/**
 * @package CorisCDOPlugin
 */

 namespace Inc\base;

 use Inc\base\BaseController; 

 use Inc\api\widgets\CorisWidget;

 class WidgetController extends BaseController{
    
    public function register(){
        $coris_widget = new CorisWidget();
        $coris_widget->register();
    }
 }
