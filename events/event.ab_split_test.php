<?php

	if(!defined('__IN_SYMPHONY__')) die('<h2>Error</h2><p>You cannot directly access this file</p>');

	Class eventab_split_test extends Event{
		
		private $_cookie;
		
		public static function about(){
			
			$description = new XMLElement('p', __('This is an event that divides new visitors into two groups for A/B testing. It will save that assign and, time of the last visit and the total number of visits in a cookie. This information can be deleted in the Preferences dialog. Append this Event to all Pages you want to include in the test.'));
					
			return array(
						 'name' => __('A/B Split Test'),
						 'author' => array('name' => 'Nils Werner',
										   'website' => 'http://www.phoque.de',
										   'email' => 'nils.werner@gmail.com'),
						 'version' => '1.1',
						 'release-date' => '2010-06-24',
						 'trigger-condition' => 'anything',
						 );						 
		}
				
		public function load(){			
			return $this->__trigger();
		}

		public static function documentation(){
			return new XMLElement('p', __('This is an event that divides new visitors into two groups for A/B testing. It will save that assign and, time of the last visit and the total number of visits in a cookie. This information can be deleted in the Preferences dialog. Append this Event to all Pages you want to include in the test.'));
		}
		
		protected function __trigger(){
			$testid = Frontend::instance()->Configuration->get('testid','ab');
			$count = 0;
			$lastseen = "never";
			$this->_cookie =& new Cookie(Frontend::instance()->Configuration->get('cookie_prefix','symphony') . 'ab', TWO_WEEKS, __SYM_COOKIE_PATH__);
			
			$result = new XMLElement('ab-split-test');
			
			if($this->_cookie->get('group') === NULL || $this->_cookie->get('testid') != $testid) { /* new visitor, roll die and save to cookie */
				$ab = $this->__ab();
				$this->_cookie->set('group', $ab);
				$this->_cookie->set('testid', $testid);
				
				$result->setAttribute('from-cookie', 'false');
			}
			else { /* known visitor, fetch information from cookie */
				$ab = $this->_cookie->get('group');
				$lastseen = $this->_cookie->get('lastseen');
				$count = $this->_cookie->get('count');
				
				$result->setAttribute('from-cookie', 'true');
				
			}
			
			$result->setAttribute('group', $ab);
			
			$result->appendChild(new XMLElement('last-seen', $lastseen));
			$result->appendChild(new XMLElement('count', "" . $count));	// Hack to make XMLElement take zero as a value		
			$result->appendChild(new XMLElement('test-id', $testid));
			
			$this->_cookie->set('lastseen', DateTimeObj::get('c', time()));
			$this->_cookie->set('count', 1+$count);
			
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