<?php
	class Search extends Controller{
		public function __construct(){
			$this->ProductModel = $this->model('ProductModel');
		}

		/**
		 * Loads the view Products page by default, displays a search results page
         * Uses GET to handle searching (allows book marking of search page)
		 */
		public function index(){
            if(isset($_GET['query'])) {
                $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
                $query = trim($_GET['query']);

                $Products = $this->ProductModel->searchProducts($query);

                $data = [
                    'title' => 'Welcome Search Product Page!',
                    'query' => $query,
                    'Products' => $Products
                ];

                $this->view('includes/header');
                $this->view('search/search', $data);
                $this->view('includes/footer');
                $this->script('search');
            } else {
                $Products = $this->ProductModel->getAllProducts();

                $data = [
                    'title' => 'Welcome Search Product Page!',
                    'query' => '',
                    'Products' => $Products
                ];

                $this->view('includes/header');
                $this->view('search/search', $data);
                $this->view('includes/footer');
                $this->script('search');
            }
        }


	}
