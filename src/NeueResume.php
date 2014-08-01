<?php
namespace Nickswalker\NeueResume;

class NeueResume{
	var $settings;
	var $vars;
	var $resumePathFromRoot;
	var $themePathFromRoot; //Relative from installation URL
	var $publicPathFroomRoot; 
	var $packagePathFromRoot; //Location of NeueResume.php
	
	function __construct($publicPathFromRoot, $themePathFromRoot ){
		$this->publicPathFromRoot = $publicPathFromRoot. '/';
		$this->packagePathFromRoot = dirname(__FILE__) . '/';
		$this->themePathFromRoot = $themePathFromRoot .'/';
		$this->vars['version'] = '1.2';

		$this->startTimer();

		$this->loadSettings();
	
		
	}
	function loadSettings() {
	
		$this->settings = include( $this->packagePathFromRoot .'settings.php');
		$themeSettingsPath = $this->themePathFromRoot . 'settings.php';
		if ( is_file($themeSettingsPath) ){
			$themeSettings = include( $themeSettingsPath );
			$this->settings = array_replace_recursive($this->settings, $themeSettings);
		}
	}

	function display(){
		if (!is_file($this->resumePathFromRoot)){ echo "Your resume.xml couldn't be loaded! Check your path."; return false; }
		
		$resume_xml = simplexml_load_file($this->resumePathFromRoot);
		foreach ($resume_xml->bio->children() as $name=>$value){
			$this->vars['bio'][$name] = (string)$value;
		}
		$this->vars['bio']['social'] =  $resume_xml->bio->social;
		foreach($resume_xml->bio->social->children() as $name=>$value){
			$this->vars['bio']['social'][$name] = (string)$value;
		}
		
		$bio = $this->vars['bio'];
		$social = $this->vars['bio']['social'];
		$settings = $this->settings;
		require $this->themePathFromRoot . '/template.php';
		
		//Debug Mode
		if ($this->settings['advanced']['debug']){
			error_reporting(E_ALL);
			ini_set('display_errors', '1');
			echo "DEBUG - Page Variables: <br><br>";
			echo "<pre>";
			print_r($this->vars);
			echo "</pre>";
			echo "DEBUG - Settings: <br><br>";
			echo "<pre>";
			print_r($this->settings);
			echo "</pre>";
		}
	}
	//Parses XML and delegates to functions to return processed HTML
	function showSections(){
		$sectionFormat = $this->settings['theme']['sectionFormat'];
		if (file_exists($this->resumePathFromRoot)) {
			$resume_xml = simplexml_load_file($this->resumePathFromRoot);


			foreach ($resume_xml->section as $section) {

				//Each section must have a title and type
				$section_info['title'] = (string)$section['title'];
				$section_info['type'] = (string)$section['type'];

				$temp_section_content ='';

				switch($section_info['type']) {
				
				case 'arbitrary':
					echo ('<section class="'. $section_info['title']. $section_info['type'].'">'.$section.'</section>');
					/* Skip to the end current switch loop, then skip the end of the whole foreach to avoid printing anything else */
					continue 2;
				case 'grouped-list':
					$temp_section_content = $this->makeGroupedListSection($section);
					break;
				case 'detail-list':
					$temp_section_content = $this->makeDetailListSection($section);
					break;
				case 'list':
					$temp_section_content = $this->makeListSection($section);
					break;
				case 'highlight-list':
					$temp_section_content = $this->makeHighlightListSection($section);
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
	//Functions to process each type of section
	function makeListSection($section){
		$listItemFormat= $this->settings['theme']['listItemFormat'];
		$returnString = '';
		$returnString ='<ul itemscope itemtype="http://schema.org/ItemList">';
					foreach ($section->item as $item) {
						$search = array(
							'{{Text}}'
						);
						$replace = array(
							(string)$item
						);

						$returnString .= str_replace($search, $replace, $listItemFormat);
					};
					$returnString .='</ul>';
		
		return $returnString;
	}
	function makeDetailListSection($section){
		$detailListItemFormat= $this->settings['theme']['detailListItemFormat'];
		$returnString = '';
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
			$returnString .= str_replace($search, $replace, $detailListItemFormat);
		};
		return $returnString;
	}
	function makeHighlightListSection($section){
		$highlightListItemFormat= $this->settings['theme']['highlightListItemFormat'];
		$returnString = '';
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
				(string)$item->{'image-path'}
			);
			if((string)$item['type']=='arbitrary'){
				$returnString .= (string)$item;
			}
			else{
				$returnString .= str_replace($search, $replace, $highlightListItemFormat);
			}
			
		};
		return $returnString;
	}
	function makeGroupedListSection($section){	
		$groupedListGroupFormat= $this->settings['theme']['groupedListGroupFormat'];
		$returnString = '';
		foreach ($section->group as $group) {
			//For each group in this section grab all item children into a string
			$temp_group_content = $this->makeDetailListSection($group);
			$group_info['title'] = (string)$group['title'];
			$search = array(
				'{{Title}}',
				'{{Group}}'
			);
			$replace = array(
				$group_info['title'],
				$temp_group_content
			);

			$returnString .= str_replace($search, $replace, $groupedListGroupFormat);
		};
		return $returnString;
	}
	function getThemeURL(){
		//We stipulate that the theme path must be public.
		//Thus, we remove the installation path from the theme path and we are left
		//with a relative path to the theme.
		
		// publicPathFromRoot  home/www/public_html/
		// themePathFromRoot   home/www/public_html/resume/themes/default
		// result			   					    resume/themes/default
		
		//Just add a slash to the front and you're set!
		return '/'. str_replace($this->publicPathFromRoot, '', $this->themePathFromRoot);
	}
	//Debug and plumbing

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
	//This is a convenience polyfill until PHP6
function issetor(&$var, $default = false) {
	return isset($var) ? $var : $default;
}

}

