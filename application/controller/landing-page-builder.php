<?php

class LandingPageBuilder extends Controller
{
    public function __construct($urlDetails)
    {
        parent::__construct($urlDetails);
    }

    public function index()
    {
        $breadcrumb = [
            [
                'label' => 'Landing Page Builder',
                'active' => true,
                'icon' => '<i class="bi bi-file-earmark"></i>'
            ]
        ];

        $pluginCSS = [];
        $pluginCSS = array_merge($pluginCSS, sysPlugins('datatable')['css']);
        $pluginCSS = array_merge($pluginCSS, sysPlugins('lightbox')['css']);
        $pluginCSS = array_merge($pluginCSS, sysPlugins('grapick')['css']);
        $pluginCSS = array_merge($pluginCSS, sysPlugins('grid-gallery')['css']);


        $pluginJS = [];
        $pluginJS = array_merge($pluginJS, sysPlugins('datatable')['js']);
        $pluginJS = array_merge($pluginJS, sysPlugins('lightbox')['js']);
        $pluginJS = array_merge($pluginJS, sysPlugins('grapick')['js']);
        $pluginJS = array_merge($pluginJS, sysPlugins('grid-gallery')['js']);
        $pluginJS = array_merge($pluginJS, sysPlugins('sweet-alert')['js']);
        $pluginJS = array_merge($pluginJS, sysPlugins('image-compressor')['js']);
        $pluginJS = array_merge($pluginJS, sysPlugins('axios')['js']);


        $customCSS = [
            'styles.min',
            'search-bar',
            'generated-lps',
            'builder',
            'template-builder',
            'top-section',
            'contact-form-drop-area',
            'title-2-drop-area',
            'search-bar',
            'image-gallery'
        ];

        $customJS = [
            'introjs',
            'add-widgets',
            'sidebarmenu',
            'simplebar',
            'bottom-section',
            'upload-img',
            'dall-e',
            'drag-drop',
            'texts',
            'fields',
            'widgets',
            'edit-button',
            'builder-submit',
            'landing-pages',
            'clipboard',
            'tooltip',
            'drag-drop-autoscroll',
            'progress-bar',
            'delete-preview',
            'image-gallery',
            'top-section',
            'deleted-landing-pages',
            'templates',
            'global-functions'
        ];

        require APP . "view/_templates/header.php";
        require APP . "view/landing-page-builder/index.php";
        require APP . "view/_templates/footer.php";
    }

    public function save()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            header('Content-Type: application/json');

            // error_log("Received POST request."); // Log request start
            // error_log("POST Data: " . print_r($_POST, true));
            // error_log("FILES Data: " . print_r($_FILES, true));

            // Phase 1: Handle file chunk uploads
            if (isset($_FILES['chunk'])) {
                $tmpUploadPath = "file/tmp/chunks/";
                $builderUploadPath = "file/builder-uploads/";
                $contactUploadPath = "file/contact-uploads/";

                $fieldName = $_POST['fieldName'] ?? '';
                $chunkIndex = $_POST['chunkIndex'] ?? '';
                $totalChunks = $_POST['totalChunks'] ?? '';

                if (!$fieldName || $chunkIndex === '' || !$totalChunks) {
                    error_log("Invalid chunk upload parameters.");
                    echo json_encode(['success' => false, 'error' => 'Invalid chunk upload parameters.']);
                    exit();
                }

                // Temporary chunk file name
                $chunkFileName = $tmpUploadPath . $fieldName . "_chunk_" . $chunkIndex;

                if (!move_uploaded_file($_FILES['chunk']['tmp_name'], $chunkFileName)) {
                    error_log("Failed to move uploaded chunk: $chunkFileName");
                    echo json_encode(['success' => false, 'error' => 'Failed to save file chunk.']);
                    exit();
                }

                // Assemble the file if all chunks are uploaded
                if ($chunkIndex + 1 == $totalChunks) {
                    error_log("All chunks received for field: $fieldName");

                    // Determine final directory based on fieldName
                    $uploadPath = in_array($fieldName, ['logoFile', 'bannerFile'])
                        ? $builderUploadPath
                        : $contactUploadPath;

                    $assembledFilePath = $uploadPath . $fieldName;
                    $fileHandle = fopen($assembledFilePath, 'wb');

                    for ($i = 0; $i < $totalChunks; $i++) {
                        $chunkPath = $tmpUploadPath . $fieldName . "_chunk_" . $i;
                        fwrite($fileHandle, file_get_contents($chunkPath));
                        unlink($chunkPath); // Remove individual chunks after assembly
                    }
                    fclose($fileHandle);

                    // Generate a unique name for the file
                    $uniqueFileName = $this->generateUniqueName($fieldName);

                    // Compress and move the assembled file
                    $compressedFilePath = $this->compressAndMoveImage($assembledFilePath, $uploadPath . $uniqueFileName);

                    // Remove the uncompressed assembled file
                    if (file_exists($assembledFilePath)) {
                        unlink($assembledFilePath);
                    }

                    // Store the unique file name temporarily in session
                    $_SESSION['uploadedFiles'][$fieldName] = $uniqueFileName;
                    error_log("File assembled and stored in session: $fieldName -> $uniqueFileName");

                    // Close session to avoid locking issues
                    session_write_close();

                    echo json_encode([
                        'success' => true,
                        'filePath' => $compressedFilePath,
                        'uniqueFileName' => $uniqueFileName
                    ]);
                    exit();
                }

                echo json_encode(['success' => true]);
                exit();
            }

            // Phase 2: Handle non-file fields and image processing
            error_log("Starting Phase 2: Processing non-file fields");

            $brand = $_POST["brand"] ?? '';
            if (empty($brand)) {
                error_log("Missing required field: brand (Page title)");
                echo json_encode(['error' => 'Page title is required.']);
                exit();
            }

            $mailto = $_POST["mailto"] ?? '';
            if (empty($mailto)) {
                error_log("Missing required field: mailto");
                echo json_encode(['error' => 'Mailto address is required.']);
                exit();
            }

            // Retrieve file names from session
            error_log("Session Data: " . print_r($_SESSION, true));

            $logoFileName = $_SESSION['uploadedFiles']['logoFile'] ?? '';
            $bannerFileName = $_SESSION['uploadedFiles']['bannerFile'] ?? '';
            $midSectionBackgroundFileName = $_SESSION['uploadedFiles']['midSecBackgroundFile'] ?? '';
            $bottomSectionBackgroundFileName = $_SESSION['uploadedFiles']['bottomSecBackgroundFile'] ?? '';

            error_log("Retrieved filenames from session - Logo: $logoFileName, Banner: $bannerFileName, MidSec: $midSectionBackgroundFileName, BottomSec: $bottomSectionBackgroundFileName");

            $midSectionBg = $this->processBackground(
                $midSectionBackgroundFileName,
                $_POST["mid_bg_color_gradient"] ?? '',
                $_POST["mid_bg_abstract"] ?? '',
                $_POST["mid_bg_industry"] ?? ''
            );
            $bottomSectionBg = $this->processBackground(
                $bottomSectionBackgroundFileName,
                $_POST["bottom_bg_color_gradient"] ?? '',
                $_POST["bottom_bg_abstract"] ?? '',
                $_POST["bottom_bg_industry"] ?? ''
            );

            error_log("Background processing complete - Mid: $midSectionBg, Bottom: $bottomSectionBg");

            // Validate bottom section
            $bottomSectionId = $_POST["bottom_section_id"] ?? '';
            if (!$bottomSectionId) {
                error_log("Missing required field: bottom_section_id");
                echo json_encode(['error' => 'Please drop either "Signup" or "Vendor" widget in the Bottom Section.']);
                exit();
            }

            // Additional form processing
            $landingPageBuilderModel = new LandingPageBuilderModel();
            error_log("Calling save() in LandingPageBuilderModel");

            $result = $landingPageBuilderModel->save(
                $logoFileName,
                $_POST["logo_styles"] ?? '',
                $brand,
                $_POST["page_title_styles"] ?? '',
                $bannerFileName,
                $_POST["top_section_content"] ?? '',
                $_POST["mid_section_content"] ?? '',
                $midSectionBg,
                $_POST["bottom_section_content"] ?? '',
                $mailto,
                $bottomSectionBg,
                $bottomSectionId,
                $_POST["footer_content"] ?? '',
                0 // isDeleted
            );

            if ($result) {
                $insertedId = $result;
                $encodedId = base64_encode($insertedId);
                $encodedBottomSectionId = base64_encode($bottomSectionId);

                $landingPageLink = URL . 'landing-page-builder/visit?id=' . $encodedId . '&bottomSectionId=' . $encodedBottomSectionId;
                $landingPageBuilderModel->updateLandingPageLink($insertedId, $bottomSectionId, $landingPageLink);

                error_log("Landing page successfully saved: $insertedId");

                echo json_encode([
                    'success' => true,
                    'redirect' => URL . 'landing-page-builder/successPage?id=' . $encodedId . '&bottomSectionId=' . $encodedBottomSectionId,
                ]);
            } else {
                error_log("Error occurred while saving the page.");
                echo json_encode(['error' => 'Error occurred while saving the page.']);
            }
        } else {
            error_log("Invalid request method.");
            echo json_encode(['error' => 'Invalid request method.']);
        }
    }

    // Save as template
    public function saveAsTemplate()
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Phase 1: Handle chunked file uploads
                if (isset($_FILES['chunk'])) {
                    $tmpUploadPath = "file/tmp/chunks/";
                    $templateUploadPath = "file/template-uploads/";
                    $contactUploadPath = "file/contact-uploads/";

                    $fieldName = $_POST['fieldName'] ?? '';
                    $chunkIndex = $_POST['chunkIndex'] ?? '';
                    $totalChunks = $_POST['totalChunks'] ?? '';

                    if (!$fieldName || $chunkIndex === '' || !$totalChunks) {
                        echo json_encode(['success' => false, 'error' => 'Invalid chunk upload parameters.']);
                        exit();
                    }

                    // Temporary chunk file name
                    $chunkFileName = $tmpUploadPath . $fieldName . "_chunk_" . $chunkIndex;

                    if (!move_uploaded_file($_FILES['chunk']['tmp_name'], $chunkFileName)) {
                        echo json_encode(['success' => false, 'error' => 'Failed to save file chunk.']);
                        exit();
                    }

                    // Assemble the file if all chunks are uploaded
                    if ($chunkIndex + 1 == $totalChunks) {
                        $uploadPath = in_array($fieldName, ['logoFile', 'bannerFile'])
                            ? $templateUploadPath
                            : $contactUploadPath;

                        $assembledFilePath = $uploadPath . $fieldName;
                        $fileHandle = fopen($assembledFilePath, 'wb');

                        for ($i = 0; $i < $totalChunks; $i++) {
                            $chunkPath = $tmpUploadPath . $fieldName . "_chunk_" . $i;
                            fwrite($fileHandle, file_get_contents($chunkPath));
                            unlink($chunkPath); // Remove individual chunks
                        }
                        fclose($fileHandle);

                        // Generate a unique name for the file
                        $uniqueFileName = $this->generateUniqueName($fieldName);

                        // Compress and move the assembled file
                        $compressedFilePath = $this->compressAndMoveImage($assembledFilePath, $uploadPath . $uniqueFileName);

                        // Remove the uncompressed assembled file
                        if (file_exists($assembledFilePath)) {
                            unlink($assembledFilePath);
                        }

                        // Store the unique file name in session
                        $_SESSION['uploadedFiles'][$fieldName] = $uniqueFileName;

                        session_write_close();

                        echo json_encode([
                            'success' => true,
                            'filePath' => $compressedFilePath,
                            'uniqueFileName' => $uniqueFileName
                        ]);
                        exit();
                    }

                    echo json_encode(['success' => true]);
                    exit();
                }

                // Phase 2: Process non-file form fields
                $brand = $_POST["brandName"] ?? '';
                if (empty($brand)) {
                    echo json_encode(['error' => 'Page title is required.']);
                    exit();
                }

                $mailto = $_POST["mailto"] ?? '';
                if (empty($mailto)) {
                    echo json_encode(['error' => 'Mailto address is required.']);
                    exit();
                }

                $logoFileName = $_SESSION['uploadedFiles']['logoFile'] ?? '';
                $bannerFileName = $_SESSION['uploadedFiles']['bannerFile'] ?? '';
                $midSectionBackgroundFileName = $_SESSION['uploadedFiles']['midSecFile'] ?? '';
                $bottomSectionBackgroundFileName = $_SESSION['uploadedFiles']['bottomSecFile'] ?? '';

                $midSectionBg = $this->processBackground(
                    $midSectionBackgroundFileName,
                    $_POST["mid_bg_color_gradient"] ?? '',
                    $_POST["mid_bg_abstract"] ?? '',
                    $_POST["mid_bg_industry"] ?? ''
                );

                $bottomSectionBg = $this->processBackground(
                    $bottomSectionBackgroundFileName,
                    $_POST["bottom_bg_color_gradient"] ?? '',
                    $_POST["bottom_bg_abstract"] ?? '',
                    $_POST["bottom_bg_industry"] ?? ''
                );

                // Validate bottom section ID
                $bottomSectionId = $_POST["bottomSectionIdConfirmed"] ?? '';
                if (!$bottomSectionId) {
                    echo json_encode(['error' => 'Please drop either "Signup" or "Vendor" widget in the Bottom Section.']);
                    exit();
                }


                // Save the template
                $landingPageBuilderModel = new LandingPageBuilderModel();
                $result = $landingPageBuilderModel->saveAsTemplate(
                    $logoFileName,
                    $_POST["logoStyles"] ?? '',
                    $brand,
                    $_POST["pageTitleStyles"] ?? '',
                    $bannerFileName,
                    $_POST["topSectionContent"] ?? '',
                    $_POST["midSectionContent"] ?? '',
                    $midSectionBg,
                    $_POST["bottomSectionContent"] ?? '',
                    $mailto,
                    $bottomSectionBg,
                    $bottomSectionId,
                    $_POST["footer_content"] ?? '',
                    0 // isDeleted
                );

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Template saved successfully']);
                } else {
                    echo json_encode(['error' => 'Error occurred while saving the template.']);
                }
            } else {
                echo json_encode(['error' => 'Invalid request method.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // visit page
    public function visit()
    {
        // Decode base64 encoded parameters
        $id = isset($_GET['id']) ? base64_decode($_GET['id']) : null;
        $bottomSectionId = isset($_GET['bottomSectionId']) ? base64_decode($_GET['bottomSectionId']) : null;

        $landingPageBuilderModel = new LandingPageBuilderModel();

        $result = $landingPageBuilderModel->visit($id, $bottomSectionId);

        if ($result) { // from model
            $landingPageId = $result->id;
            $logoPath = $result->logo_path;
            $logoStyles = $result->logo_styles;
            $brand = $result->brand_name;
            $pageTitleStyles = $result->page_title_styles;
            $bannerPath = $result->banner_path;
            $topSectionContent = $result->top_section_content;
            $midSectionContent = $result->mid_section_content;
            $midSectionBg = strpos($result->mid_section_bg, 'gradient') !== false ?
                $result->mid_section_bg :
                "url('" . str_replace('compressed/', '', $result->mid_section_bg) . "')";
            $bottomSectionContent = $result->bottom_section_content;
            $footerContent = $result->footer_content;
            $landingPageLink = $result->landing_page_link;
            $mailto = $result->mailto;
            $bottomSectionBg = strpos($result->bottom_section_bg, 'gradient') !== false ?
                $result->bottom_section_bg :
                "url('" . str_replace('compressed/', '', $result->bottom_section_bg) . "')";
            $templateTable = $result->bottom_section_id;

            require(APP . "view/_templates/landing-page/" .
                ($templateTable === "contact-form-div" ? "vendor-intro.php" : ($templateTable === "signup-form-div" ? "signup.php" : "")));
        } else {
            echo "Landing page not found!";
        }
    }

    // get all pages
    public function getLandingPages()
    {
        $response = array();

        $landingPageBuilderModel = new LandingPageBuilderModel();

        $sqlVendor = "SELECT * FROM vendor_pages WHERE is_deleted = 0";
        $responseVendor = $landingPageBuilderModel->getLandingPages($sqlVendor);

        $sqlSignup = "SELECT * FROM signup_pages WHERE is_deleted = 0";
        $responseSignup = $landingPageBuilderModel->getLandingPages($sqlSignup);

        $path = URL . "file/builder-uploads/";

        $vendorLinks = '';
        $signupLinks = '';

        if (is_array($responseVendor)) {
            foreach ($responseVendor as $rowVendor) {
                $landingPageLink = $rowVendor->landing_page_link;
                $createdAt = new DateTime($rowVendor->created_at);
                $formattedCreatedAt = $createdAt->format('F j, Y g:ia');

                ob_start();
                include APP . "view/card/vendor-intro-link.php";
                $vendorLinks .= ob_get_clean();
            }
            $response['vendorLinks'] =  $vendorLinks;
        } else {
            $response['vendorLinks'] = '<div style="text-align: center;"><span style="color: #ffffff;">No vendor intro links found</span></div>';
        }

        if (is_array($responseSignup)) {
            foreach ($responseSignup as $rowSignup) {
                $landingPageLink = $rowSignup->landing_page_link;
                $createdAt = new DateTime($rowSignup->created_at);
                $formattedCreatedAt = $createdAt->format('F j, Y g:ia');

                ob_start();
                include APP . "view/card/signup-link.php";
                $signupLinks .= ob_get_clean();
            }
            $response['signupLinks'] =  $signupLinks;
        } else {
            $response['signupLinks'] = '<div style="text-align: center;"><span style="color: #ffffff;">No signup links found</span></div>';
        }

        echo json_encode($response);
    }

    // get templates
    public function getTemplates()
    {
        $response = array();

        $landingPageBuilderModel = new LandingPageBuilderModel();

        $sql = "SELECT * FROM page_templates WHERE is_deleted = 0";
        $result = $landingPageBuilderModel->getTemplates($sql);
        $path = URL . "file/template-uploads/";
        $template = '';

        if (is_array($result)) {
            foreach ($result as $r) {
                $id = $r->id;
                $createdAt = new DateTime($r->created_at);
                $formattedCreatedAt = $createdAt->format('F j, Y g:ia');
                $logo = $r->logo_path;
                $title = $r->brand_name;
                $banner = $r->banner_path;
                $type = "";
                if ($r->bottom_section_id === "contact-form-div") {
                    $type = "Vendor Intro Template";
                } else {
                    $type = "Referral Partner Signup Template";
                }
                $url = URL;
                ob_start();
                include APP . "view/card/templates.php";
                $template .= ob_get_clean();
            }
            // echo $type;
            $response['template'] =  $template;
        } else {
            $response['template'] = '<div style="text-align: center;"><span style="color: #ffffff;">No templates found</span></div>';
        }

        echo json_encode($response);
    }


    // get one page
    public function getLandingPageRow()
    {
        $landingPageBuilderModel = new LandingPageBuilderModel();

        if (isset($_POST['signup_id']) || isset($_POST['vendor_id'])) {
            $id = $logoPath = $brandName = $bannerPath = $midSection = $bottomSection = null;

            if (isset($_POST['signup_id'])) {
                $idName = 'signup_id';
                $tableName = 'signup_pages';
            } elseif (isset($_POST['vendor_id'])) {
                $idName = 'vendor_id';
                $tableName = 'vendor_pages';
            }

            $id = $_POST[$idName];

            $query = "SELECT * FROM $tableName WHERE id = $id";
            $result = $landingPageBuilderModel->getLandingPages($query);

            if ($result) {
                $row = $result[0];
                $id = $row->id;
                $logoPath = $row->logo_path;
                $logoStyles = $row->logo_styles;
                $pageTitleStyles = $row->page_title_styles;
                $brandName = $row->brand_name;
                $bannerPath = $row->banner_path;

                // Initialize variables to avoid undefined variable notices
                $topSectionHtml = '';
                $midSectionHtml = '';
                $bottomSectionHtml = '';

                $topSection = json_decode($row->top_section_content, true);
                if (isset($topSection['content'])) {
                    $topSectionHtml = htmlspecialchars_decode($topSection['content'], ENT_QUOTES);
                }

                $midSection = json_decode($row->mid_section_content, true);
                if (isset($midSection['content'])) {
                    $midSectionHtml = htmlspecialchars_decode($midSection['content'], ENT_QUOTES);
                }

                $midSectionBg = strpos($row->mid_section_bg, 'gradient') !== false ?
                    $row->mid_section_bg :
                    "url('" . str_replace('compressed/', '', $row->mid_section_bg) . "')";

                $bottomSection = json_decode($row->bottom_section_content, true);
                if (isset($bottomSection['content'])) {
                    $bottomSectionHtml = htmlspecialchars_decode($bottomSection['content'], ENT_QUOTES);
                }

                $mailto = $row->mailto;
                $footer = $row->footer_content;
                $bottomSectionBg = strpos($row->bottom_section_bg, 'gradient') !== false ?
                    $row->bottom_section_bg :
                    "url('" . str_replace('compressed/', '', $row->bottom_section_bg) . "')";

                libxml_use_internal_errors(true);
                $dom = new DOMDocument();
                @$dom->loadHTML('<?xml encoding="UTF-8">' . $topSectionHtml);
                libxml_clear_errors();

                $headingContainer = $dom->getElementById('heading-drop-area');
                $subheadingContainer = $dom->getElementById('sub-heading-drop-area');

                $heading = $headingContainer ? $this->getInnerHTML($headingContainer) : null;
                $subheading = $subheadingContainer ? $this->getInnerHTML($subheadingContainer) : null;

                $_SESSION['update'] = [
                    'id' => $id,
                    'logoPath' => $logoPath,
                    'logoStyles' => $logoStyles,
                    'pageTitleStyles' => $pageTitleStyles,
                    'brandName' => $brandName,
                    'bannerPath' => $bannerPath,
                    'heading' => $heading,
                    'subheading' => $subheading,
                    'midSection' => $midSectionHtml,
                    'midSectionBg' => $midSectionBg,
                    'bottomSection' => $bottomSectionHtml,
                    'mailto' => $mailto,
                    'bottomSectionBg' => $bottomSectionBg,
                    'footer' => $footer
                ];

                header('Location: ' . URL . "landing-page-builder/");
                exit(); // Ensure no further output is sent
            } else {
                echo "Error fetching data from the database.";
                exit();
            }
        } else {
            echo "Invalid request.";
            exit();
        }
    }

    // get one template
    public function getTemplateRow()
    {
        $landingPageBuilderModel = new LandingPageBuilderModel();

        if (isset($_POST['template-id'])) {
            $id = $logoPath = $brandName = $bannerPath = $midSection = $bottomSection = null;

            $id = $_POST['template-id'];
            $table = "page_templates";
            $query = "SELECT * FROM $table WHERE id = $id";
            $result = $landingPageBuilderModel->getTemplates($query);

            if ($result) {
                $row = $result[0];
                $id = $row->id;
                $logoPath = $row->logo_path;
                $logoStyles = $row->logo_styles;
                $brandName = $row->brand_name;
                $pageTitleStyles = $row->page_title_styles;
                $bannerPath = $row->banner_path;

                // Initialize variables to avoid undefined variable notices
                $topSectionHtml = '';
                $midSectionHtml = '';
                $bottomSectionHtml = '';

                $topSection = json_decode($row->top_section_content, true);
                if (isset($topSection['content'])) {
                    $topSectionHtml = htmlspecialchars_decode($topSection['content'], ENT_QUOTES);
                }
                $midSection = json_decode($row->mid_section_content, true);
                if (isset($midSection['content'])) {
                    $midSectionHtml = htmlspecialchars_decode($midSection['content'], ENT_QUOTES);
                }
                $midSectionBg = strpos($row->mid_section_bg, 'gradient') !== false ?
                    $row->mid_section_bg :
                    "url('" . str_replace('compressed/', '', $row->mid_section_bg) . "')";
                $bottomSection = json_decode($row->bottom_section_content, true);
                if (isset($bottomSection['content'])) {
                    $bottomSectionHtml = htmlspecialchars_decode($bottomSection['content'], ENT_QUOTES);
                }
                $mailto = $row->mailto;
                $footer = $row->footer_content;
                $bottomSectionBg = strpos($row->bottom_section_bg, 'gradient') !== false ?
                    $row->bottom_section_bg :
                    "url('" . str_replace('compressed/', '', $row->bottom_section_bg) . "')";

                libxml_use_internal_errors(true);
                $dom = new DOMDocument();
                @$dom->loadHTML('<?xml encoding="UTF-8">' . $topSectionHtml);
                libxml_clear_errors();

                $headingContainer = $dom->getElementById('heading-drop-area');
                $subheadingContainer = $dom->getElementById('sub-heading-drop-area');

                $heading = $headingContainer ? $this->getInnerHTML($headingContainer) : null;
                $subheading = $subheadingContainer ? $this->getInnerHTML($subheadingContainer) : null;

                $_SESSION['template'] = [
                    'id' => $id,
                    'logoPath' => $logoPath,
                    'logoStyles' => $logoStyles,
                    'brandName' => $brandName,
                    'pageTitleStyles' => $pageTitleStyles,
                    'bannerPath' => $bannerPath,
                    'heading' => $heading,
                    'subheading' => $subheading,
                    'midSection' => $midSectionHtml,
                    'midSectionBg' => $midSectionBg,
                    'bottomSection' => $bottomSectionHtml,
                    'mailto' => $mailto,
                    'bottomSectionBg' => $bottomSectionBg,
                    'footer' => $footer
                ];

                echo json_encode(['status' => 'success', 'redirect' => URL . "landing-page-builder/"]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error fetching data from the database.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
        }
    }

    public function landingPageFormSubmissions()
    {
        $landingPageBuilderModel = new LandingPageBuilderModel();

        $cardType = isset($_POST['cardType']) ? $_POST['cardType'] : '';
        $landingPageId = isset($_POST['landingPageId']) ? $_POST['landingPageId'] : '';
        $logo = isset($_POST['logo']) ? $_POST['logo'] : '';
        $brand = isset($_POST['brand']) ? $_POST['brand'] : '';

        $tbl = '';

        if ($cardType === 'vendor') {
            $tbl = 'vendor_forms';
        } else if ($cardType === 'signup') {
            $tbl = 'signup_forms';
        }


        $result = $landingPageBuilderModel->getSubmittedForms($tbl, $landingPageId);
        // print_r($result);
        // exit();

        if ($result) {
            $response = [];
            foreach ($result as $row) {
                $entry = [
                    // 'id' => $row->id,
                    'name' => $row->name,
                    'email' => $row->email,
                    'phone' => $row->phone,
                    'timestamp' => date("F d, Y h:i A", strtotime($row->timestamp))
                ];
                $response[] = $entry;
            }
            echo json_encode($response);
        } else {
            echo json_encode(['message' => 'No results found']);
        }
    }

    public function updateLandingPage()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            header('Content-Type: application/json');
            error_log("Received POST request for updating landing page.");

            $uploadDir = "file/builder-uploads/";
            $contactUploadDir = "file/contact-uploads/";
            $tmpUploadPath = "file/tmp/chunks/";
            $landingPageBuilderModel = new LandingPageBuilderModel();

            // PHASE 1: Handle Chunked File Uploads
            if (isset($_FILES['chunk'])) {
                $fieldName = $_POST['fieldName'] ?? '';
                $chunkIndex = $_POST['chunkIndex'] ?? 0;
                $totalChunks = $_POST['totalChunks'] ?? 1;

                if (!$fieldName || $chunkIndex === '' || !$totalChunks) {
                    error_log("Invalid chunk upload parameters.");
                    echo json_encode(['success' => false, 'error' => 'Invalid chunk upload parameters.']);
                    exit();
                }

                // Temporary chunk file name
                $chunkFileName = $tmpUploadPath . $fieldName . "_chunk_" . $chunkIndex;

                if (!move_uploaded_file($_FILES['chunk']['tmp_name'], $chunkFileName)) {
                    error_log("Failed to move uploaded chunk: $chunkFileName");
                    echo json_encode(['success' => false, 'error' => 'Failed to save file chunk.']);
                    exit();
                }

                // Assemble the file if all chunks are uploaded
                if ($chunkIndex + 1 == $totalChunks) {
                    error_log("All chunks received for field: $fieldName");

                    $assembledFilePath = $uploadDir . $fieldName;
                    $fileHandle = fopen($assembledFilePath, 'wb');

                    for ($i = 0; $i < $totalChunks; $i++) {
                        $chunkPath = $tmpUploadPath . $fieldName . "_chunk_" . $i;
                        fwrite($fileHandle, file_get_contents($chunkPath));
                        unlink($chunkPath);
                    }
                    fclose($fileHandle);

                    // Generate a unique file name
                    $uniqueFileName = $this->generateUniqueName($fieldName);

                    // Compress and move the assembled file
                    $finalDestination = ($fieldName === 'midSecFile' || $fieldName === 'bottomSecFile') ? $contactUploadDir : $uploadDir;
                    $compressedFilePath = $this->compressAndMoveImage($assembledFilePath, $finalDestination . '/' . $uniqueFileName);

                    // Remove uncompressed assembled file
                    if (file_exists($assembledFilePath)) {
                        unlink($assembledFilePath);
                    }

                    // Store only the final file name in the session
                    $_SESSION['uploadedFiles'][$fieldName] = $uniqueFileName;
                    error_log("File assembled and stored in session: $fieldName -> $uniqueFileName");

                    session_write_close();

                    echo json_encode([
                        'success' => true,
                        'filePath' => $compressedFilePath,
                        'uniqueFileName' => $uniqueFileName
                    ]);
                    exit();
                }

                echo json_encode(['success' => true]);
                exit();
            }

            // PHASE 2: Process Non-File Fields
            error_log("Starting Phase 2: Processing non-file fields");

            if (empty($_POST['pageId'])) {
                error_log("Missing required field: pageId");
                echo json_encode(["success" => false, "message" => "Invalid request. Missing Page ID."]);
                exit();
            }

            $pageId = intval($_POST['pageId']);
            $bottomSectionIdConfirmed = $_POST['bottomSectionIdConfirmed'] ?? '';

            // Determine database table
            $table = ($bottomSectionIdConfirmed == "contact-form-div") ? "vendor_pages" : "signup_pages";

            // Fetch existing file paths
            $query = "SELECT logo_path, banner_path FROM $table WHERE id = :pageId";
            $existingData = $landingPageBuilderModel->custom($query, ['pageId' => $pageId]);
            $existingDataArray = json_decode(json_encode($existingData), true);

            // Retrieve file names from session or use existing paths
            $logoFileName = $_SESSION['uploadedFiles']['logoFile'] ?? $existingDataArray[0]['logo_path'] ?? '';
            $bannerFileName = $_SESSION['uploadedFiles']['bannerFile'] ?? $existingDataArray[0]['banner_path'] ?? '';

            // Process background images
            $midSectionBackgroundFileName = $_SESSION['uploadedFiles']['midSecFile'] ?? '';
            $bottomSectionBackgroundFileName = $_SESSION['uploadedFiles']['bottomSecFile'] ?? '';

            $midSectionBg = $this->processBackground(
                $midSectionBackgroundFileName,
                $_POST["mid_bg_color_gradient"] ?? '',
                $_POST["mid_bg_abstract"] ?? '',
                $_POST["mid_bg_industry"] ?? ''
            );
            $bottomSectionBg = $this->processBackground(
                $bottomSectionBackgroundFileName,
                $_POST["bottom_bg_color_gradient"] ?? '',
                $_POST["bottom_bg_abstract"] ?? '',
                $_POST["bottom_bg_industry"] ?? ''
            );


            $updateData = [
                'pageId' => $pageId,
                'logo' => $logoFileName,
                'banner' => $bannerFileName,
                'logoStyles' => $_POST['logoStyles'] ?? '',
                'pageTitleStyles' => $_POST['pageTitleStyles'] ?? '',
                'topSectionContent' => $_POST['topSectionContent'] ?? '',
                'midSectionContent' => $_POST['midSectionContent'] ?? '',
                'midSectionBg' => $midSectionBg,
                'bottomSectionContent' => $_POST['bottomSectionContent'] ?? '',
                'bottomSectionIdConfirmed' => $bottomSectionIdConfirmed,
                'brandName' => $_POST['brandName'] ?? '',
                'bottomSectionBg' => $bottomSectionBg,
                'mailto' => $_POST['mailto'] ?? '',
                'footerContent' => $_POST['footerContent'] ?? '',
            ];

            // Save the update
            $result = $landingPageBuilderModel->updateLandingPage($updateData);

            echo json_encode([
                "success" => $result,
                "message" => $result ? "Landing page updated successfully" : "Failed to update landing page"
            ]);
        }
    }

    // delete landing page 
    public function deleteLandingPage()
    {
        $landingPageBuilderModel = new LandingPageBuilderModel();

        $cardType = isset($_POST['cardType']) ? $_POST['cardType'] : '';
        $landingPageId = isset($_POST['landingPageId']) ? $_POST['landingPageId'] : '';

        $tbl = '';

        if ($cardType === 'vendor') {
            $tbl = 'vendor_pages';
        } else if ($cardType === 'signup') {
            $tbl = 'signup_pages';
        }

        $result = $landingPageBuilderModel->deleteLandingPage($tbl, $landingPageId);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Deletion is successful']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No results found']);
        }
    }

    // get deleted landing pages
    public function getDeletedLandingPages()
    {
        $responseToJs = array();

        $landingPageBuilderModel = new LandingPageBuilderModel();

        $sqlVendor = "SELECT * FROM vendor_pages WHERE is_deleted = 1";
        $responseVendor = $landingPageBuilderModel->getLandingPages($sqlVendor);

        $sqlSignup = "SELECT * FROM signup_pages WHERE is_deleted = 1";
        $responseSignup = $landingPageBuilderModel->getLandingPages($sqlSignup);

        $path = URL . "file/builder-uploads/";

        $vendorLinks = '';
        $signupLinks = '';

        if (is_array($responseVendor)) {
            foreach ($responseVendor as $rowVendor) {
                $tbl = "vendor_forms";
                $landingPageLink = $rowVendor->landing_page_link;
                $createdAt = new DateTime($rowVendor->created_at);
                $formattedCreatedAt = $createdAt->format('F j, Y g:ia');

                // check vendor-form's 'is_deleted'
                $vendorFormResponse = $landingPageBuilderModel->checkFormIsDeleted($tbl, $rowVendor->id);
                $isDeleted = "";
                if (is_array($vendorFormResponse) && isset($vendorFormResponse[0])) {
                    $isDeleted = $vendorFormResponse[0]->is_deleted;
                } else {
                    $isDeleted = "no form submission";
                }

                // echo "Vendor ID: " . $rowVendor->id . " - is_deleted: " . $isDeleted . "<br>";

                ob_start();
                include APP . "view/card/deleted-vendor-intro-link.php";
                $vendorLinks .= ob_get_clean();
            }
            $responseToJs['vendorLinks'] =  $vendorLinks;
        } else {
            $responseToJs['vendorLinks'] = '<div style="text-align: center;"><span style="color: #ffffff;">No vendor intro links found</span></div>';
        }

        if (is_array($responseSignup)) {
            foreach ($responseSignup as $rowSignup) {
                $tbl = "signup_forms";
                $landingPageLink = $rowSignup->landing_page_link;
                $createdAt = new DateTime($rowSignup->created_at);
                $formattedCreatedAt = $createdAt->format('F j, Y g:ia');

                // check signup_form's 'is_deleted'
                $signupFormResponse = $landingPageBuilderModel->checkFormIsDeleted($tbl, $rowSignup->id);
                $isDeleted = "";
                if (is_array($signupFormResponse) && isset($signupFormResponse[0])) {
                    $isDeleted = $signuprFormResponse[0]->is_deleted;
                } else {
                    $isDeleted = "no form submission";
                }

                ob_start();
                include APP . "view/card/deleted-signup-link.php";
                $signupLinks .= ob_get_clean();
            }
            $responseToJs['signupLinks'] =  $signupLinks;
        } else {
            $responseToJs['signupLinks'] = '<div style="text-align: center;"><span style="color: #ffffff;">No signup links found</span></div>';
        }

        echo json_encode($responseToJs);
    }

    //restore landing page
    function restoreLandingPage()
    {
        $landingPageBuilderModel = new LandingPageBuilderModel();

        $cardType = isset($_POST['cardType']) ? $_POST['cardType'] : '';
        $landingPageId = isset($_POST['landingPageId']) ? $_POST['landingPageId'] : '';

        $table = '';

        if ($cardType === 'vendor') {
            $table = 'vendor_pages';
        } else if ($cardType === 'signup') {
            $table = 'signup_pages';
        }

        $result = $landingPageBuilderModel->restoreLandingPage($table, $landingPageId);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Restore is successful']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No results found']);
        }
    }

    // process dall e in backend
    public function dallE()
    {
        $apiKey = DALL_E_API_KEY;

        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE);

        if (!isset($input['prompt'], $input['n'], $input['size'])) {
            http_response_code(400);
            echo json_encode(array("error" => "Invalid input parameters"));
            return;
        }

        $prompt = $input['prompt'];
        $n = $input['n'];
        $size = $input['size'];

        $apiEndpoint = "https://api.openai.com/v1/images/generations";

        $data = [
            "prompt" => $prompt,
            "n" => $n,
            "size" => $size
        ];

        $ch = curl_init($apiEndpoint);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey,
        ]);

        $response = curl_exec($ch);

        curl_close($ch);

        if ($response === FALSE) {
            http_response_code(500);
            echo json_encode(array("error" => "Failed to fetch data from API"));
            return;
        }

        $responseData = json_decode($response, true);

        if (isset($responseData['error'])) {
            http_response_code(500);
            echo json_encode(array("error" => $responseData['error']['message']));
            return;
        }

        echo json_encode($responseData);
    }

    //dall e image download
    public function downloadDallEImage()
    {
        // uses curl
        // cPanel is set allow_url_fopen=0

        $inputData = json_decode(file_get_contents('php://input'), true);

        if (isset($inputData['imageUrl']) && isset($inputData['fileName'])) {
            $imageUrl = $inputData['imageUrl'];
            $fileName = $inputData['fileName'];

            $ch = curl_init($imageUrl);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $imageContent = curl_exec($ch);

            if (curl_errno($ch)) {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to download image: ' . curl_error($ch)]);
                curl_close($ch);
                return;
            }

            curl_close($ch);

            header('Content-Type: image/png');
            header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
            header('Content-Length: ' . strlen($imageContent));

            echo $imageContent;
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
        }
    }


    public function formEnquiryAction()
    {
        $landingPageBuilderModel = new LandingPageBuilderModel();

        $landingPageId = isset($_POST['landingPageId']) ? $_POST['landingPageId'] : '';
        $cardType = isset($_POST['cardType']) ? $_POST['cardType'] : '';
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        $tbl = '';

        if ($cardType === 'vendor') {
            $tbl = 'vendor_forms';
        } else if ($cardType === 'signup') {
            $tbl = 'signup_forms';
        }

        $result = $landingPageBuilderModel->formEnquiryAction($tbl, $landingPageId, $action);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Restore is successful']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No results found']);
        }
    }

    //generate unique file name 
    public function generateUniqueName($filename)
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $basename = pathinfo($filename, PATHINFO_FILENAME);
        $uniqueId = uniqid();
        $currentTimestamp = time();
        $uniqueName = $uniqueId . '_' . $currentTimestamp . '_' . $basename . '.' . $extension;
        return $uniqueName;
    }

    //extract and save image url
    public function saveImageFromUrl($url, $targetFolder)
    {
        $fileName = str_replace('%20', '_', basename($url));

        if (!file_exists($targetFolder)) {
            mkdir($targetFolder, 0777, true);
        }

        $filePath = $targetFolder . '/' . $fileName;

        $imageData = file_get_contents($url);
        file_put_contents($filePath, $imageData);

        return $fileName;
    }

    public function compressAndMoveImage($sourcePath, $destinationPath)
    {
        $image_info = getimagesize($sourcePath);
        if ($image_info['mime'] == 'image/jpeg') {
            $source_image = imagecreatefromjpeg($sourcePath);
            imagejpeg($source_image, $destinationPath, 75);
        } elseif ($image_info['mime'] == 'image/png') {
            $source_image = imagecreatefrompng($sourcePath);

            // alpha channel
            imagesavealpha($source_image, true);

            imagepng($source_image, $destinationPath, 9);
        }

        // Free memory
        imagedestroy($source_image);

        return basename($destinationPath);
    }

    public function compressImg($sourcePath, $destinationPath)
    {
        $image_info = getimagesize($sourcePath);
        if ($image_info['mime'] == 'image/jpeg') {
            $source_image = imagecreatefromjpeg($sourcePath);
            imagejpeg($source_image, $destinationPath, 75);
        } elseif ($image_info['mime'] == 'image/png') {
            $source_image = imagecreatefrompng($sourcePath);

            // alpha channel
            imagesavealpha($source_image, true);

            imagepng($source_image, $destinationPath, 9);
        }

        // Free memory
        imagedestroy($source_image);

        return $destinationPath;
    }

    public function moveImage($sourcePath, $destinationPath)
    {
        $imageInfo = getimagesize($sourcePath);
        if ($imageInfo['mime'] == 'image/jpeg') {
            $source_image = imagecreatefromjpeg($sourcePath);
            imagejpeg($source_image, $destinationPath, 75);
        } else if ($imageInfo['mime'] == 'image/png') {
            $source_image = imagecreatefrompng($sourcePath);

            // alpha channel
            imagesavealpha($source_image, true);

            imagepng($source_image, $destinationPath, 9);
        }

        imagedestroy($source_image);

        return basename($destinationPath);
    }

    public function getInnerHTML($e)
    {
        $innerHTML = "";
        foreach ($e->childNodes as $child) {
            $innerHTML .= $e->ownerDocument->saveHTML($child);
        }
        return $innerHTML;
    }

    // redirect to success message
    public function successPage()
    {
        require(APP . "view/_templates/success/success-message.php");
    }


    //Process background image and fallback options.

    public function processBackground($bgFileName, $gradient, $abstract, $industry)
    {
        $path = URL . "file/contact-uploads/";

        if (!empty($bgFileName)) {
            return $path . $bgFileName;
        } elseif (!empty($gradient)) {
            return $gradient;
        } elseif (!empty($abstract)) {
            return $abstract;
        } elseif (!empty($industry)) {
            return $industry;
        } else {
            return '';
        }
    }
}
