<?php 

/**
 * @package CDOForm
 */

 namespace Inc\api\widgets;

use DOMDocument;
use WP_Widget;


 class FormWidget extends WP_Widget{

    public $widget_ID;

    public $widget_name;

    public $widget_options = array();

    public $control_options = array();

    public function __construct(){
        $this->widget_ID = 'cdo_widget';
        $this->widget_name = ' CDO Widget';
        $this->widget_options = array(
            'classname' => $this->widget_ID,
            'description' => $this->widget_name,
            'customize_selective_refresh' => true,
        );

        $this->control_options = array(
            'width' => 400,
            'height' => 350,
        );
    }

    public function register(){
        parent::__construct($this->widget_ID, $this->widget_name, $this->widget_options, $this->control_options);

        add_action('widgets_init', array($this, 'widgetsInit'));
    }

    public function widgetsInit(){
        register_widget($this);
    }

    //form, widget e update: métodos obrigatórios para a criação de um novo widget
    public function widget($args, $instance){
        echo $args['before_widget'];

        if(!empty($instance['title'])){
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        //form principal
        ?>
        <div class="main-coris">
            <form action="" method="post" class="form-coris">
                <h3>Faça a cotação do seu Seguro Viagem</h3>

                <div>
                    <label for="categoria">Categoria</label>
                    <select name="categoria" id="categoria">
                        <option value="1">Lazer/Negócios</option>
                        <option value="2">Intercâmbio</option>
                        <option value="4">Cruzeiro</option>
                    </select>
                
                    <label for="destino">Destino</label>
                    <select name="destino" id="destino">
                        <option value="1">América Latina(Exceto BRL)</option>
                        <option value="2">Brasil</option>
                        <option value="4">Mundo (Exceto EUA)</option>
                        <option value="5">Mundo (Incluindo EUA)</option>
                    </select>
               
                    <label for="vigencia">Tempo de estadia em dias</label>
                    <input type="number" name="vigencia" id="vigencia" min="1" value="1">
                </div>

                <h4>Nº de passageiros</h4>

                <div>
                    <label for="pax065">Até 65 anos</label>
                    <input type="number" name="pax065" id="pax065" min="0" max="6" value="0">
              
                    <label for="pax7685">De 66 a 70 anos</label>
                    <input type="number" name="pax7685" id="pax7685" min="0" max="6" value="0">
              
                    <label for="pax86100">De 71 a 80 anos</label>
                    <input type="number" name="pax86100" id="pax86100" min="0" max="6" value="0">
                
                    <label for="p2">De 81 a 85</label>
                    <input type="number" name="p2" id="p2" min="0" max="6" value="0">
                </div>

                <div class="full-width">
                    <input type="submit" value="Enviar" name="enviar">
                </div>

            </form>
        </div>
        <?php

        //fazendo requisição após enviar dados via formulário
        if(isset($_POST['enviar'])){

                
            
        }

        echo $args['after_widget'];
    }

    public function form($instance){
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Custom Text', 'cdo-form');
        ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php echo esc_attr_e('Title', 'cdo-form')?></label>
            <input type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" class="widefat" value="<?php echo esc_attr($title);?>">
        </p>

        <?php
    }

    public function update($new_instance, $old_instance){
        $instance = $old_instance;
        $instance['title'] = sanitize_text_filed($new_instance['title']);

        return $instance;
    }

    
 }
