<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Appointment Booking (Frontend)</title>

    <link href="<?= URL ?>plugins/bootstrap-5.3.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= URL ?>plugins/bootstrap-icons-1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;1,300&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- --------RMS Local Files-------- -->
    <link rel="shortcut icon" type="image/png" href="<?= URL ?>img/appointment-booking/calendar-icon.svg" />

    <?php
    if (!empty($pluginCSS)) {
        foreach ($pluginCSS as $v) {
            if (file_exists(ROOT . "public/plugins/" . $v . ".css")) { ?>
                <link href="<?= URL ?>plugins/<?= $v ?>.css" rel="stylesheet">
    <?php }
        }
    }
    ?>

    <?php
    // appointment-client custom syles
    if (!empty($customCSS)) {
        foreach ($customCSS as $v) {
            if (file_exists(ROOT . "public/css/custom/appointment-booking-client/" . $v . ".css")) { ?>
                <link href="<?= URL ?>css/custom/appointment-booking-client/<?= $v ?>.css?v=<?= APP_VERSION ?>" rel="stylesheet">
    <?php }
        }
    }
    ?>

</head>

<body>