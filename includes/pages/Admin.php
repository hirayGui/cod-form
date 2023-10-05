<?php 

/**
 * @package CorisCDOPlugin
 */

 namespace Inc\pages;

 use \Inc\api\SettingsApi;
 use \Inc\base\BaseController;
 use \Inc\api\callbacks\AdminCallbacks;

 class Admin extends BaseController{

    public $settings;

    public $callbacks;

    public $pages = array();

    /**
     * Declarando qual função irá ser responsável pela página de configurações
     */

    public function register(){
        //add_action('admin_menu', array($this, 'add_admin_pages'));
        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->setPages();

        $this->settings->addPages($this->pages)->register();
    }

    public function setPages(){
        $this->pages = array(
            array(
                'page_title' => 'Coris CDO Plugin',
                'menu_title' => 'Coris CDO',
                'capability' => 'manage_options',
                'menu_slug' => 'coris-cdo-plugin',
                'callback' => array($this->callbacks, 'adminDashboard'),
                'icon_url' => 'dashicons-store',
                'position' => 110
            )
        );
    }
 }