<?php
/**
 * Email Base class
 *
 * This is an abstract class which is designed to implement the IEmail
 * interface and define the send() method which is implemented from the
 * IEmail interface.
 *
 * @abstract
 * @author     Oliver Spryn
 * @copyright  Copyright (c) 2013 and Onwards, ForwardFour Innovations
 * @implements FFI\BE\IEmail
 * @license    MIT
 * @namespace  FFI\BE
 * @package    lib.email
 * @since      3.0.0
*/

namespace FFI\BE;

require_once(dirname(dirname(__FILE__)) . "/exceptions/Mandrill_Send_Failed.php");
require_once(dirname(dirname(__FILE__)) . "/exceptions/Network_Connection_Error.php");
require_once(dirname(dirname(__FILE__)) . "/interfaces/IEmail.php");
require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . "/wp-blog-header.php");

abstract class Email_Base implements IEmail {
/**
 * Hold the address of the person sending the email.
 *
 * @access public
 * @type   string
*/

	public $fromEmail;
	
/**
 * Hold the name of the person sending the email.
 *
 * @access public
 * @type   string
*/
	
	public $fromName;
	
/**
 * Hold the HTML version of the email body.
 *
 * @access protected
 * @type   string
*/
	
	protected $HTMLBody;
	
/**
 * Hold the subject of the email.
 *
 * @access public
 * @type   string
*/
	
	public $subject;
	
/**
 * Hold the plain text version of the email body.
 *
 * @access protected
 * @type   string
*/
	
	protected $textBody;
	
/**
 * Hold the address of the person receiving the email.
 *
 * @access public
 * @type   string
*/
	
	public $toEmail;
	
/**
 * Hold the name of the person receiving the email.
 *
 * @access public
 * @type   string
*/
	
	public $toName;

/**
 * Send the email which was generated by one of the child
 * classes to Mandrill for processing.
 *
 * @access public
 * @return void
 * @since  3.0.0
 * @throws Mandrill_Send_Failed     Thrown when Mandrill cannot send the email
 * @throws Network_Connection_Error [Bubbled up] Thrown when the server cannot communicate with the Mandrill servers
*/

	public function send() {
		global $wpdb;
	
	//Fetch the Mandrill API key
		$key = $wpdb->get_results("SELECT `MandrillKey` FROM `ffi_be_apis`");
	
	//Assemble the API call
		$args = array (
			"key"              => $key[0]->MandrillKey,
			"message"          => array (
				"auto_text"    => false,
				"from_email"   => $this->fromEmail,
				"from_name"    => $this->fromName,
				"html"         => $this->HTMLBody,
				"subject"      => $this->subject,
				"text"         => $this->textBody,
				"to"           => array(array("email" => $this->toEmail, "name" => $this->toName)),
				"track_clicks" => true,
				"track_opens"  => true
			)
		);
		
	//Open a cURL session for making the call
		$request = new Proxy("https://mandrillapp.com/api/1.0/messages/send.json");
		$request->contentType = "application/json";
		$request->POST = true;
		$request->POSTData = json_encode($args);
		$response = json_decode($request->fetch());
                
	//Ensure Mandrill has sent the email
		if (is_array($response) && $response[0]->status != "sent") {
			throw new Mandrill_Send_Failed("Mandrill could not send an email to " . $response[0]->email . ". Status: " . $response[0]->status . " Reason: " . $response[0]->reject_reason);
		}
                
		if (!is_array($response) && $response->status != "sent") {
			throw new Mandrill_Send_Failed("Mandrill could not send an email to " . $this->toEmail . ". Status: " . $response->name . " Reason: " . $response->message);
		}
	}
}
?>