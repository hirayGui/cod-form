<?php 

/**
 * @package CDOForm
 */

 namespace Inc\base;

 class BaseController{
    
    public $plugin_path;
    public $plugin_url;
    public $plugin;

    public $managers = array();

    public function __construct(){
        $this->plugin_path = plugin_dir_path(dirname(__FILE__, 2));
        $this->plugin_url = plugin_dir_url(dirname(__FILE__, 2));
        $this->plugin = plugin_basename(dirname(__FILE__, 3)) . '/cdo-form.php';

        $this->managers = array(
            'widget_manager' => 'Ativar Widget'
        );
    }
 }
