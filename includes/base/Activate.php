<?php 

/**
 * @package CDOForm
 */

 namespace Inc\base;

 class Activate{
    public static function activate(){
        flush_rewrite_rules();
    }
 }