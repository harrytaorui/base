<?php
    
require_once APPROOT.'/helpers/simple_html_dom.php';

class CelebrityChefs extends Controller{

	/**
	 * Scrape https://www.gordonramsay.com for top recipes
	 * and create preview with external links
	 * 
	 */
	public function index(){
		$data = [
			'title' => 'Gordon Ramsay\'s Top Recipes',
			'baseurl' => 'https://www.gordonramsay.com'
		];

		// Create DOM from URL or file
		$html = file_get_html($data['baseurl'] . '/gr/recipes/');
		$recipesList = $html->find('.recipe');

		// Crawl DOM and extract recipe data
		$topRecipes = [];
		for($i = 0; $i < count($recipesList); $i++) {
			$item = $recipesList[$i]->find('.summary', 0);
			// Get image src path
			$img = $recipesList[$i]->find('.image', 0);
			preg_match('#\((.*?)\)#', $img->style, $src);
			$value = [
				'src' => $src[1],
				'href' => $item->find('a', 0)->href,
				'title' => $item->find('h2',0)->plaintext,
				'desc' => $item->find('p',0)->plaintext
			];
			$topRecipes[$i] = $value;
		}

		// Add crawled data to input to view
		$data['list'] = $topRecipes;
		
		$this->view('includes/header');
		$this->view('celebchefs/ramsay', $data);
		$this->view('includes/footer');
	}

}