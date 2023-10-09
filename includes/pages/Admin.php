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

        $this->setSettings();
        $this->setSections();
        $this->setFields();

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

    public function setSettings(){
        $args = array(
            array(
                'option_group' => 'coris_cdo_options_group',
                'option_name' => 'coris_user',
                'callback' => array($this->callbacks, 'corisCdoOptionsGroup')
            ),
            array(
                'option_group' => 'coris_cdo_options_group',
                'option_name' => 'coris_password'
            )
        );

        $this->settings->setSettings($args);
    }

    public function setSections(){
        $args = array(
            array(
                'id' => 'coris_cdo_admin_index',
                'title' => 'Configurações do Plugin',
                'callback' => array($this->callbacks, 'corisCdoAdminSection'),
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

        $this->settings->setFields($args);
    }

 }