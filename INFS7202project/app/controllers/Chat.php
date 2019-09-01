<?php
	class Chat extends Controller {
		public function __construct(){
            
        }

		/**
		 * WARNING: Does not work on uq zone, only works on local host
		 */
		public function index(){
            $this->view('chat/index');
		}


    }
    
