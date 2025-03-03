<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= APP_NAME ?></title>

    <link href="<?= URL ?>plugins/bootstrap-5.3.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= URL ?>plugins/bootstrap-icons-1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- --------RMS CDNs-------- -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/introjs.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Inline Element Edit -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" /> -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />

    <!-- --------RMS Local Files-------- -->
    <link rel="shortcut icon" type="image/png" href="<?= URL ?>img/landing-page-builder/file-color-icon.svg" />

    <?php
    if (!empty($pluginCSS)) {
        foreach ($pluginCSS as $v) {
            if (file_exists(ROOT . "public/plugins/" . $v . ".css")) { ?>
                <link href="<?= URL ?>plugins/<?= $v ?>.css" rel="stylesheet">
    <?php }
        }
    }
    ?>

    <link href="<?= URL ?>css/style.css?v=<?= APP_VERSION ?>" rel="stylesheet">
    <?php if ($this->urlDetails['controller'] && file_exists(ROOT . "public/css/page/" . $this->urlDetails['controller'] . ".css")) { # page css 
    ?>
        <link href="<?= URL ?>css/page/<?= $this->urlDetails['controller']; ?>.css?v=<?= APP_VERSION ?>" rel="stylesheet">
    <?php } ?>

    <?php
    if (!empty($customCSS)) {
        foreach ($customCSS as $v) {
            if (file_exists(ROOT . "public/css/custom/" . $v . ".css")) { ?>
                <link href="<?= URL ?>css/custom/<?= $v ?>.css?v=<?= APP_VERSION ?>" rel="stylesheet">
    <?php }
        }
    }
    ?>

</head>

<body>
    <div id="toast" class="position-fixed p-4 d-flex flex-column align-items-end"></div>
    <div id="wrapper">
        <?php require("sidebar.php"); ?>
        <div id="main">
            <div id="header" class="d-inline-flex flex-row align-items-center flex-wrap gap-3 border-bottom">
                <div class="page-breadcrumb flex-grow-1">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0">
                            <?= pageBreadcrumb($breadcrumb ?? null) ?>
                        </ol>
                    </nav>
                </div>
                <div>
                    <button type="button" class="btn btn-outline-success"><i class="bi bi-question-circle me-1"></i>
                        Help Guide</button>
                </div>
                <div class="btn-item">
                    <button type="button" class="btn btn-outline-primary"><i class="bi bi-person-workspace me-1"></i>
                        Support</button>
                </div>
                <div class="icon-item">
                    <i class="bi bi-chat-dots"></i>
                    <span class="translate-middle badge rounded-pill bg-info">18</span>
                </div>
                <div class="icon-item">
                    <i class="bi bi-bell"></i>
                    <span class="translate-middle badge rounded-pill bg-danger">99+</span>
                </div>

                <div class="dropdown">
                    <div id="userInfo" class="d-flex gap-2">
                        <div class="user-img">
                            <img src="<?= URL ?>img/user-m.jpg" class="img-fluid rounded-circle border" alt="User">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                            <span class="user-name text-truncate">John Doe</span>
                            <?php /*<small class="user-role text-secondary text-truncate"></small>*/ ?>
                        </div>
                    </div>
                    <ul class="dropdown-menu">
                        <li>
                            <h6 class="dropdown-header">Account</h6>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Account Settings</a></li>
                    </ul>
                </div>
            </div>