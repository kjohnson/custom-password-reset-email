<?php if ( ! defined( 'ABSPATH' ) ) exit;

class register_admin_menu
{
    /**
     * register_admin_menu constructor.
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'cpr_admin_menu' ) );
    }

    public function cpr_admin_menu()
    {
        // The plain text should be translatable.
        add_options_page(
            'Password Reset Email',
            'Password Reset Email',
            'manage_options',
            'custom-password-reset-email',
            array( $this, 'cpr_admin_callback' )
        );
    }

    public function cpr_admin_callback()
    {
        /*
        I would suggest that you go ahead and build the URL here,
        instead of passing a chunk of the final URL.
        */
        $cpr_site_url = get_site_url();

        /*
        Also, you should move function calls (ie get_option)
        inside of the class, then pass variables to the template.
        */
        include( Custom_Password_Reset_Email::$dir . 'includes/cpr-admin-template.html.php' );
    }
}

( new register_admin_menu );

