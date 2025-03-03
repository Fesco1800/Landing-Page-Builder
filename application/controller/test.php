<?php

class Test extends Controller
{
	function __construct($urlDetails) {
		parent::__construct($urlDetails);
	}

	function index() {
		$breadcrumb = [
			[
				'label' => 'Test Home',
				'active' => true,
				'icon' => '<i class="bi bi-peace"></i>'
			]
		];

		require APP . "view/_templates/header.php";
		require APP . "view/test/index.php";
		require APP . "view/_templates/footer.php";
	}

	function sub_1() {
		$breadcrumb = [
			[
				'label' => 'Test Home',
				'url' => URL . 'test',
				'icon' => '<i class="bi bi-peace"></i>'
			],
			[
				'label' => 'Test Sub 1',
				'active' => true
			]
		];

		require APP . "view/_templates/header.php";
		require APP . "view/test/sub-1.php";
		require APP . "view/_templates/footer.php";
	}

	function sub_2() {
		$breadcrumb = [
			[
				'label' => 'Test Home',
				'url' => URL . 'test',
				'icon' => '<i class="bi bi-peace"></i>'
			],
			[
				'label' => 'Test Sub 2',
				'active' => true
			]
		];

		require APP . "view/_templates/header.php";
		require APP . "view/test/sub-2.php";
		require APP . "view/_templates/footer.php";
	}

	function sub_2_1() {
		$breadcrumb = [
			[
				'label' => 'Test Home',
				'url' => URL . 'test',
				'icon' => '<i class="bi bi-peace"></i>'
			],
			[
				'label' => 'Test Sub 2',
				'url' => URL . 'test/sub_2',
			],
			[
				'label' => 'Test Sub 2-1',
				'active' => true
			]
		];

		require APP . "view/_templates/header.php";
		require APP . "view/test/sub-2-1.php";
		require APP . "view/_templates/footer.php";
	}

	function sub_2_2() {
		$breadcrumb = [
			[
				'label' => 'Test Home',
				'url' => URL . 'test',
				'icon' => '<i class="bi bi-peace"></i>'
			],
			[
				'label' => 'Test Sub 2',
				'url' => URL . 'test/sub_2',
			],
			[
				'label' => 'Test Sub 2-2',
				'active' => true
			]
		];

		require APP . "view/_templates/header.php";
		require APP . "view/test/sub-2-2.php";
		require APP . "view/_templates/footer.php";
	}
}
