<?php

	if(!defined("__IN_SYMPHONY__")) die("<h2>Error</h2><p>You cannot directly access this file</p>");

	Class extension_ab_split_test extends Extension{

		private $_Path;
	
		public function about(){
			return array('name' => 'A/B Split Test',
						 'version' => '1.0',
						 'release-date' => '2008-08-07',
						 'author' => array('name' => 'Mark Lewis',
										   'website' => 'http://www.casadelewis.com',
										   'email' => 'mark@casadelewis.com'),
						 'description' => 'Allows A/B split testing of a page.'
				 		);
		}
				
		public function getSubscribedDelegates() {
			return array(
				array(
					'page'		=> '/frontend/',
					'delegate'	=> 'FrontendParamsResolve',
					'callback'	=> 'getPath'
				),
				array(
					'page' => '/frontend/',
					'delegate' => 'FrontendProcessEvents',
					'callback' => '__redirect'							
				)
			);
		}
		
	/*-------------------------------------------------------------------------
		Utilities:
	-------------------------------------------------------------------------*/
		
		public function ab() {
			
			if(rand(1,2) == 1)
				return 'a';
			else
				return 'b';
		}
		
	/*-------------------------------------------------------------------------
		Delegates:
	-------------------------------------------------------------------------*/
		
		public function getPath($context) {

			$this->_Path = $context['params']['current-path'];
		}
		
		public function __redirect($context) {
		
			if($this->ab() == 'a') {
				return false;
			} else {
				if(is_array($context['page_data']['type']) && !empty($context['page_data']['type'])) {
					foreach($context['page_data']['type'] as $val) {
						if(strstr($context['page_data']['params'], 'ab')) {
							if($val == 'index')
								redirect(URL . '/' . $context['page_data']['handle'] . '/b/');
							else
								redirect(URL . $this->_Path .'b/');
						}
					}
				} else {
					redirect(URL . $this->_Path .'b/');
				}	
			}
		}
	}
