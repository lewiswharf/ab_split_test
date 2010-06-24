<?php

	if(!defined("__IN_SYMPHONY__")) die("<h2>Error</h2><p>You cannot directly access this file</p>");

	Class extension_ab_split_test extends Extension{

		private $_Path;
	
		public function about(){
			return array('name' => 'A/B Split Test',
						 'version' => '1.0',
						 'release-date' => '2008-08-07',
						 'author' => array('name' => 'Mark Lewis, Nils Werner',
										   'website' => 'http://www.casadelewis.com',
										   'email' => 'mark@casadelewis.com'),
						 'description' => 'Allows A/B split testing of a page.'
				 		);
		}
				
		public function getSubscribedDelegates() {
			return array(
				array(
					'page' => '/system/preferences/',
					'delegate' => 'AddCustomPreferenceFieldsets',
					'callback' => 'appendPreferences'
				),	
			);
		}
		
		function install() {
			Administration::instance()->Configuration->set('testid',substr(md5(time()), 0, 5),'ab');            
			Administration::instance()->saveConfig();
			return true;
		}
		
		public function uninstall(){
			Administration::instance()->Configuration->remove('ab');
			Administration::instance()->saveConfig();
		}
		
		public function appendPreferences($context){
			
			if(isset($_POST['action']['ab-reset'])){
				$this->__SavePreferences($context);
			}
			
			$group = new XMLElement('fieldset');
			$group->setAttribute('class', 'settings');
			$group->appendChild(new XMLElement('legend', __('A/B Split Test')));			
			

			$div = new XMLElement('div', NULL, array('id' => 'file-actions', 'class' => 'label'));			
			$span = new XMLElement('span');
			
			$span->appendChild(new XMLElement('button', __('Reset assigns'), array('name' => 'action[ab-reset]', 'type' => 'submit')));	
			
			$div->appendChild($span);

			$div->appendChild(new XMLElement('p', __('Resets A/B group assigns for a new test.'), array('class' => 'help')));	

			$group->appendChild($div);						
			$context['wrapper']->appendChild($group);
			unset($context);
						
		}
		
		public function __SavePreferences($context){
			Administration::instance()->Configuration->set('testid',substr(md5(time()), 0, 5),'ab');
			Administration::instance()->saveConfig();
		}
	}
