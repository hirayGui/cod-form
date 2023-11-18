<?php 

/**
 * @package CDOForm
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
                'page_title' => 'CDO Form',
                'menu_title' => 'CDO Form',
                'capability' => 'manage_options',
                'menu_slug' => 'cdo-form',
                'callback' => array($this->callbacks, 'adminDashboard'),
                'icon_url' => 'dashicons-store',
                'position' => 110
            )
        );
    }

    public function setSubpages(){
        $this->subpages = array(
            array(
                'parent_slug' => 'cdo-form',
                'page_title' => 'Widgets',
                'menu_title' => 'Widgets',
                'capability' => 'manage_options',
                'menu_slug' => 'cdo_form_widget',
                'callback' => array($this->callbacks, 'adminWidget'),
            )
        );

    }

    public function setSettings(){
        $args = array(
            array(
                'option_group' => 'cdo_form_settings',
                'option_name' => 'cdo_user',
                'callback' => array($this->callbacks, 'CdoOptionsGroup')
            ),
            array(
                'option_group' => 'cdo_form_settings',
                'option_name' => 'cdo_password',
                'callback' => array($this->callbacks, 'CdoOptionsGroup')
            )
        );

        foreach($this->managers as $key => $value){
            $args[] = array(
                'option_group' => 'cdo_form_settings',
                'option_name' => $key,
                'callback' => array($this->callbacks_mngr, 'checkboxSanitize')
            ); 
        }

        $this->settings->setSettings($args);
    }

    public function setSections(){
        $args = array(
            array(
                'id' => 'cdo_admin_index',
                'title' => 'Configurações do Plugin',
                'callback' => array($this->callbacks_mngr, 'adminSectionManager'),
                'page' => 'cdo-form'
            )
        );

        $this->settings->setSections($args);
    }

    public function setFields(){
        $args = array(
            array(
                'id' => 'cdo_user',
                'title' => 'Usuário cdo',
                'callback' => array($this->callbacks, 'cdoUser'),
                'page' => 'cdo-form',
                'section' => 'cdo_admin_index',
                'args' => array(
                    'label_for' => 'cdo_user',
                    'class' => 'login-class'
                )
            ),
            array(
                'id' => 'cdo_password',
                'title' => 'Senha',
                'callback' => array($this->callbacks, 'cdoPassword'),
                'page' => 'cdo-form',
                'section' => 'cdo_admin_index',
                'args' => array(
                    'label_for' => 'cdo_password',
                    'class' => 'login-class'
                )
            )
        );

        foreach($this->managers as $key => $value){
            $args[] = array(
                'id' => $key,
                'title' => $value,
                'callback' => array($this->callbacks_mngr, 'checkboxField'),
                'page' => 'cdo-form',
                'section' => 'cdo_admin_index',
                'args' => array(
                    'label_for' => $key,
                    'class' => 'ui-toggle'
                )
            ); 
        }

        $this->settings->setFields($args);
    }

 }