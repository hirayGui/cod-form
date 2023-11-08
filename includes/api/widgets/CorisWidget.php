<?php 

/**
 * @package CorisCDOPlugin
 */

 namespace Inc\api\widgets;

use DOMDocument;
use WP_Widget;


 class CorisWidget extends WP_Widget{

    public $url = "http://ws.coris-homolog.com.br/webservice2/service.asmx";
    public $widget_ID;

    public $widget_name;

    public $widget_options = array();

    public $control_options = array();

    public function __construct(){
        $this->widget_ID = 'coris_cdo_widget';
        $this->widget_name = 'Coris CDO Widget';
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
            if($_POST['pax065'] != 0 || $_POST['pax7685'] != 0 || $_POST['pax86100'] != 0 || $_POST['p2'] != 0){
                $categoria = $_POST['categoria'];
                $destino = $_POST['destino'];
                $vigencia = $_POST['vigencia'];
                $pax065 = $_POST['pax065'];
                $pax7685 = $_POST['pax7685'];
                $pax86100 = $_POST['pax86100'];
                $p2 = $_POST['p2'];
                $user = get_option('coris_user');
                $password = get_option('coris_password');

                //array $planos recebe planos disponíveis
                $planos = $this->buscarPlanos($user, $password, $destino, $vigencia);
                $planos = $this->buscarPreco($planos, $user, $password, $destino, $categoria, $pax065, $pax7685, $pax86100, $p2);

                ?>

                <div class="linha-result">
                    <?php
                    foreach($planos as $plano){?>
                        <div class="base-coris">
                            <div class="card">
                                <div class="nome"><h4><?php echo $plano['nome'];?></h4></div>
                                <div class="preco"><h3>R$ <?php echo number_format((float) str_replace(['.', ','], ['', '.'], $plano['precoindividual']), 2);?></h3></div>
                                <?php if($plano['Valorbagagens'] > 0){?>
                                <div class="bagagem"><p>Compensação por atraso de bagagem</p></div>
                                <?php }?>
                                <?php if($plano['ValorcancAny'] > 0){?>
                                <div class="cancelamento"><p>Cancelamento ou interrupção de viagem</p></div>
                                <?php }?>
                                <?php if($plano['ValorDanosMala'] > 0){?>
                                <div class="danos"><p>Danos à mala</p></div>
                                <?php }?>
                                <?php if($plano['ValorAssistPet'] > 0){?>
                                <div class="pet"><p>Despesas com pet</p></div>
                                <?php }?>

                                <div class="link"><a href="#" id="<?php echo $plano['id'];?>">Adquirir</a></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <?php
                // foreach($planos as $plano){
                //     print_r($plano['id']);
                //     echo '<br>';
                // }
            }
        }

        echo $args['after_widget'];
    }


    //função que retorna preços de acordo com o plano
    public function buscarPreco($planos, $user, $password, $destino, $categoria, $pax065, $pax7685, $pax86100, $p2){
        
        for($i = 0; $i <= count($planos); $i++){
            $xml_req = 
                '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
                <soapenv:Header/>
                <soapenv:Body>
                <tem:BuscarPrecosIndividualV13>
                <tem:strXML>
                <![CDATA[
                <execute>  
                <param name="login" type="varchar" value="'.$user.'" />   
                <param name="senha" type="varchar" value="'.$password.'" />   
                <param name="idplano" type="int" value="'.$planos[$i]['id'].'" />   
                <param name="dias" type="int" value="0" />  
                <param name="pax065" type="int" value="'.$pax065.'" />   
                <param name="pax6675" type="int" value="0" />  
                <param name="pax7685" type="int" value="'.$pax7685.'" />  
                <param name="pax86100" type="int" value="'.$pax86100.'" />  
                <param name="angola" type="char" value="N" />  
                <param name="furtoelet" type="int" value="0" />  
                <param name="bagagens" type="int" value="0" />  
                <param name="morteac" type="int" value="0" />  
                <param name="mortenat" type="int" value="0" />  
                <param name="cancplus" type="int" value="0" />  
                <param name="cancany" type="int" value="0" />  
                <param name="formapagamento" type="varchar" value="FA" />  
                <param name="destino" type="int" value="'.$destino.'" />  
                <param name="categoria" type="int" value="'.$categoria.'" />  
                <param name="codigodesconto" type="varchar" value="0" />  
                <param name="danosmala" type="int" value="0" />  
                <param name="pet" type="int" value="0" />  
                <param name="p1" type="varchar" value="0" />  
                <param name="p2" type="varchar" value="'.$p2.'" />  
                <param name="p3" type="varchar" value="0" />  
                </execute>
                ]]>
                </tem:strXML>
                </tem:BuscarPrecosIndividualV13>
                </soapenv:Body>
                </soapenv:Envelope>';

            $response = wp_remote_post(
                $this->url,
                [
                    'headers' => [
                        'Content-Type' => 'text/xml;charset=utf-8'
                    ],
                    'body' => $xml_req
                ]
            );

            if(!is_wp_error($response)){
                $html = html_entity_decode($response['body']);

                $doc = new DOMDocument();
                $doc->loadHTML($html);

                $trList = $doc->getElementsByTagName("row");
                $rows = [];
                foreach ( $trList as $tr )  {
                    foreach ( $tr->getElementsByTagName("column") as $td )  {
                        $planos[$i][$td->getAttribute('name')] = trim($td->textContent);
                    }//foreach ( $tr->getElementsByTagName("column") as $td ) 

                }//foreach ( $trList as $tr )  
                
            }//if(!is_wp_error($response))

        }//foreach($planos as $plano)
        return $planos;
    }

    //função que retorna planos disponíveis dentro do seguro de viagem
    public function buscarPlanos($user, $password, $destino, $vigencia){
        $xml_req = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
                <soapenv:Header/>
                <soapenv:Body>
                <tem:BuscarPlanosNovosV13>
                <tem:strXML>
                <![CDATA[
                <execute>  
                <param name="login" type="varchar" value="'.$user.'" />   
                <param name="senha" type="varchar" value="'.$password.'" />   
                <param name="destino" type="int" value="'.$destino.'" />   
                <param name="vigencia" type="int" value="'.$vigencia.'" />  
                <param name="home" type="int" value="0" />   
                <param name="multi" type="int" value="0" />  
                </execute>
                ]]>
                </tem:strXML>
                </tem:BuscarPlanosNovosV13>
                </soapenv:Body>
                </soapenv:Envelope>';

                $response = wp_remote_post(
                    $this->url,
                    [
                        'headers' => [
                            'Content-Type' => 'text/xml;charset=utf-8'
                        ],
                        'body' => $xml_req
                    ]
                );

                if(!is_wp_error($response)){
                    $html = html_entity_decode($response['body']);

                    $doc = new DOMDocument();
                    $doc->loadHTML($html);

                    $trList = $doc->getElementsByTagName("row");
                    $rows = [];
                    foreach ( $trList as $tr )  {
                        $row = array();
                        foreach ( $tr->getElementsByTagName("column") as $td )  {
                            $row[$td->getAttribute('name')] = trim($td->textContent);
                        }
                        $rows[] = $row;
                    }

                    return $rows;
                }
    }

    public function form($instance){
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Custom Text', 'coris-cdo-plugin');
        ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php echo esc_attr_e('Title', 'coris-cdo-plugin')?></label>
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
