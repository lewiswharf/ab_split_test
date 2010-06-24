<?php

	if(!defined('__IN_SYMPHONY__')) die('<h2>Error</h2><p>You cannot directly access this file</p>');

	Class eventab_split_test extends Event{
		
		public static function about(){
			
			$description = new XMLElement('p', 'This is an event that displays basic login details (such as their real name, username and author type) if the person viewing the site have been authenticated by logging in to Symphony. It is useful if you want to do something special with the site if the person viewing it is an authenticated member.');
					
			return array(
						 'name' => 'Login Info',
						 'author' => array('name' => 'Nils Werner',
										   'website' => 'http://www.phoque.de',
										   'email' => 'nils.werner@gmail.com'),
						 'version' => '1.0',
						 'release-date' => '2010-06-24',
						 'trigger-condition' => 'anything',
						 'recognised-fields' => array(
													array('username', true), 
													array('password', true)
												));						 
		}
				
		public function load(){			
			return $this->__trigger();
		}

		public static function documentation(){
			return new XMLElement('p', 'This is an event that divides new visitors into A/B groups. It will save that assign in a cookie with last-seen information.');
		}
		
		protected function __trigger(){
			$result = new XMLElement('ab-split-test');
			
			if(kein cookie)
				$ab = $this->__ab();
			else {
				$ab = $_REQUEST['ab-group'];
				$lastseen = $_REQUEST['ab-lastseen'];
				
				$result->appendChild(new XMLElement('last-seen', $lastseen));
			}
			
			$result->setAttribute('group', $ab);
			
			return $result;
		}
		
		protected function __ab() {
			
			if(rand(1,2) == 1)
				return 'a';
			else
				return 'b';
		}
	}

?>