<?php if ( ! defined( 'ABSPATH' ) ) exit;

class cpr_add_options
{
    /**
     * @var
     */
    public $site_url;

    /**
     * cpr_add_options constructor.
     */
    public function __construct()
    {

        if (isset($_POST[ 'cpr-submit' ] ) ) {

            $this->cpr_update_options( $_POST );
        }

        /*
        The hyperlinked button shouldn't need to update settings.
        It probably won't process anyway, being inside of the hyperlink.
        */
        if (isset($_POST[ 'cpr-goto-pwreset' ] ) ) {

            $this->cpr_update_options( $_POST );

        }

        add_filter('wp_mail_from_name', array($this, 'cpr_update_mail_from_name') );

        add_filter('wp_mail_from', array($this, 'cpr_update_mail_from') );

        add_filter('retrieve_password_title', array($this, 'cpr_update_password_title') );

        add_filter('retrieve_password_message', array($this, 'cpr_update_password_reset_message'), 10, 4);

    }

    public function cpr_update_options( $post )
    {
        if( !empty( $post[ 'cpr-from-name' ] ) ) {
            update_option( 'cpr_from_name_option', $post[ 'cpr-from-name' ] );
        }

        if( !empty( $post['cpr-from-email'])) {
            update_option( 'cpr_from_email_option', $post[ 'cpr-from-email' ] );
        }

        if( !empty( $post[ 'cpr-subject' ] ) ) {
            update_option( 'cpr_subject_option', $post[ 'cpr-subject' ] );
        }

        if( !empty( $post[ 'cpr-message' ] ) ) {
            update_option( 'cpr_message_option', $post[ 'cpr-message' ] );
        }
    }

    public function cpr_update_mail_from_name()
    {
        return get_option( 'cpr_from_name_option' );
    }

    public function cpr_update_mail_from()
    {
        return get_option( 'cpr_from_email_option' );
    }

    public function cpr_update_password_title()
    {
        return get_option( 'cpr_subject_option' );
    }

    public function cpr_update_password_reset_message( $message, $key, $user_login )
    {
        $this->site_url = get_site_url();

        $message = get_option( 'cpr_message_option' );

        $cpr_key = $this->site_url . '/wp-login.php?action=rp&key=' . $key . '&login=' . $user_login;

        $cpr_str_replace = str_replace( '{password_key}' , $cpr_key, $message );

        return $cpr_str_replace;
    }
}

( new cpr_add_options );
