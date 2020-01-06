<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

require_once(APPPATH.'third_party/Mail/PHPMailerAutoload.php');

class Mail extends PHPMailer{

    public function __construct(){
        //log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load(){
        $objMail = new PHPMailer;
        return $objMail;
    }

    public function get_body( $email_params, $template_file )
	{
		$template_loader = new FilesystemLoader( VIEWPATH . 'email-templates/' );
        $twig = new Environment( $template_loader );
        $CI =& get_instance();

		$default_params = [
			'title'        => Sitesettings::get('site_name'),
			'site_url'     => base_url(),
			'logo_url'     => base_url('assets/images/logo.png')
		];		

		$params = array_merge( $default_params, $email_params );
		
		return $twig->render( $template_file, $params );
    }
    

	public function sent_mail($to, $subject, $message)
	{
        $CI =& get_instance();
		$site_name = Sitesettings::get('site_name');

        $CI->email->from(Sitesettings::get('site_sender_email'), $site_name);
        $CI->email->to($to);

        $CI->email->subject($subject);
        $CI->email->message($message);

        $CI->email->send();
	}

}
?>