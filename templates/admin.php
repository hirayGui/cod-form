<div class="wrap">
    <h1>Coris CDO Plugin</h1>
    <?php settings_errors();?>

    <form method="post" action="options.php">
        <?php 
            settings_fields('coris_cdo_options_group');
            do_settings_sections('coris-cdo-plugin');
            submit_button();
         ?>
    </form>
</div>

