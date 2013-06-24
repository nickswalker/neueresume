<?php
require 'contact.php';
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
	function showResume($sectionFormat, $highlightListItemFormat, $listItemFormat, $detailListItemFormat){
		if (file_exists('resume.xml')) {
			$resume_xml = simplexml_load_file('resume.xml');


			/* For each <character> node, we echo a separate <name>. */
			foreach ($resume_xml->section as $section) {

				$section_info['title'] = (string)$section['title'];
				$section_info['type'] = (string)$section['type'];

				$temp_section_content ='';

				switch($section_info['type']) {
				
				case 'arbitrary':
					echo ('<section class="'. $section_info['title']. $section_info['type'].'">'.$section.'</section>');
					/* Skip to the end current switch loop, then skip the end of the whole foreach to avoid printing anything else */
					continue 2;

				case 'detail-list':
					foreach ($section->item as $item) {

						$search = array(
							'{{Title}}',
							'{{SubTitle}}',
							'{{Date}}',
							'{{Link}}',
							'{{Text}}'
						);
						$replace = array(
							(string)$item->title,
							(string)$item->subtitle,
							(string)$item->date,
							(string)$item->link,
							(string)$item->text
						);
						$temp_section_content .= str_replace($search, $replace, $detailListItemFormat);
					};
					break;
				case 'list':
					$temp_section_content ='<ul itemscope itemtype="http://schema.org/ItemList">';
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
						if((string)$item['type']=='arbitrary'){
							$temp_section_content .= (string)$item;
						}
						else{
							$temp_section_content .= str_replace($search, $replace, $highlightListItemFormat);
						}
						
					};
					break;
				default :
					$temp_section_content .= (string)$section;
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
		Contact::executeContact($_POST);
	}
	function initialize()
	{
		$this->loadVars();
		if (isset($_POST['name']))
		{
			$this->handleContactForm();
			return true;
		}
		//Debug Mode
		if ($this->settings['advanced']['debug_mode'] == true)
		{
			error_reporting(E_ALL);
			ini_set('display_errors', '1');
		}

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