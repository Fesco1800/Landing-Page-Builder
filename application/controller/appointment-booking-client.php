<?php

class AppointmentBookingClient extends Controller
{
    function __construct($urlDetails)
    {
        parent::__construct($urlDetails);
    }

    function index()
    {

        $pluginCSS = [];
        $pluginCSS = array_merge($pluginCSS, sysPlugins('datepicker')['css']);

        $pluginJS = [];
        $pluginJS = array_merge($pluginJS, sysPlugins('datepicker')['js']);

        require APP . "view/appointment-booking-client/index.php";
    }

    function hotel()
    {

        $pluginCSS = [];
        $pluginCSS = array_merge($pluginCSS, sysPlugins('datepicker')['css']);

        $pluginJS = [];
        $pluginJS = array_merge($pluginJS, sysPlugins('datepicker')['js']);
        $pluginJS = array_merge($pluginJS, sysPlugins('sweet-alert')['js']);

        $customCSS = [
            'appointment-booking',
        ];

        $customJS = [
            'appointment-booking',
        ];
        require APP . "view/_templates/appointment-booking-client/header.php";
        require APP . "view/appointment-booking-client/hotel.php";
        require APP . "view/_templates/appointment-booking-client/footer.php";
    }

    function photographer()
    {

        $pluginCSS = [];
        $pluginCSS = array_merge($pluginCSS, sysPlugins('datepicker')['css']);

        $pluginJS = [];
        $pluginJS = array_merge($pluginJS, sysPlugins('datepicker')['js']);
        $pluginJS = array_merge($pluginJS, sysPlugins('sweet-alert')['js']);

        $customCSS = [
            'appointment-booking',
        ];

        $customJS = [
            'appointment-booking',
        ];

        require APP . "view/_templates/appointment-booking-client/header.php";
        require APP . "view/appointment-booking-client/photographer.php";
        require APP . "view/_templates/appointment-booking-client/footer.php";
    }

    function boutique()
    {
        $pluginCSS = [];
        $pluginCSS = array_merge($pluginCSS, sysPlugins('datepicker')['css']);

        $pluginJS = [];
        $pluginJS = array_merge($pluginJS, sysPlugins('datepicker')['js']);
        $pluginJS = array_merge($pluginJS, sysPlugins('sweet-alert')['js']);

        $customCSS = [
            'appointment-booking',
        ];

        $customJS = [
            'appointment-booking',
        ];

        require APP . "view/_templates/appointment-booking-client/header.php";
        require APP . "view/appointment-booking-client/boutique.php";
        require APP . "view/_templates/appointment-booking-client/footer.php";
    }

    public function save()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $appointmentData = [
                'duration' => isset($_POST["duration"]) ? $_POST["duration"] : '',
                'date' => isset($_POST["date"]) ? $_POST["date"] : '',
                'time' => isset($_POST["time"]) ? $_POST["time"] : '',
                'time_zone' => isset($_POST["time_zone"]) ? $_POST["time_zone"] : '',
                'first_name' => isset($_POST["fname"]) ? $_POST["fname"] : '',
                'last_name' => isset($_POST["lname"]) ? $_POST["lname"] : '',
                'email' => isset($_POST["email"]) ? $_POST["email"] : '',
                'phone' => isset($_POST["phone"]) ? $_POST["phone"] : '',
                'wedding_date' => isset($_POST["wedding_date"]) ? $this->formatDate($_POST["wedding_date"]) : '',
                'guest_size' => isset($_POST["guest_size"]) ? $_POST["guest_size"] : '',
                'remarks' => isset($_POST["remarks"]) ? $_POST["remarks"] : '',
                'appointment_type' => isset($_POST["appointment_type"]) ? $_POST["appointment_type"] : ''
            ];

            $appointmentBookingClientModel = new AppointmentBookingClientModel();
            $result = $appointmentBookingClientModel->save($appointmentData);

            if ($result) {
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Appointment saved successfully']);
                } else {
                    $error_message = "Error occurred while saving the appointment";
                    echo json_encode(['success' => false, 'message' => $error_message]);
                    exit();
                }
            }
        }
    }

    private function formatDate($dateString)
    {
        // Example: "Friday, August 2, 2024"
        // Convert to MySQL DATE format "YYYY-MM-DD"
        $timestamp = strtotime($dateString);
        return date('Y-m-d', $timestamp);
    }
}
