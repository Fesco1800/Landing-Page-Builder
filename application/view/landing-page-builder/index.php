<?php
$imageFolder = URL . 'img/landing-page-builder/';

// UPDATE
if (isset($_SESSION['update'])) {
    $update = $_SESSION['update'];
    $update_id = $update['id'];
    $update_logoPath = $update['logoPath'];
    $update_logoStyles = $update['logoStyles'];
    $update_pageTitleStyles = $update['pageTitleStyles'];
    $update_brandName = $update['brandName'];
    $update_bannerPath = $update['bannerPath'];
    $update_heading = $update['heading'];
    $update_subheading = $update['subheading'];
    $update_midSection = $update['midSection'];
    $update_midSectionBg = $update['midSectionBg'];
    $update_bottomSection = $update['bottomSection'];
    $update_mailto = $update['mailto'];
    $update_bottomSectionBg = $update['bottomSectionBg'];
    $update_footer = $update['footer'];

    $builderMode = 'update';
    unset($_SESSION['update']);
} else {

    $update_id = "";
    $update_logoPath = "";
    $update_logoStyles = "";
    $update_pageTitleStyles = "";
    $update_brandName = "";
    $update_bannerPath = "";
    $update_heading = "";
    $update_subheading = "";
    $update_midSection = "";
    $update_midSectionBg = "";
    $update_bottomSection = "";
    $update_mailto = "";
    $update_bottomSectionBg = "";
    $update_footer = "";
}

// TEMPLATE
if (isset($_SESSION['template'])) {
    $template = $_SESSION['template'];
    $template_id = $template['id'];
    $template_logoPath = $template['logoPath'];
    $template_logoStyles = $template['logoStyles'];
    $template_pageTitleStyles = $template['pageTitleStyles'];
    $template_brandName = $template['brandName'];
    $template_bannerPath = $template['bannerPath'];
    $template_heading = $template['heading'];
    $template_subheading = $template['subheading'];
    $template_midSection = $template['midSection'];
    $template_midSectionBg = $template['midSectionBg'];
    $template_bottomSection = $template['bottomSection'];
    $template_mailto = $template['mailto'];
    $template_bottomSectionBg = $template['bottomSectionBg'];
    $template_footer = $template['footer'];
    $builderMode = 'template';

    unset($_SESSION['template']);
} else {

    $template_id = "";
    $template_logoPath = "";
    $template_logoStyles = "";
    $template_pageTitleStyles = "";
    $template_brandName = "";
    $template_bannerPath = "";
    $template_heading = "";
    $template_subheading = "";
    $template_midSection = "";
    $template_midSectionBg = "";
    $template_bottomSection = "";
    $template_mailto = "";
    $template_bottomSectionBg = "";
    $template_footer = "";
}

if (!isset($builderMode)) {
    $builderMode = "create";
}

function camelCaseToKebabCase($property)
{
    return strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $property));
}

if (isset($_GET['error'])) {
    $error_message = urldecode($_GET['error']);
    echo
    "<script>
        document.addEventListener('DOMContentLoaded', function() {
            var errorModal = new bootstrap.Modal(document.getElementById('error_tic'));
            var errorMessage = '" . addslashes($error_message) . "';
            errorModal.show();
        });
    </script>";
    echo
    "<script>
       console.log($error_message);
    </script>";
}
include APP . "view/modal/success-error-modal.php";
?>

<style>
    <?php
    // Check if logo styles are available and valid
    $logoStylesArray = json_decode($update_logoStyles, true);
    if (is_array($logoStylesArray) && !empty($logoStylesArray)) {
        echo ".update-logo-preview {";
        foreach ($logoStylesArray as $property => $value) {
            $cssProperty = camelCaseToKebabCase($property);
            echo "$cssProperty: $value; ";
        }
        echo "}";
    }

    // Check if page title styles are available and valid
    $pageTitleStylesArray = json_decode($update_pageTitleStyles, true);
    if (is_array($pageTitleStylesArray) && !empty($pageTitleStylesArray)) {
        echo ".update-page-title {";
        foreach ($pageTitleStylesArray as $property => $value) {
            $cssProperty = camelCaseToKebabCase($property);
            echo "$cssProperty: $value; ";
        }
        echo "}";
    }
    ?><?php
        // Check if logo styles are available and valid
        $logoStylesArray = json_decode($template_logoStyles, true);
        if (is_array($logoStylesArray) && !empty($logoStylesArray)) {
            echo ".template-logo-preview {";
            foreach ($logoStylesArray as $property => $value) {
                $cssProperty = camelCaseToKebabCase($property);
                echo "$cssProperty: $value; ";
            }
            echo "}";
        }

        // Check if page title styles are available and valid
        $pageTitleStylesArray = json_decode($template_pageTitleStyles, true);
        if (is_array($pageTitleStylesArray) && !empty($pageTitleStylesArray)) {
            echo ".template-page-title {";
            foreach ($pageTitleStylesArray as $property => $value) {
                $cssProperty = camelCaseToKebabCase($property);
                echo "$cssProperty: $value; ";
            }
            echo "}";
        }
        ?>#title-2-drag-drop-area {
        background-image: <?php echo ($template_midSectionBg  != "" ? $template_midSectionBg : ($update_midSectionBg != "" ? $update_midSectionBg : null)); ?>;
        background-size: cover;
    }

    #contact-form-drag-drop-area {
        background-image: <?php echo ($template_bottomSectionBg  != "" ? $template_bottomSectionBg : ($update_bottomSectionBg != "" ? $update_bottomSectionBg : null)); ?>;
        background-size: cover;
    }
</style>


<div class="container-fluid main-container mt-3" style="background: #f2f2f2;">
    <input type="hidden" id="update-id" name="update-id" value="<?php echo $update_id ?>">
    <div class="container-fluid">

        <!-- Landing Pages Modal -->
        <?php include APP . "view/modal/landing-pages.php"; ?>

        <div class="container-fluid builder-container">
            <form id="submit-form">
                <div class="row">
                    <div class="col-12">
                        <div class=" row editor-container-row">
                            <div class="col-2">
                                <img class="me-4" src="<?= $imageFolder ?>three-dots.svg" alt="..." style="width: 35px; height:35px; opacity: .3;">

                            </div>
                            <div class="col-5">
                                <button type="button" class=" d-none btn btn-primary rounded-corners-button-violet landing-pages-button" id="landing-page-list" data-bs-toggle="modal" data-bs-target="#landing-page-list-modal">
                                    Landing Pages
                                </button>
                                <button type="button" class=" d-none btn btn-primary rounded-corners-button-violet page-templates-button" data-bs-toggle="modal" data-bs-target="#page-templates-modal">
                                    Templates
                                </button>
                            </div>
                            <div class="col-5 d-flex justify-content-end align-items-center">
                                <button type="button" class="btn btn-sm btn-primary rounded-corners-button-red d-none" id="resetButton" style="margin-left: 25px;">
                                    Reset
                                </button>

                                <?php if ($update_id != "") {
                                    echo '
                                    <button type="button" id="updateButton" class="btn btn-sm rounded-corners-button-blue save-button d-flex"
                                            onclick="updatePage()" style="margin-right: 15px;">
                                            Update
                                    </button> 
                                    <button type="button" class="btn btn-sm btn-primary circle-button-blue d-none"
                                        onclick="previewUpdate()" id="previewButton" data-bs-toggle="tooltip" data-bs-placement="top" title="Preview">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <div class="loader loader-sm d-none"></div>

                                    ';
                                } else {
                                    echo '
                                    <div class="btn-group dropend save-dropdown">
                                        <button type="button" class="btn btn-sm rounded-corners-button-blue dropdown-toggle me-2" 
                                        data-bs-toggle="dropdown" aria-expanded="false">Save</button>
                                    
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="#" class="dropdown-item" 
                                                   id="submit-page">
                                                    Save as Page
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown-item" onclick="saveAsTemplate(); return false;">
                                                    Save as Template
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="loader loader-sm d-none"></div>
                                    <button type="button" class="btn btn-sm btn-primary circle-button-blue d-none"
                                        onclick="preview()" id="previewButton" data-bs-toggle="tooltip" data-bs-placement="top" title="Preview">
                                        <i class="bi bi-eye"></i>
                                    </button> 
                                    <img class="d-none" src=" ' . $imageFolder . 'switch.svg" alt="..." style="width: 35px; height:35px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Switch Builder">
                                    ';
                                }
                                ?>

                                <div class="btn-group me-2">
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button type="button" class="dropdown-item landing-pages-button" id="landing-page-list" data-bs-toggle="modal" data-bs-target="#landing-page-list-modal">
                                                Landing Pages
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item page-templates-button" data-bs-toggle="modal" data-bs-target="#page-templates-modal">
                                                Templates
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="three-dots-container" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- Page Templates Modal -->
                            <?php include APP . "view/modal/page-templates.php"; ?>
                            <div class="photo-editor-frame text-center mt-3" id="photo-editor-frame" style="height: 600px; width: 100%;">
                                <div class="mb-3">
                                    <div class="container mt-4">
                                        <div class="row image-upload">
                                            <div class="col-12 col-md-4 text-center mb-3">
                                                <label class="form-label font-weight-bold" for="logoFile">Logo upload</label>
                                                <input type="file" accept=".png, .jpg, .jpeg" class="form-control" id="logoFile" name="logoFile" />
                                                <input type="hidden" id="logo_file_id" name="logo_file_id" value="">
                                                <div class="progress-container">
                                                    <div class="progress-bar" id="logoProgressBar"></div>
                                                    <div class="progress-text" id="logoProgressText"></div>
                                                </div>
                                                <div class="file-details">
                                                    <div class="file-name" id="logoFileName"></div>
                                                    <button class="clear-button" id="logoClearButton">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 text-center mb-3">
                                                <label class="form-label font-weight-bold" for="brand">Page Title</label>
                                                <i class="bi bi-info" id="pageTitleInfo" style="color: #ffffff;" data-toggle="tooltip" title="Max 11 characters"></i>
                                                <input type="text" class="form-control" id="brand" name="brand" maxlength="11" value="<?php echo ($template_brandName  != "" ? $template_brandName : ($update_brandName != "" ? $update_brandName : null)); ?>" />
                                            </div>
                                            <div class="col-12 col-md-4 text-center mb-3">
                                                <label class="form-label font-weight-bold" for="bannerFile">Banner upload</label>
                                                <input type="file" accept=".png, .jpg, .jpeg" class="form-control" id="bannerFile" name="bannerFile" />
                                                <input type="hidden" id="banner_file_id" name="banner_file_id" value="">
                                                <div class="progress-container">
                                                    <div class="progress-bar" id="bannerProgressBar"></div>
                                                    <div class="progress-text" id="bannerProgressText"></div>
                                                </div>
                                                <div class="file-details">
                                                    <div class="file-name" id="bannerFileName"></div>
                                                    <button class="clear-button" id="bannerClearButton">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 text-center mt-4">
                                        <h4 class="top-section-title">Top Section</h4>
                                        <div class="btn-container d-flex justify-content-center align-items-center position-relative">
                                            <div class="mb-1 me-3">
                                                <!-- Logo Resize Control Box -->
                                                <div class="logo-resize-container">
                                                    <span class="logo-resize-label">Logo Resize:</span>
                                                    <button type="button" class="logo-resize-btn" id="logoDecreaseBtn"><i class="bi bi-dash-lg"></i></button>
                                                    <button type="button" class="logo-resize-btn" id="logoIncreaseBtn"><i class="bi bi-plus-lg"></i></button>
                                                </div>
                                                <input type="hidden" id="logoStyles" name="logo_styles">
                                            </div>
                                            <div class="mb-1 me-3">
                                                <!-- Page Title Control Box -->
                                                <div class="page-title-edit-container">
                                                    <span class="logo-resize-label">Page Title Toolbar</span>
                                                    <button type="button" class="page-title-toolbar-btn" id="pageTitleBold"><i class="bi bi-type-bold"></i></button>
                                                    <button type="button" class="page-title-toolbar-btn" id="pageTitleUnderline"><i class="bi bi-type-underline"></i></button>
                                                    <button type="button" class="page-title-toolbar-btn" id="pageTitleItalic"><i class="bi bi-type-italic"></i></button>
                                                    <button type="button" class="page-title-toolbar-btn" id="pageTitleFontStyle"><i class="bi bi-fonts"></i></button>
                                                    <button type="button" class="page-title-toolbar-btn" id="pageTitleFontSize"><i class="bi bi-arrows-vertical"></i></button>
                                                    <input type="color" class="page-title-toolbar-btn page-title-text-color" id="pageTitleTextColor" title="Choose text color" />
                                                </div>
                                                <input type="hidden" id="pageTitleStyles" name="page_title_styles">
                                            </div>
                                            <div class="mb-1 me-3">
                                                <button type="button" class="btn btn-sm btn-primary ai-btn rounded-corners-button-violet" data-bs-toggle="modal" data-bs-target="#AI-modal">
                                                    <div class="d-flex justify-content-center">
                                                        <img class="icon" src="<?= $imageFolder ?>invention-icon.svg" alt="...">
                                                        <span>AI</span>
                                                    </div>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-primary ai-btn rounded-corners-button-green" id="add-heading">
                                                    Add Heading
                                                </button>
                                                <!-- <button type="button" class="btn btn-sm btn-primary ai-btn rounded-corners-button-green" id="add-sub-heading">
                                                    Add Subheading
                                                </button> -->

                                                <!-- Admage Generator Modal -->
                                                <?php include APP . "view/modal/ai-image-generator.php"; ?>
                                            </div>
                                            <div class="position-absolute end-0 mb-1">
                                                <button type="button" class="btn btn-sm btn-primary top-section-switch-btn no-bg">
                                                    <div class="d-flex justify-content-center">
                                                        <img class="icon" src="<?= $imageFolder ?>switch.svg" alt="..." id="switchButton" data-bs-toggle="tooltip" title="Switch between photo editor and top section mode">
                                                    </div>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="container mb-5 d-none" id="photo-editor-iframe-container" style="--aspect-ratio: 16/9;">
                                    <iframe class="" id="photo-editor-iframe" src="<?= URL ?>photo-editor/index.html" frameborder="0">
                                    </iframe>
                                </div>
                                <div class="container mb-5" id="top-section-container">
                                    <?php if ($update_id != "") { ?>
                                        <div class="p-5 text-center hero-placeholder mt-2 mb-1" style="
                                                        background-image: url('<?php echo URL; ?>file/builder-uploads/<?php echo $update_bannerPath; ?>');
                                                        ;
                                                    ">
                                            <nav class="navbar mt-5">
                                                <div class="container d-flex justify-content-center align-items-center">
                                                    <!-- <ul>
                                                        <li><a>Home</a></li>
                                                    </ul> -->
                                                    <a class="logo-placeholder d-flex justify-content-center align-items-center">
                                                        <img class="update-logo-preview" id="previewLogoImage" src="<?php echo URL; ?>file/builder-uploads/<?php echo $update_logoPath; ?>">
                                                    </a>
                                                    <!-- <ul>
                                                        <li><a>Contact</a></li>
                                                    </ul> -->
                                                </div>
                                            </nav>
                                            <div class="page-title-container mt-1">
                                                <span class="page-title-placeholder update-page-title"><?php echo $update_brandName; ?></span>
                                            </div>
                                            <div class="headings-container">
                                                <div class="mb-2" id="heading-drop-area" ondrop="handleDrop(event)" ondragover="allowDrop(event)">
                                                    <?php echo $update_heading ?>
                                                </div>
                                            </div>
                                            <input type="hidden" name="top_section_content" id="top_section_content">
                                        </div>
                                    <?php } else if ($template_id != "") { ?>
                                        <input type="hidden" name="template-banner" value="<?php echo $template_bannerPath; ?>">
                                        <div class="p-5 text-center hero-placeholder mt-2 mb-1" style="
                                                        background-image: url('<?php echo URL; ?>file/template-uploads/<?php echo $template_bannerPath; ?>');
                                                        ;
                                                    ">
                                            <nav class="navbar mt-5">
                                                <div class="container d-flex justify-content-center align-items-center">
                                                    <!-- <ul>
                                                        <li><a>Home</a></li>
                                                    </ul> -->
                                                    <a class="logo-placeholder d-flex justify-content-center align-items-center">
                                                        <img class="template-logo-preview" id="previewLogoImage" src="<?php echo URL; ?>file/template-uploads/<?php echo $template_logoPath; ?>">
                                                        <input type="hidden" name="template-logo" value="<?php echo $template_logoPath; ?>">
                                                    </a>
                                                    <!-- <ul>
                                                        <li><a>Contact</a></li>
                                                    </ul> -->
                                                </div>
                                            </nav>
                                            <div class="page-title-container mt-1">
                                                <span class="page-title-placeholder template-page-title"><?php echo $template_brandName; ?></span>
                                            </div>
                                            <div class="headings-container">
                                                <div class="mb-2" id="heading-drop-area" ondrop="handleDrop(event)" ondragover="allowDrop(event)">
                                                    <?php echo $template_heading ?>
                                                </div>
                                                <!-- <div class="" id="sub-heading-drop-area" ondrop="handleDrop(event)" ondragover="allowDrop(event)">
                                                    <?php //echo $template_subheading; 
                                                    ?>
                                                </div> -->
                                            </div>
                                            <input type="hidden" name="top_section_content" id="top_section_content">
                                        </div>

                                    <?php } else { ?>

                                        <div class="p-5 text-center hero-placeholder mt-2 mb-1" style="
                                                        background-image: url('<?= $imageFolder ?>default-bg.webp');
                                                        ;
                                                    ">
                                            <nav class="navbar mt-5">
                                                <div class="container d-flex justify-content-center align-items-center">
                                                    <!-- <ul>
                                                        <li><a>Home</a></li>
                                                    </ul> -->
                                                    <a class="logo-placeholder d-flex justify-content-center align-items-center">
                                                        <img id="previewLogoImage" src="<?= $imageFolder ?>photo.jpg" style=" width: 75px !important; border-radius: 50%;">
                                                        <!-- <span class="page-title-placeholder">Page Title</span> -->
                                                    </a>
                                                    <!-- <ul>
                                                        <li><a>Contact</a></li>
                                                    </ul> -->
                                                </div>
                                            </nav>
                                            <div class="page-title-container mt-1">
                                                <span class="page-title-placeholder">Page Title</span>
                                            </div>
                                            <div class="headings-container mt-3">
                                                <div class="placeholder placeholder-wave bg-secondary mb-2" id="heading-drop-area">
                                                    <h1 style="opacity: 0.6;">Heading</h1>
                                                </div>
                                                <!-- <div class="placeholder placeholder-wave bg-secondary" id="sub-heading-drop-area" ondrop="handleDrop(event)" ondragover="allowDrop(event)">
                                                    <p style="opacity: 0.6;">Subheading</p>
                                                </div> -->
                                            </div>
                                            <input type="hidden" name="top_section_content" id="top_section_content">
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="title-2 mt-5" id="title-2">
                                <div class="row">
                                    <div class="col-12 mb-2 mt-5">
                                        <h4 class="mt-5">Mid Section</h4>
                                        <div class="mt-4 mb-3">
                                            <div class="row image-upload">
                                                <div class="col-12 col-md-6 mb-3 d-flex flex-column align-items-center">
                                                    <label class="form-label font-weight-bold" for="midSecBackgroundFile">Background Image</label>
                                                    <input type="file" accept=".png, .jpg, .jpeg, .svg" class="form-control w-100" id="midSecBackgroundFile" name="midSecBackgroundFile" />
                                                    <input type="hidden" id="midsec_bg_file_id" name="midsec_bg_file_id" value="">
                                                    <div class="progress-container">
                                                        <div class="progress-bar" id="midSecProgressBar"></div>
                                                        <div class="progress-text" id="midSecProgressText"></div>
                                                    </div>
                                                    <div class="file-details">
                                                        <div class="file-name" id="midSecFileName"></div>
                                                        <button class="clear-button" id="midSecClearButton">
                                                            <i class="bi bi-x-circle"></i>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" id="selectedImage" name="selectedImage">
                                                    <!-- Image Gallery Modal -->
                                                    <?php include APP . "view/modal/image-gallery.php"; ?>
                                                </div>
                                            </div>
                                            <input type="hidden" name="mid_bg_industry" id="mid_bg_industry">
                                            <input type="hidden" name="mid_bg_color_gradient" id="mid_bg_color_gradient">
                                            <input type="hidden" name="mid_bg_abstract" id="mid_bg_abstract">
                                        </div>
                                        <button type="button" class="btn btn-sm btn-primary rounded-corners-button-green mid-section-edit-button" id="add-product-highlights-button" data-toggle="tooltip" data-placement="top" title="Add Product Highlights">
                                            Add Product Highlights
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary rounded-corners-button-green mid-section-edit-button" id="edit-button" data-bs-toggle="modal" data-bs-target="#ckeditor-modal" data-toggle="tooltip" data-placement="top" title="Edit the Mid Section">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary rounded-corners-button-violet image-gallery-btn" data-bs-toggle="modal" data-bs-target="#midImageModal">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="16" height="16">
                                                    <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                    <path fill="#ffffff" d="M160 80H512c8.8 0 16 7.2 16 16V320c0 8.8-7.2 16-16 16H490.8L388.1 178.9c-4.4-6.8-12-10.9-20.1-10.9s-15.7 4.1-20.1 10.9l-52.2 79.8-12.4-16.9c-4.5-6.2-11.7-9.8-19.4-9.8s-14.8 3.6-19.4 9.8L175.6 336H160c-8.8 0-16-7.2-16-16V96c0-8.8 7.2-16 16-16zM96 96V320c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H160c-35.3 0-64 28.7-64 64zM48 120c0-13.3-10.7-24-24-24S0 106.7 0 120V344c0 75.1 60.9 136 136 136H456c13.3 0 24-10.7 24-24s-10.7-24-24-24H136c-48.6 0-88-39.4-88-88V120zm208 24a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z" />
                                                </svg>
                                                <span class="ms-1"> Image Gallery</span>
                                            </div>
                                        </button>
                                    </div>

                                    <div class="container" id="title-2-drag-drop-area" ondrop="handleDrop(event)" ondragover="allowDrop(event)">
                                        <?php echo ($template_id != "" ? $template_midSection : ($update_id != "" ? $update_midSection : null)); ?>
                                    </div>
                                    <input type="hidden" name="mid_section_content" id="mid_section_content">
                                </div>
                                <!-- CK-Editor 5 Modal -->
                                <?php include APP . "view/modal/ck-editor.php"; ?>
                            </div>

                            <div class="bottom-section" id="bottom-section">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <h4>Bottom Section</h4>
                                        <div class="container mt-4 mb-3">
                                            <div class="row image-upload">
                                                <div class="col-12 col-md-6 mb-3 d-flex flex-column align-items-center">
                                                    <label class="form-label font-weight-bold" for="bottomsecBackgroundFile">Background Image</label>
                                                    <input type="file" accept=".png, .jpg, .jpeg, .svg" class="form-control w-100" id="bottomsecBackgroundFile" name="bottomsecBackgroundFile" />
                                                    <input type="hidden" id="bottomsec_bg_file_id" name="bottomsec_bg_file_id" value="">
                                                    <div class="progress-container">
                                                        <div class="progress-bar" id="bottomsecProgressBar"></div>
                                                        <div class="progress-text" id="bottomsecProgressText"></div>
                                                    </div>
                                                    <div class="file-details">
                                                        <div class="file-name" id="bottomsecFileName"></div>
                                                        <button class="clear-button" id="bottomsecClearButton">
                                                            <i class="bi bi-x-circle"></i>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" id="selectedImage" name="selectedImage">
                                                    <!-- Image Gallery Modal -->
                                                    <?php include APP . "view/modal/image-gallery.php"; ?>
                                                </div>
                                                <div class="col-12 col-md-6 mb-3 d-flex flex-column align-items-center">
                                                    <label class="form-label font-weight-bold" for="mailto">Mailto</label>
                                                    <input type="text" class="form-control w-100" id="mailto" name="mailto" placeholder="Enter email addresses" value="<?php echo ($template_mailto != "" ? $template_mailto : ($update_mailto != "" ? $update_mailto : null)); ?>" multiple data-bs-toggle="tooltip" data-bs-placement="top" title="Separate multiple email addresses with commas ','" required />
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-primary rounded-corners-button-violet image-gallery-btn" data-bs-toggle="modal" data-bs-target="#imageModal">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="16" height="16">
                                                    <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                    <path fill="#ffffff" d="M160 80H512c8.8 0 16 7.2 16 16V320c0 8.8-7.2 16-16 16H490.8L388.1 178.9c-4.4-6.8-12-10.9-20.1-10.9s-15.7 4.1-20.1 10.9l-52.2 79.8-12.4-16.9c-4.5-6.2-11.7-9.8-19.4-9.8s-14.8 3.6-19.4 9.8L175.6 336H160c-8.8 0-16-7.2-16-16V96c0-8.8 7.2-16 16-16zM96 96V320c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H160c-35.3 0-64 28.7-64 64zM48 120c0-13.3-10.7-24-24-24S0 106.7 0 120V344c0 75.1 60.9 136 136 136H456c13.3 0 24-10.7 24-24s-10.7-24-24-24H136c-48.6 0-88-39.4-88-88V120zm208 24a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z" />
                                                </svg>
                                                <span class="ms-1"> Image Gallery</span>
                                            </div>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary rounded-corners-button-green" id="add-signup-form">
                                            Add Signup Form
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary rounded-corners-button-green" id="add-contact-form">
                                            Add Contact Form
                                        </button>
                                    </div>
                                    <!-- Bottom Section Options Modal -->
                                    <?php include APP . "view/modal/bottom-section-options.php"; ?>
                                    <!-- Text Field Modal -->
                                    <?php include APP . "view/modal/fields.php"; ?>
                                    <div id="contact-form-drag-drop-area" ondrop="handleDrop(event)" ondragover="allowDrop(event)">
                                        <!-- Dropped content will be placed here -->
                                        <?php echo ($template_id != "" ? $template_bottomSection : ($update_id != "" ? $update_bottomSection : null)); ?>

                                    </div>
                                    <input type="hidden" name="bottom_section_content" id="bottom_section_content">
                                    <input type="hidden" name="bottom_section_id" id="bottom_section_id">
                                    <input type="hidden" name="bottom_bg_industry" id="bottom_bg_industry">
                                    <input type="hidden" name="bottom_bg_color_gradient" id="bottom_bg_color_gradient">
                                    <input type="hidden" name="bottom_bg_abstract" id="bottom_bg_abstract">
                                </div>
                            </div>
                            <div class="footer-container" id="footer-container" style="display: none;">
                                <div class="row">
                                    <?php if ($update_id != "") { ?>
                                        <?php echo $update_footer; ?>
                                    <?php } else if ($template_id != "") { ?>
                                        <?php echo $template_footer; ?>
                                    <?php } else { ?>
                                        <h4>Footer</h4>
                                        <div class="footer-color-input d-flex align-items-center justify-content-end">
                                            <!-- <label for="footer-background" class="form-label me-2 mb-0">Background</label>
                                            <input type="color" class="form-control form-control-color me-3" id="footer-background" data-target="footer">
                                            <label for="footer-text" class="form-label me-2 mb-0">Text</label>
                                            <input type="color" class="form-control form-control-color" id="footer-text"
                                                data-targets="footer-content,
                                                                footer-page-title"> -->
                                            <div class="footer-toolbar-container">
                                                <span class="footer-toolbar-label">Footer Toolbar:</span>
                                                <label for="footer-background">BG</label>
                                                <input type="color" class="footer-toolbar-btn" id="footer-background" data-target="footer">
                                                <label for="footer-text">T</label>
                                                <input type="color" class="footer-toolbar-btn" id="footer-text" data-targets="footer-content,
                                            footer-page-title">
                                            </div>
                                        </div>
                                        <div class="footer" id="footer">
                                            <div class="footer-content" id="footer-content">
                                                <div class="row justify-content-center align-items-center text-center">
                                                    <a class="footer-logo-placeholder text-decoration-none d-flex flex-column flex-sm-row align-items-center justify-content-center justify-content-md-start">
                                                        <img src="<?= $imageFolder ?>photo.jpg" class="me-3 mb-2 mb-sm-0" style="width: 80px; border-radius: 50%;">
                                                        <!-- <h4 class="footer-page-title-placeholder text-nowrap h4-responsive m-0" id="footer-page-title">Page Title</h4> -->
                                                    </a>
                                                </div>
                                                <div class="row row-2 mt-3 text-center text-md-start">
                                                    <div class="col-12 col-md-4 mb-3 mb-md-0">
                                                        <span>Write Something</span>
                                                        <p id="footer-text-1" contenteditable="true" placeholder="Type here"></p>
                                                    </div>
                                                    <div class="col-12 col-md-4 mb-3 mb-md-0">
                                                        <span>Enter Email</span>
                                                        <p id="footer-email" class="footer-email" contenteditable="true"></p>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <span>Enter Address</span>
                                                        <p id="footer-address" contenteditable="true"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <input type="hidden" name="footer_content" id="footer_content">
                        </div>
                    </div>
                    <div class="col-3" style="display: none;">
                        <div class="right-panel-container">
                            <div class="row mt-3">
                                <div class="col-12">
                                    <button type="button" class="btn btn-sm btn-primary circle-button-gray">
                                        <i class="bi bi-plus-circle-fill"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary circle-button-gray">
                                        <i class="bi bi-gear"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary circle-button-gray">
                                        <i class="bi bi-share"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary circle-button-gray">
                                        <i class="bi bi-patch-question-fill"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary circle-button-gray">
                                        <i class="bi bi-palette"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row text-row mt-2">
                                <div class="col">
                                    <div class="header-text mb-3">Widgets</div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <div class="draggable product-hightlights" id="product-highlights" draggable="true" ondragstart="drag(event)">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="icon" src="<?= $imageFolder ?>list-check.svg" alt="...">
                                                    <span class="text-truncate">Product Highlights</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="promo-offer" id="promo-offer" draggable="false" ondragstart="drag(event)" style="opacity: 0.5;">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="icon" src="<?= $imageFolder ?>ticket.svg" alt="...">
                                                    <span class="text-truncate">Promo Offer</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row signup-contact-form-button-row">
                                        <div class="col-6">
                                            <div class="draggable signup-form" id="signup-form" draggable="true" ondragstart="drag(event)">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="icon" src="<?= $imageFolder ?>registration-icon.svg" alt="...">
                                                    <span class="text-truncate">Sign-up Form</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="draggable contact-form" id="contact-form" draggable="true" ondragstart="drag(event)">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="icon" src="<?= $imageFolder ?>person-lines-fill.svg" alt="...">
                                                    <span class="text-truncate">Contact Form</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-row mt-4">
                                <div class="col">
                                    <div class="header-text mb-3">Text</div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <div id="heading" class="draggable subheading" draggable="true" ondragstart="drag(event)">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="icon" src="<?= $imageFolder ?>h1.svg" alt="...">
                                                    <span class="text-truncate">Heading</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div id="sub-heading" class="draggable sub-heading" draggable="true" ondragstart="drag(event)">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="icon" src="<?= $imageFolder ?>h2.svg" alt="...">
                                                    <span class="text-truncate">Sub Heading</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <div id="title" class="draggable title" draggable="false" ondragstart="drag(event)" style="opacity: 0.5;">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="icon" src="<?= $imageFolder ?>text.png" alt="...">
                                                    <span class="text-truncate">Title</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div id="body-text" class="draggable body-text" draggable="false" ondragstart="drag(event)" style="opacity: 0.5;">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="icon" src="<?= $imageFolder ?>justify.png" alt="...">
                                                    <span class="text-truncate">Body Text</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="" style="opacity: 0.5;">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="icon" src="<?= $imageFolder ?>design.png" alt="...">
                                                    <span class="text-truncate">Design</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="" style="opacity: 0.5;">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="icon" src="<?= $imageFolder ?>resize.png" alt="...">
                                                    <span class="text-truncate">Canvas</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-row mt-4">
                                <div class="col">
                                    <div class="header-text mb-3">Image and Videos</div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <div class="" style="opacity: 0.5;">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="icon" src="<?= $imageFolder ?>gallery.png" alt="...">
                                                    <span class="text-truncate">Image</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="" style="opacity: 0.5;">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="icon" src="<?= $imageFolder ?>video.png" alt="...">
                                                    <span class="text-truncate">GIF</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="" style="opacity: 0.5;">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="icon" src="<?= $imageFolder ?>streaming.png" alt="...">
                                                    <span class="text-truncate">Video</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="" style="opacity: 0.5;">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="icon" src="<?= $imageFolder ?>sound.png" alt="...">
                                                    <span class="text-truncate">Music</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-row mt-4">
                                <div class="col">
                                    <div class="header-text mb-3">Fields</div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <!-- <div id="text-field" class="draggable" draggable="true" ondragstart="drag(event)">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="fields-icon" src="<?= $imageFolder ?>text-field.png" alt="...">
                                                    <span class="text-truncate">Text Field</span>
                                                </a>
                                            </div> -->
                                            <div id="text-field" style="opacity: 0.5;">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="fields-icon" src="<?= $imageFolder ?>text-field.png" alt="...">
                                                    <span class="text-truncate">Text Field</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div id="select-field" style="opacity: 0.5;">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="fields-icon1" src="<?= $imageFolder ?>select-field.png" alt="...">
                                                    <span class="text-truncate">Select Field</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="" style="opacity: 0.5;">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="fields-icon1" src="<?= $imageFolder ?>crm-field.png" alt="...">
                                                    <span class="text-truncate">CRM Field</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="" style="opacity: 0.5;">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="fields-icon1" src="<?= $imageFolder ?>hidden-field.png" alt="...">
                                                    <span class="text-truncate">Hidden Field</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-row mt-4">
                                <div class="col">
                                    <div class="header-text mb-3">Share to Refer</div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <div class="" style="opacity: 0.5;">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="icon" src="<?= $imageFolder ?>link.png" alt="...">
                                                    <span class="text-truncate">Referral Link</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="" style="opacity: 0.5;">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="icon" src="<?= $imageFolder ?>share.png" alt="...">
                                                    <span class="text-truncate">Share Button</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-row mt-2">
                                <div class="col">
                                    <div class="header-text mb-3">Responsive</div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <div class="" style="opacity: 0.5;">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="icon" src="<?= $imageFolder ?>device.png" alt="...">
                                                    <span class="text-truncate">Mobile/Tablet</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="" style="opacity: 0.5;">
                                                <a class="btn btn-secondary btn-lg btn-light" type="button">
                                                    <img class="icon" src="<?= $imageFolder ?>laptop.png" alt="...">
                                                    <span class="text-truncate">Laptop/PC</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>