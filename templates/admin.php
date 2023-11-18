<div class="wrap">
    <h1>CDO Plugin</h1>
    <?php settings_errors();?>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-1">Gerenciar Configurações</a></li>
        <li><a href="#tab-2">Sobre</a></li>
    </ul>

    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <form method="post" action="options.php">
                <?php 
                    settings_fields('cdo_form_settings');
                    do_settings_sections('cdo-form');
                    submit_button();
                ?>
            </form>
        </div>

        <div id="tab-2" class="tab-pane">
            <h3>Sobre</h3>
        </div>
    </div>

    
</div>

