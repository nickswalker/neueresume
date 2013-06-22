<?php
class Contact {
	public static function executeContact( $post ){
		$post = (!empty($post)) ? true : false;
			if($post)
			{
				$name = stripslashes($_POST['name']);
				$email = trim($_POST['email']);
				$message = stripslashes($_POST['message']);	
				
				$error ='';
				// Check name
		
				if(!$name)
				{
					$error .= 'Please enter your name.<br />';
				}
			
				// Check email
			
				if(!$email)
				{
					$error .= 'Please enter an e-mail address.<br />';
				}
			
			
				// Check agains bot habit
			
				if ($name && $email && $name==$email) {
					$error .= 'Name and email cannot be the same.<br />';
				}
				
			
				// Check message (length)
			
				if(!$message || strlen($message) < 10)
				{
					$error .= "Please enter your message. It should have at least 10 characters.<br />";
				}
			
				if(!$error)
				{
					$headers = "From: ".$name." <".$email.">\r\n"
					."Reply-To: ".$email."\r\n"
					."X-Mailer: PHP/" . phpversion();
					$mail = mail('nick@nickswalker.com', 'Contact Form Email', $message, $headers);
			
					if($mail)
					{
						echo 'sent';
					}
					else	{
						echo 'failed';
					}
			
				}
				else
				{
					echo $error;
				}
			}
		}
}
?>