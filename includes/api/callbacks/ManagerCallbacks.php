<?php 

/**
 * @package CDOForm
 */

 namespace Inc\api\callbacks;
 
 use Inc\base\BaseController;

 class ManagerCallbacks extends BaseController{
    public function checkboxSanitize($input){
        // return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
        return (isset($input) ? true : false);
    }

    public function adminSectionManager(){
        echo "Gerencie as configurações principais do plugin";
    }

    public function checkboxField($args){
        $name = $args['label_for'];
        $classes = $args['class'];
        $checkbox = get_option($name);
        echo '<div class="'.$classes.'"><input type="checkbox"id="'.$name.'" name="'.$name.'" value="1" class="'.$classes.'" '.($checkbox ? 'checked' : '').'><label for="'.$name.'"><div></div></label></div>';
    }
 }
