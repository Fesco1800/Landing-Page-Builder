<?php
$imageFolder = URL . 'img/landing-page-builder/';
// echo $successMessage;
$redirectURL = URL . 'landing-page-builder/';

$landingPageLink =
    URL .
    'landing-page-builder/visit?id=' .
    $_GET['id'] .
    '&bottomSectionId=' .
    $_GET['bottomSectionId'];
?>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<style>
    body {
        letter-spacing: 0.7px;
        background-color: #ffffff;
        background-image: url("<?= $imageFolder ?>svg-flip.png");
        background-size: cover;
        background-repeat: no-repeat;
    }

    .container {
        margin-top: 120px;
        margin-bottom: 120px;
    }

    .btn-lg,
    a:focus,
    a:active {
        outline: none !important;
        box-shadow: none !important;
    }

    .card-1 {
        box-shadow: none;
    }

    p {
        font-size: 13px;
    }

    .small {
        font-size: 9px !important;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    #go {
        text-decoration: none;
    }

    .btn-round-lg {
        border-radius: 22.5px;
        background-color: #eee;
        color: #3D5AFE;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 0.9px;
        padding: 8px 20px 8px 20px !important;
        border: 1px solid #fff;
    }

    .btn-round-lg:hover {
        background-color: #fff;
        color: #3D5AFE;
        border: 1px solid #fff;
    }

    .btn-round-lg:focus {
        border: 1px solid #fff !important;
    }

    .card {
        background-color: #106eea !important;
        color: white;
    }

    .card-header {
        background-color: #106eea !important;
    }

    .generated-link {
        text-decoration: none;
        color: #000000;
    }

    .go-back {
        text-decoration: none;
        color: #ffffff;
        font-size: 25px;
    }

    .go-back:hover {
        color: #E2DFD2;
    }
</style>


<div class="container d-flex justify-content-center">
    <div class="card shaodw-lg card-1">
        <div class="card-header pt-3 pb-0 ml-auto border-0">
            <a href="<?php echo $redirectURL ?>" class="go-back">
                <i class="bi bi-arrow-left"></i>

            </a>
        </div>
        <div class="card-body d-flex pt-0">
            <div class="row no-gutters mx-auto justify-content-start flex-sm-row flex-column">
                <div class="col-md-4 text-center">
                    <a href="#" title="add icons">
                        <img class="irc_mi img-fluid mr-0" src="<?= $imageFolder ?>file-html-color-red-icon.png" width="150" height="150">
                    </a>
                </div>
                <div class="col-md-6">
                    <div class="card border-0">
                        <div class="card-body">
                            <h5 class="card-title"><b>Great!, New site is successfully created</b></h5>
                            <p class="card-text">
                            <p>Click the button below to visit the page.</p>
                            </p>
                            <button type="button" class="btn btn-primary btn-round-lg btn-lg">
                                <a href="<?php echo $landingPageLink  ?>" id="go">Go to the Generated Site</a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
</script>