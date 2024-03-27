<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <h2 class="description"></h2>
    <form action="options.php" method="post">
        <?php
        settings_fields( 't3-schema-settings' );
        do_settings_sections( 't3-schema-settings' );
        submit_button( 'Save Settings' );
        ?>
    </form>
</div>
