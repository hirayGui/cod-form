<?php 

/**
 * @package CDOForm
 */

 namespace Inc\base;

 use \Inc\base\BaseController;

 class Enqueue extends BaseController{
    public function register(){
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    }

    function enqueue(){
        wp_enqueue_style('style', $this->plugin_url . '/assets/style.css');
        wp_enqueue_script('script', $this->plugin_url . '/assets/script.js');
    }
 }