<?php
$imageFolder = URL . "file/preview-uploads/";
$updateLogoFilePath = URL . "file/builder-uploads/";
if (isset($_GET['logoUrl'])) {
    $logoUrlDecoded = base64_decode($_GET['logoUrl']);
} else {
    $logoUrlDecoded = null;
}

if (isset($_GET['bannerUrl'])) {
    $bannerUrlDecoded = base64_decode($_GET['bannerUrl']);
} else {
    $bannerUrlDecoded = null;
}
// echo "Logo: " . $logoPath . "<br>";
// echo "Banner: " . $bannerPath . "<br>";
// echo "Brand: " . $brand . "<br>";
// echo "Mid Section: " . $midSectionContent . "<br>";
// echo "Bottom Section: " . $bottomSectionContent . "<br>";
// echo "Bottom Section ID: " . $bottomSectionId;
// exit;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?php echo $brand ?></title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <?php
    if ($logoUrlDecoded === '1') {
        echo '<link href="' . $updateLogoFilePath . '' . $logoPath . '" rel="icon">';
        echo '<link href="' . $updateLogoFilePath . '' . $logoPath . '" rel="apple-touch-icon">';
    } else {
        echo '<link href="' . $imageFolder . '' . $logoPath . '" rel="icon">';
        echo '<link href="' . $imageFolder . '' . $logoPath . '" rel="apple-touch-icon">';
    }
    ?>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
        integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    <?php
    $styles = [
        'aos/aos.css',
        'bootstrap/css/bootstrap.min',
        'glightbox/css/glightbox.min',
        'swiper/swiper-bundle.min',
        'style'
    ];
    ?>

    <?php
    if (!empty($styles)) {
        foreach ($styles as $style) {
            if (file_exists(ROOT . "public/plugins/landing-page-template/" . $style . ".css")) { ?>
    <link href="<?= URL ?>public/plugins/landing-page-template/<?= $style ?>.css?v=<?= APP_VERSION ?>" rel="stylesheet">
    <?php   }
        }
    }
    ?>
</head>

<body>
    <!-- ======= Top Bar ======= -->
    <section id="topbar" class="d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <!-- <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:$mailtoEmail"></a></i>
        <i class="bi bi-phone d-flex align-items-center ms-4"><span></span></i>
      </div>
      <div class="social-links d-none d-md-flex align-items-center">
        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
      </div> -->
        </div>
    </section>

    <!-- ======= Header ======= -->
    <header id="header" class="d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">

            <!-- <h1 class="logo"><a href="#"><span>.</span></a></h1> -->
            <!-- Uncomment below if you prefer to use an image logo -->
            <a href="#" class="logo">
                <?php
                if ($logoUrlDecoded === '1') {
                    echo '<img src="' . $updateLogoFilePath . '' . $logoPath . '" alt="">';
                } else {
                    echo '<img src="' . $imageFolder . '' . $logoPath . '" alt="">';
                }
                ?>
                <!-- <img src="../../php/builder/preview-images/<?php echo $logoPath ?>"
                alt=""> -->
            </a>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="#hero">Home</a></li>

                    <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
        <?php
        if ($bannerUrlDecoded === '1') {
            echo  ' <img id="hero-image" src="' . $updateLogoFilePath . '' . $bannerPath . '" alt=""> ';
        } else {
            echo '<img id="hero-image" src="' . $imageFolder . '' . $bannerPath . '" alt=""> ';
        }
        ?>
        ?>
        <!-- <img id="hero-image" src="../../php/builder/preview-images/<?php echo $bannerPath ?>"
        alt=""> -->
        <!-- <div class="container" data-aos="zoom-out" data-aos-delay="100"> -->
        <!-- Content goes here -->
        <!-- </div> -->
    </section>
    <!-- End Hero -->
    <section class="paragraph-section">
        <div class="section-title">

        </div>
        <?php echo $midSectionContent; ?>
    </section>
    <main id="main">

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Contact</h2>
                    <!-- <h3><span>Contact Us</span></h3> -->
                    <?php echo $bottomSectionContent; ?>
                </div>

        </section><!-- End Contact Section -->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer>
        <div class="container py-4">
            <div class="copyright text-center">
                &copy; Copyright <strong><span><?php echo $brand ?>
                        <?php echo date('Y'); ?></span></strong>.
                All Rights
                Reserved
            </div>
    </footer><!-- End Footer -->

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <?php
    $scripts = [
        'purecounter/purecounter_vanilla',
        'aos/aos',
        'bootstrap/js/bootstrap.bundle.min',
        'glightbox/js/glightbox.min',
        'isotope-layout/isotope.pkgd.min',
        'swiper/swiper-bundle.min',
        'waypoints/noframework.waypoints',
        'php-email-form/validate',
        'script',
        'custom-script'
    ];
    ?>

    <?php
    if (!empty($scripts)) {
        foreach ($scripts as $script) {
            if (file_exists(ROOT . "public/plugins/landing-page-template/" . $script . ".js")) { ?>
    <script src="<?= URL ?>public/plugins/landing-page-template/<?= $script ?>.js?v=<?= APP_VERSION ?>">
    </script>
    <?php   }
        }
    }
    ?>

</body>

</html>