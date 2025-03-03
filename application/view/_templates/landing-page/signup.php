<?php
$imageFolder = URL . 'img/landing-page-builder/';

if (strpos($_SERVER['REQUEST_URI'], 'success=1') !== false) {
    echo '
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var successModal = new bootstrap.Modal(document.getElementById("success_tic"));
            successModal.show();
        });
    </script>';
} elseif (strpos($_SERVER['REQUEST_URI'], 'error=1') !== false) {
    echo '
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var errorModal = new bootstrap.Modal(document.getElementById("error_tic"));
            errorModal.show();
        });
    </script>';
}

// Decoded top section:
$decodedTopSectionContent = json_decode($topSectionContent, true);

// Decoded mid section:
$decodedMidSectionContent = json_decode($midSectionContent, true);

// Decoded bottom section:
$decodedBottomSectionContent = json_decode($bottomSectionContent, true);

// Decode JSON to associative arrays
$logoStylesArray = json_decode($logoStyles, true);
$pageTitleStylesArray = json_decode($pageTitleStyles, true);

// Function to convert camelCase to kebab-case
function camelCaseToKebabCase($property)
{
    return strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $property));
}

// Build the inline style string for logo
$logoStyleString = '';
foreach ($logoStylesArray as $property => $value) {
    $cssProperty = camelCaseToKebabCase($property);
    $logoStyleString .= "$cssProperty: $value; ";
}

// Build the inline style string for page title
$pageTitleStyleString = '';
foreach ($pageTitleStylesArray as $property => $value) {
    $cssProperty = camelCaseToKebabCase($property);
    $pageTitleStyleString .= "$cssProperty: $value; ";
}
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
    <link href="<?= URL ?>public/file/builder-uploads/<?php echo $logoPath; ?>" rel="icon">
    <link href="<?= URL ?>public/file/builder-uploads/<?php echo $logoPath; ?>" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />


    <?php
    $styles = [
        'aos/aos.css',
        'bootstrap/css/bootstrap.min',
        'glightbox/css/glightbox.min',
        'swiper/swiper-bundle.min',
        'style1'
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
    <!-- <section id="topbar" class="d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">

        </div>
    </section> -->

    <!-- ======= Header ======= -->
    <!-- <header id="header" class="d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between"> -->

    <!-- <h1 class="logo"><a href="#"><span>.</span></a></h1> -->
    <!-- Uncomment below if you prefer to use an image logo -->
    <!-- <a href="#" class="logo">
                <img src="<?= URL ?>file/builder-uploads/<?php echo $logoPath; ?>" alt="">
                <span><?php echo $brand ?></span>
            </a>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="#hero">Home</a></li>

                    <li><a class="nav-link scrollto" href="#contact">Sign-up</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>

        </div>
    </header> -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="" style="background-image: url('<?= URL ?>file/builder-uploads/<?php echo $bannerPath; ?>');">
        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
            </ul>
            <a href="#" class="logo mt-2">
                <img src="<?= URL ?>file/builder-uploads/<?php echo $logoPath; ?>" alt=""
                    style="<?php echo $logoStyleString; ?>">
            </a>
            <ul>
                <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
        <div class="page-title-container d-flex justify-content-center">
            <span class="text-center" style="<?php echo $pageTitleStyleString; ?>"><?php echo $brand ?></span>
        </div>
        <!-- <img id="hero-image" src="<?= URL ?>file/builder-uploads/<?php echo $bannerPath; ?>" alt=""> -->
        <div class="top-section-content-container">
            <?php 
                // Check if decoding was successful and 'content' exists
                if ($decodedTopSectionContent && isset($decodedTopSectionContent['content'])) {
                    // Output the HTML content
                    echo $decodedTopSectionContent['content'];
                } else {
                    // Handle case where decoding fails or 'content' is missing
                    echo '<p>Error: Unable to render top section content.</p>';
                }
            ?>
        </div>
    </section>

    <section 
        class="paragraph-section" 
        style="background-image: <?php echo $midSectionBg ?>;
            background-size: cover;"
        <!-- <div class="section-title"></div> -->
        <?php 
            // Check if decoding was successful and 'content' exists
            if ($decodedMidSectionContent && isset($decodedMidSectionContent['content'])) {
                // Output the HTML content
                echo $decodedMidSectionContent['content'];
            } else {
                // Handle case where decoding fails or 'content' is missing
                echo '<p>Error: Unable to render mid-section content.</p>';
            }
        ?>
    </section>
    <main id="main">
        <!-- Sucess Modal -->
        <div id="success_tic" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <a class="close" data-bs-dismiss="modal">&times;</a>
                    <div class="page-body">
                        <div class="head">
                            <h3 style="margin-top:5px;">Great !</h3>
                            <h4>Signup form is submitted successfully</h4>
                        </div>

                        <h1 style="text-align:center;">
                            <div class="checkmark-circle">
                                <div class="background"></div>
                                <div class="checkmark draw"></div>
                            </div>
                            <h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- Error Modal -->
        <div id="error_tic" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="page-body">
                        <div class="head">
                            <h3 style="margin-top:5px;">Error !</h3>
                            <h4>There is a problem in the server, try again later</h4>
                        </div>
                        <h1 style="text-align:center;">
                            <div class="x-circle">
                                <div class="background">
                                    <div class="x draw">
                                        <img class="x-mark" src="<?= $imageFolder ?>x-mark.svg" alt="x">
                                    </div>
                                </div>
                            </div>
                            <h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- ======= Signup Section ======= -->
        <section id="contact" class="contact" style="background-image: <?php echo $bottomSectionBg ?>;
            background-size: cover;">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>Contact</h2>
                    <!-- <h3><span>Contact Us</span></h3> -->
                    <form class="mt-4" id="signup-form" action="<?= URL ?>submit-landing-page/submitSignup" method="post" enctype="multipart/form-data">
                        <span class="loader mt-3 d-none" id="loader"></span>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="error-message"></div>
                        <div class="alert alert-success mt-2 d-none" role="alert" id="success-message"></div>
                        <input type="text" name="honeypot" style="display:none">
                        <input type="hidden" name="logo" value="<?= URL ?>file/builder-uploads/<?php echo $logoPath; ?>">
                        <input type="hidden" name="brand" value="<?php echo $brand; ?>">
                        <input type="hidden" name="link" value="<?php echo $landingPageLink; ?>">
                        <input type="hidden" name="landing_page_id" value="<?php echo $landingPageId; ?>">
                        <input type="hidden" name="mailto" value="<?php echo $mailto; ?>">
                        <input type="hidden" name="email_svg" value="<?= URL ?>img/landing-page-builder/red-mail.png">
                        <input type="hidden" name="email_bg" value="<?= URL ?>img/landing-page-builder/svg-flip.png">
                        <?php 
                            // Check if decoding was successful and 'content' exists
                            if ($decodedBottomSectionContent && isset($decodedBottomSectionContent['content'])) {
                                // Output the HTML content
                                echo $decodedBottomSectionContent['content'];
                            } else {
                                // Handle case where decoding fails or 'content' is missing
                                echo '<p>Error: Unable to render bottom-section content.</p>';
                            }
                        ?>
                        <div class="subject-container"><input type="text" class="form-control" id="subject" name="subject" placeholder="Subject"></div>
                        <button type="button" id="signup-submit-btn" class="btn btn-md btn-primary mt-3 vendor-submit-button">Submit</button>
                    </form>
                </div>

        </section><!-- End Contact Section -->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <!-- <footer>
        <div class="container py-4">
            <div class="copyright text-center">
                &copy; Copyright <strong><span><?php echo $brand ?>
                        <?php echo date('Y'); ?></span></strong>.
                All Rights
                Reserved
            </div>
    </footer>End Footer -->
    <div class="footer-container" id="footer-container" style="display: none;">
        <div class="row">
            <?php echo $footerContent ?>
        </div>
    </div>
    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script>
        var url = "<?= URL ?>";
        var footerLogo = "<?php echo $logoPath; ?>";
    </script>

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
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
</body>

</html>