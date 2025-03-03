<?php

class PageNotFound extends Controller
{
	/**
	 * PAGE: index
	 * This method handles the error page that will be shown when a page is not found
	 */
	function index() {
		// load views
		require APP . 'view/_templates/header.php';
		require APP . 'view/page-not-found/index.php';
		require APP . 'view/_templates/footer.php';
	}
}
