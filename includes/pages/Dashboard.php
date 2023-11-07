<?php 

/**
 * @package CorisCDOPlugin
 */

 namespace Inc\pages;

 use \Inc\api\SettingsApi;
 use \Inc\base\BaseController;
 use \Inc\api\callbacks\AdminCallbacks;
 use \Inc\api\callbacks\ManagerCallbacks;

 class Dashboard extends BaseController{

    public $settings;

    public $callbacks;
    public $callbacks_mngr;

    public $pages = array();
    public $subpages = array();

    /**
     * Declarando qual função irá ser responsável pela página de configurações
     */

    public function register(){
        //add_action('admin_menu', array($this, 'add_admin_pages'));
        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();
        $this->callbacks_mngr = new ManagerCallbacks();

        $this->setPages();
        $this->setSubPages();

        $this->setSettings();
        $this->setSections();
        $this->setFields();

        $this->settings->addPages($this->pages)->withSubPage('Dashboard')->addSubPages($this->subpages)->register();
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

    public function setSubpages(){
        $this->subpages = array(
            array(
                'parent_slug' => 'coris-cdo-plugin',
                'page_title' => 'Widgets',
                'menu_title' => 'Widgets',
                'capability' => 'manage_options',
                'menu_slug' => 'coris-cdo-widget',
                'callback' => array($this->callbacks, 'adminWidget'),
            )
        );

    }

    public function setSettings(){
        $args = array(
            array(
                'option_group' => 'coris_cdo_plugin_settings',
                'option_name' => 'coris_user',
                'callback' => array($this->callbacks, 'corisCdoOptionsGroup')
            ),
            array(
                'option_group' => 'coris_cdo_plugin_settings',
                'option_name' => 'coris_password',
                'callback' => array($this->callbacks, 'corisCdoOptionsGroup')
            )
        );

        foreach($this->managers as $key => $value){
            $args[] = array(
                'option_group' => 'coris_cdo_plugin_settings',
                'option_name' => $key,
                'callback' => array($this->callbacks_mngr, 'cehckboxSanitize')
            ); 
        }

        $this->settings->setSettings($args);
    }

    public function setSections(){
        $args = array(
            array(
                'id' => 'coris_cdo_admin_index',
                'title' => 'Configurações do Plugin',
                'callback' => array($this->callbacks_mngr, 'adminSectionManager'),
                'page' => 'coris-cdo-plugin'
            )
        );

        $this->settings->setSections($args);
    }

    public function setFields(){
        $args = array(
            array(
                'id' => 'coris_user',
                'title' => 'Usuário Coris',
                'callback' => array($this->callbacks, 'corisCdoUser'),
                'page' => 'coris-cdo-plugin',
                'section' => 'coris_cdo_admin_index',
                'args' => array(
                    'label_for' => 'coris_user',
                    'class' => 'login-class'
                )
            ),
            array(
                'id' => 'coris_password',
                'title' => 'Senha',
                'callback' => array($this->callbacks, 'corisCdoPassword'),
                'page' => 'coris-cdo-plugin',
                'section' => 'coris_cdo_admin_index',
                'args' => array(
                    'label_for' => 'coris_password',
                    'class' => 'login-class'
                )
            )
        );

        foreach($this->managers as $key => $value){
            $args[] = array(
                'id' => $key,
                'title' => $value,
                'callback' => array($this->callbacks_mngr, 'checkboxField'),
                'page' => 'coris-cdo-plugin',
                'section' => 'coris_cdo_admin_index',
                'args' => array(
                    'label_for' => $key,
                    'class' => 'ui-toggle'
                )
            ); 
        }

        $this->settings->setFields($args);
    }

 }