<?php

class NeueResume
{
	var $settings;
	var $vars;

	function startTimer() {
		$temp_time = microtime();
		$temp_time = explode(" ", $temp_time);
		$temp_time = $temp_time[1] + $temp_time[0];
		$this->vars['start_time'] = $temp_time;
	}

	function endTimer() {
		$temp_time = microtime();
		$temp_time = explode(" ", $temp_time);
		$temp_time = $temp_time[1] + $temp_time[0];
		$this->vars['end_time'] = $temp_time;
		$this->vars['total_time'] = ($this->vars['end_time'] - $this->vars['start_time']);
	}

	function loadSettings() {
		if (!is_file('neueresume/settings.php'))
		{
		} else {
			require('neueresume/settings.php');
		}

		if (!is_file('neueresume/themes/' . $this->settings['general']['theme'] . '/settings.php'))
		{
			return false;
		} else {

			require('neueresume/themes/' . $this->settings['general']['theme'] . '/settings.php');
			return true;
		}
	}
	function loadVars()	{
		if (file_exists('resume.xml')) {
			$resume_xml = simplexml_load_file('resume.xml');
		foreach ($resume_xml->bio->children() as $name=>$value){
			$this->vars['bio'][$name] = (string)$value;
		}
		$this->vars['bio']['social'] =  $resume_xml->bio->social;
		foreach($resume_xml->bio->social->children() as $name=>$value){
				$this->vars['bio']['social'][$name] = (string)$value;
			}

		}
	}

	function outputSettingsArray() {
		echo '<pre>';
		print_r($this->settings);
		echo '</pre>';
	}

	function outputVarsArray() {
		echo '<pre>';
		print_r($this->vars);
		echo '</pre>';
	}

	function showLoadInfo($loadInfoFormat) {

		$this->endTimer();

		$search = array(
			'{{Version}}',
			'{{LoadTime}}'
		);
		$replace = array(
			$this->vars['version'],
			number_format($this->vars['total_time'], 7)
		);

		echo str_replace($search, $replace, $loadInfoFormat);


	}

	function showThemeURL($format = 0)
	{
		//0 = Output url
		//1 = Return url as string
		if ($format == 0)
		{
			echo 'neueresume/themes/' . $this->settings['general']['theme'] . '/';
		} else if ($format == 1) {
				return 'neueresume/themes/' . $this->settings['general']['theme'] . '/';
			}
	}

	function showContactForm($contactFormFormat)	{
		$search = array(
			'{{ContactForm}}'
		);
		$replace = array(
			'
			<div class="return-message" href="#contact"></div>
			<form id="contact-form" action="index.php" method="post">

				<input class="name" type="text" name="name" value="" placeholder="Your Name" required />

				<input class="email" type="email" name="email" value="" placeholder="Your Email" required />


				<textarea class="message" name="message" placeholder="Your Message" required ></textarea>

				<button class="submit" type="submit" name="submit" value="Send Message" >Send</button>
		</form>'
		);

		echo str_replace($search, $replace, $contactFormFormat);
		
	}
	function showResume($sectionFormat, $textFormat, $jobsListItemFormat, $listItemFormat, $detailListItemFormat){
		if (file_exists('resume.xml')) {
			$resume_xml = simplexml_load_file('resume.xml');


			/* For each <character> node, we echo a separate <name>. */
			foreach ($resume_xml->section as $section) {

				$section_info['title'] = (string)$section['title'];
				$section_info['type'] = (string)$section['type'];



				switch($section_info['type']) {
				case 'detail-list':
					$temp_section_content ='';
					foreach ($section->item as $item) {

						$search = array(
							'{{Title}}',
							'{{SubTitle}}',
							'{{Date}}',
							'{{Text}}'
						);
						$replace = array(
							(string)$item->title,
							(string)$item->subtitle,
							(string)$item->date,
							(string)$item->text
						);

						$temp_section_content .= str_replace($search, $replace, $detailListItemFormat);
					};
					break;
				case 'list':
					$temp_section_content ='<ul class="talent" itemscope itemtype="http://schema.org/ItemList">';
					foreach ($section->item as $item) {
						$search = array(
							'{{Text}}'
						);
						$replace = array(
							(string)$item
						);

						$temp_section_content .= str_replace($search, $replace, $listItemFormat);
					};
					$temp_section_content .='</ul>';
					break;
				case 'jobs':
					$temp_section_content ='';
					foreach ($section->item as $item) {

						$search = array(
							'{{Title}}',
							'{{SubTitle}}',
							'{{Date}}',
							'{{Text}}',
							'{{Link}}',
							'{{ImagePath}}'
						);
						$replace = array(
							(string)$item->title,
							(string)$item->subtitle,
							(string)$item->date,
							(string)$item->text,
							(string)$item->link,
							(string)$item->image
						);

						$temp_section_content .= str_replace($search, $replace, $jobsListItemFormat);
					};
					break;
				default :
					foreach ($section->text as $text) {
						$search = array(
							'{{Text}}'
						);
						$replace = array(
							(string)$text
						);

						$temp_section_content .= str_replace($search, $replace, $textFormat);
					};
					break;

				}

				$search = array(
					'{{Title}}',
					'{{Type}}',
					'{{SectionContent}}'
				);
				$replace = array(
					$section_info['title'],
					$section_info['type'],
					$temp_section_content
				);

				echo str_replace($search, $replace, $sectionFormat);


			}
		} else {
			return false;
		}
	}
	function handleContactForm()	{
		$post = (!empty($_POST)) ? true : false;
		if($post)
		{
			$name = stripslashes($_POST['name']);
			$email = trim($_POST['email']);
			$message = stripslashes($_POST['message']);	
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
				$headers = 'From: webmaster@example.com' . "\r\n" .
		    'Reply-To: webmaster@example.com' . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();
				$mail = mail($this->settings['bio']['email'], 'Contact Form Email', 'Test message', $headers);
		
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




	function initialize()
	{
		if (isset($_POST['name']))
		{
			$this->handleContactForm();
			return true;
		}
		$this->loadVars();
		//Debug Mode
		if ($this->settings['advanced']['debug_mode'] == true)
		{
			error_reporting(E_ALL);
			ini_set('display_errors', '1');
		}

		//GZIP Compression
		ini_set('zlib.output_compression', $this->settings['advanced']['use_gzip_compression']);
		ini_set('zlib.output_compression_level', $this->settings['advanced']['gzip_compression_level']);

		require('neueresume/themes/' . $this->settings['general']['theme'] . '/template.php');

		if ($this->settings['advanced']['debug_show_all'] == true)
		{
			echo "DEBUG - Page Variables: <br><br>";
			echo "<pre>";
			print_r($this->vars);
			echo "</pre>";
		}
	}
}
?>