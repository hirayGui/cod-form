<?php 

/**
 * @package CDOForm
 */

 namespace Inc\base;

 use Inc\base\BaseController; 

 use Inc\api\widgets\FormWidget;

 class WidgetController extends BaseController{
    
    public function register(){
        $form_widget = new FormWidget();
        $form_widget->register();
    }
 }
