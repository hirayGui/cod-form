<?php

/**
 * Plugin Name: Coris CDO Plugin
 * Plugin URI:  https://github.com/hirayGui/coris-cdo-plugin
 * Author: Gizo Digital
 * Author URI: 
 * Description: Este plugin permite que o site possa apresentar planos de viagens do webservice do Coris
 * Version: 0.1.0
 * License:     GPL-2.0+
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: coris-cdo-plugin
 *
 * @package CorisCDOPlugin
 */

if(!defined('ABSPATH')) {
    die;
}


/**
 * Faz a importação do Composer Autoload uma única vez
 */
if(file_exists(dirname(__FILE__) . '/vendor/autoload.php')){
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

/**
 * Função é chamada quando plugin é ativado
 */
function activate_coris_cdo_plugin(){
    Inc\base\Activate::activate();
}

register_activation_hook(__FILE__, 'activate_coris_cdo_plugin');

/**
 * Função é chamada quando plugin é desativado
 */
function deactivate_coris_cdo_plugin(){
    Inc\base\Deactivate::deactivate();
}

register_deactivation_hook(__FILE__, 'deactivate_coris_cdo_plugin');


if(class_exists('Inc\\Init')){
    Inc\Init::register_services();
}