<?php 

/**
 * @package CorisCDOPlugin
 */

 namespace Inc\base;

 class Deactivate{
    public static function deactivate(){
        flush_rewrite_rules();
    }
 }