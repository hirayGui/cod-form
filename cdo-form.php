<?php

/**
 * Plugin Name: CDO form
 * Plugin URI:  https://github.com/hirayGui/cdo-form
 * Author: Gizo Digital
 * Author URI: 
 * Description: Este plugin permite que produtos possam ser consultados através de um form
 * Version: 0.1.0
 * License:     GPL-2.0+
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: cdo-form
 *
 * @package CDOForm
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
function activate_cdo_form(){
    Inc\base\Activate::activate();
}

register_activation_hook(__FILE__, 'activate_cdo_form');

/**
 * Função é chamada quando plugin é desativado
 */
function deactivate_cdo_form(){
    Inc\base\Deactivate::deactivate();
}

register_deactivation_hook(__FILE__, 'deactivate_cdo_form');


if(class_exists('Inc\\Init')){
    Inc\Init::register_services();
}