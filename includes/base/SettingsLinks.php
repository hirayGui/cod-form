<?php 

/**
 * @package CDOForm
 */

 namespace Inc\base;

 use \Inc\base\BaseController;

 class SettingsLinks extends BaseController{

    public function register(){
        add_filter("plugin_action_links_$this->plugin", array($this, 'settings_link'));
    }


    /**
     * Função adiciona links de ações ao plugin na tela de plugins
     * @param array com links do wordpress
     * @return array atualizado com novos links
     */
    public function settings_link($links){
        $settings_link = '<a href="admin.php?page=cdo-form">Configurações</a>';
        array_push($links, $settings_link);
        return $links;
    }
 }