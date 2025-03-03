<?php

class AppointmentBooking extends Controller
{
    function __construct($urlDetails)
    {
        parent::__construct($urlDetails);
    }

    function index()
    {
        $breadcrumb = [
            [
                'label' => 'Appointment Booking',
                'active' => true,
                'icon' => '<i class="bi bi-calendar-check"></i>'
            ]
        ];

        $pluginCSS = [];
        $pluginCSS = array_merge($pluginCSS, sysPlugins('datepicker')['css']);

        $pluginJS = [];
        $pluginJS = array_merge($pluginJS, sysPlugins('datepicker')['js']);

        require APP . "view/_templates/header.php";
        require APP . "view/appointment-booking-client/index.php";
        require APP . "view/_templates/footer.php";
    }

    function hotel()
    {
        $breadcrumb = [
            [
                'label' => 'Appointment Booking',
                'url' => URL . 'appointment-booking-client',
                'icon' => '<i class="bi bi-calendar-check"></i>'
            ],
            [
                'label' => 'Hotel',
                'active' => true
            ]
        ];

        $pluginCSS = [];
        $pluginCSS = array_merge($pluginCSS, sysPlugins('datepicker')['css']);

        $pluginJS = [];
        $pluginJS = array_merge($pluginJS, sysPlugins('datepicker')['js']);
        $pluginJS = array_merge($pluginJS, sysPlugins('sweet-alert')['js']);

        require APP . "view/_templates/header.php";
        require APP . "view/appointment-booking-client/hotel.php";
        require APP . "view/_templates/footer.php";
    }

    function photographer()
    {
        $breadcrumb = [
            [
                'label' => 'Appointment Booking',
                'url' => URL . 'appointment-booking-client',
                'icon' => '<i class="bi bi-calendar-check"></i>'
            ],
            [
                'label' => 'Photographer',
                'active' => true
            ]
        ];

        $pluginCSS = [];
        $pluginCSS = array_merge($pluginCSS, sysPlugins('datepicker')['css']);

        $pluginJS = [];
        $pluginJS = array_merge($pluginJS, sysPlugins('datepicker')['js']);
        $pluginJS = array_merge($pluginJS, sysPlugins('sweet-alert')['js']);

        require APP . "view/_templates/header.php";
        require APP . "view/appointment-booking-client/photographer.php";
        require APP . "view/_templates/footer.php";
    }

    function boutique()
    {
        $breadcrumb = [
            [
                'label' => 'Appointment Booking',
                'url' => URL . 'appointment-booking-client',
                'icon' => '<i class="bi bi-calendar-check"></i>'
            ],
            [
                'label' => 'Boutique',
                'active' => true
            ]
        ];

        $pluginCSS = [];
        $pluginCSS = array_merge($pluginCSS, sysPlugins('datepicker')['css']);

        $pluginJS = [];
        $pluginJS = array_merge($pluginJS, sysPlugins('datepicker')['js']);
        $pluginJS = array_merge($pluginJS, sysPlugins('sweet-alert')['js']);

        require APP . "view/_templates/header.php";
        require APP . "view/appointment-booking-client/boutique.php";
        require APP . "view/_templates/footer.php";
    }
}
