<?php

	function lang($phrase) {

		static $lang = array(

			// Navbar Links

			'HOME_ADMIN' 	=> 'Home',
			'Users' 		=> 'Users',
			'BOOKS'		=> 'Books',
			'' => '',
			'' => '',
			'' => '',
			'' => '',
			'' => ''
		);

		return $lang[$phrase];

	}
