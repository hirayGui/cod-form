<?php 

/**
 * @package CorisCDOPlugin
 */

 namespace Inc;

 final class Init{

    /**
     * Armazena todas as classes dentro de um array
     * @return array com lista de classes
     */
    public static function get_services(){
        return [
            pages\Dashboard::class,
            base\Enqueue::class,
            base\SettingsLinks::class,
            base\WidgetController::class,
        ];
    }

    /**
     * Função vasculha lista de classes, ativa seus construtores e chama resgister() caso exista
     * @return void
     */
    public static function register_services(){
        foreach(self::get_services() as $class){
            $service = self::instantiate($class);
            if(method_exists($service, 'register')){
                $service->register();
            }
        }
    }

    /**
     * Instancia as classes
     * @param class $class classe do array de serviços
     * @return class instance nova instância da classe recebida
     */
    private static function instantiate($class){
        return new $class();
    }
 }