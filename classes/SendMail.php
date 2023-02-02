<?php
/**
 * PHP makes use of mail() function to send an email. This function requires three mandatory arguments that specify the recipient's
 * email address, the subject of the the message and the actual message additionally there are other two optional parameters.
 *
 * mail( to, subject, message, headers, parameters );
 */
 
/*
 * Usage:
 * $mail = new SendMail();
 * $mail->set_to('krs@aarhustech.dk');
 * $mail->set_subject('Red');
 * $mail->set_name();
 * $mail->;
 * $mail->;
 */
 
 
class SendMail 
{
	// Properties
	public $to;         // * Required. Specifies the receiver / receivers of the email
	public $subject;    // * Required. Specifies the subject of the email. This parameter cannot contain any newline characters
	public $message;    // * Required. Defines the message to be sent. Each line should be separated with a LF (\n). Lines should not exceed 70 characters
	public $headers;    //   Optional. Specifies additional headers, like From, Cc, and Bcc. The additional headers should be separated with a CRLF (\r\n)
	public $parameters; //   Optional. Specifies an additional parameter to the send mail program
	public $region;     //   Optional. Specifies the region of the email. The region is used to determine the email address of the receiver

	
	// Methods
	
	// Getter-Setter
	function set_sender($to) { $this->to = $to; }	
	function get_sender() { return $this->to; }	
	
	function set_subject($subject)	{ $this->subject = $subject; }
	function get_subject()	{ return $this->subject; }
		
	function set_message($message) { $this->message = $message; }
	function get_message() { return $this->message; }
		
	function set_headers($headers) { $this->headers =  $headers; }
	function get_headers() { return $this->headers; }
		
	function set_parameters($parameters) { $this->parameters =  $parameters; }
	function get_parameters() { return $this->parameters; }


	// Constructors
	function __construct($region, $subject, $message) {
		require_once(realpath (dirname(__FILE__))."/config/dbconfig.php");
		
		$this->to      = $region_mail[$region];
		$this->subject = ( isset($subject) && $subject != "")?$subject:"Tjekind Cloud besked";
		$this->region  = ( isset($region) && $region!="" )?$region:0;
		$this->message = ( isset($message) && $message != "")?$message:"Mail sendt fra Tjekinds Cloud API";

		$header  = "From:kontakt@ats-skpdatait.dk\r\n";
		$header .= "Cc:krs@aarhustech.dk\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html\r\n";

		$this->headers  = $header;
	}
	
	
	// Static Methods
	public static function is_php_mail_available() {
		if ( function_exists( 'mail' ) )
		{
			//echo 'mail() is available';
			return true;
		}
		else
		{
			//echo 'mail() has been disabled';
			return false;
		}
	}

	
	public static function test_send_mail() {
		if ( SendMail::is_php_mail_available() )
		{
			$subject = "This is subject";

			$message  = "<b>This is HTML message.</b>";
			$message .= "<h1>This is headline.</h1>";

			$mail = new SendMail(0, $subject, $message);

			if( $mail->is_mail_valid() )
				$mail->send_the_mail();
		}
	}

	
	// Action methods
	function is_mail_valid() {
		if( $this->to != "" && $this->subject != "" && $this->message != "" && $this->headers != "")
			return true;
		else
			return false;
	}
	
	
	function send_the_mail() {
		//print_r($this->to . "\n\r" . $this->subject . "\n\r" . $this->message . "\n\r" . $this->headers);
		$retval = mail($this->to, $this->subject, $this->message, $this->headers);
         
        if( $retval == true ) {
			echo "Message sent successfully...";
        } else {
			echo "Message could not be sent...";
        }
	}
}
?>