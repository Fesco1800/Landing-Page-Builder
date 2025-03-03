<?php

class Home extends Controller
{
    function __construct($urlDetails)
    {
        parent::__construct($urlDetails);
    }

    function index()
    {
        $breadcrumb = [
            [
                'label' => 'Home',
                'active' => true,
                'icon' => '<i class="bi bi-house-door"></i>'
            ]
        ];

        $customCSS = [
            'test-custom-style'
        ];

        $customJS = [
            'test-custom-script'
        ];

        require APP . "view/_templates/header.php";
        require APP . "view/home/index.php";
        require APP . "view/_templates/footer.php";
    }
}
