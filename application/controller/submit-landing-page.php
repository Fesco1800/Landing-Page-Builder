<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require('plugins/PHPMailer-6.9.1/src/PHPMailer.php');
require('plugins/PHPMailer-6.9.1/src/Exception.php');
require('plugins/PHPMailer-6.9.1/src/SMTP.php');
require_once(DIR_MODEL_PAGE . 'landing-page-builder_model.php');

class SubmitLandingPage extends Controller
{
    public function __construct($urlDetails)
    {
        parent::__construct($urlDetails);
    }

    public function submitSignup()
    {
        $landingPageBuilderModel = new LandingPageBuilderModel();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fields = [
                "name" => "Name",
                "email" => "Email",
                "phone" => "Phone"
            ];

            if (!empty($_POST['honeypot'])) {
                echo json_encode(['success' => false, 'message' => 'Form submission suspected to be automated. Please try again. honey']);
                exit;
                // die("Form submission suspected to be automated. Please try again.");
            }

            $logo = isset($_POST["logo"]) ? htmlspecialchars($_POST["logo"]) : null;
            $brand = isset($_POST["brand"]) ? htmlspecialchars($_POST["brand"]) : null;
            $link = isset($_POST["link"]) ? htmlspecialchars($_POST["link"]) : null;
            $landingPageId = isset($_POST["landing_page_id"]) ? intval($_POST["landing_page_id"]) : null;
            $mailto = isset($_POST["mailto"]) ? htmlspecialchars($_POST["mailto"]) : null;
            $emailSvg = isset($_POST["email_svg"]) ? htmlspecialchars($_POST["email_svg"]) : null;
            $emailBg = isset($_POST["email_bg"]) ? htmlspecialchars($_POST["email_bg"]) : null;
            $subject = isset($_POST["subject"]) ? htmlspecialchars($_POST["subject"]) : null;

            if ($landingPageId === null) {
                die("Error: Landing Page ID is missing.");
            }

            $errors = [];

            foreach ($fields as $fieldName => $fieldLabel) {
                if (isset($_POST[$fieldName])) {
                    $fieldValue = htmlspecialchars($_POST[$fieldName]);

                    if (empty($fieldValue)) {
                        $errors[] = "Please enter a valid $fieldLabel.";
                    } else {
                        if ($fieldName === "name" && empty($fieldValue)) {
                            $errors[] = "Please enter a valid $fieldLabel .";
                        }
                        if ($fieldName === "email" && !filter_var($fieldValue, FILTER_VALIDATE_EMAIL)) {
                            $errors[] = "Please enter a valid $fieldLabel address.";
                        }
                        if ($fieldName === "phone" && !preg_match("/^\d+$/", $fieldValue)) {
                            $errors[] = "Please enter a valid $fieldLabel number.";
                        }
                    }
                }
            }

            if (!empty($errors)) {
                echo json_encode(['success' => false, 'message' => implode(" ", $errors)]);
                exit;
            }

            $data = [
                'landing_page_id' => $landingPageId
            ];

            foreach ($fields as $fieldName => $fieldLabel) {
                if (isset($_POST[$fieldName])) {
                    $fieldValue = htmlspecialchars($_POST[$fieldName]);
                    if ($fieldName === "name") {
                        $data['name'] = $fieldValue;
                    } else {
                        $data[$fieldName] = $fieldValue;
                    }
                }
            }

            $table = "signup_forms";

            $result = $landingPageBuilderModel->submitPage($data, $table);

            if ($result) {
                try {
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = EMAIL_HOST;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->SMTPAuth = true;
                    $mail->Username = EMAIL_USERNAME;
                    $mail->Password = EMAIL_PASSWORD;
                    $mail->SMTPSecure = EMAIL_SMTP_SECURE;
                    $mail->Port = EMAIL_PORT;

                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );

                    if (isset($data['name'])) {
                        $mail->setFrom(EMAIL_USERNAME, $data['name']);
                    } else {
                        $mail->setFrom(EMAIL_USERNAME, "No name");
                    }

                    // recipients
                    if ($mailto) {
                        $recipients = preg_split('/[;,]/', $mailto);
                        foreach ($recipients as $recipient) {
                            $mail->addAddress(trim($recipient));
                        }
                    }
                    $mail->isHTML(true);
                    if ($subject) {
                        $mail->Subject = $subject;
                    } else {
                        $mail->Subject = "New Referral Partner Signup Request for Review";
                    }


                    // cURL logo
                    $ch_logo = curl_init();
                    curl_setopt($ch_logo, CURLOPT_URL, $logo);
                    curl_setopt($ch_logo, CURLOPT_RETURNTRANSFER, 1);
                    $logoData = curl_exec($ch_logo);
                    if (curl_errno($ch_logo)) {
                        throw new Exception('Curl error fetching logo: ' . curl_error($ch_logo));
                    }
                    curl_close($ch_logo);

                    // cURL email banner
                    $ch_emailSvg = curl_init();
                    curl_setopt($ch_emailSvg, CURLOPT_URL, $emailSvg);
                    curl_setopt($ch_emailSvg, CURLOPT_RETURNTRANSFER, 1);
                    $emailSvgData = curl_exec($ch_emailSvg);
                    if (curl_errno($ch_emailSvg)) {
                        throw new Exception('Curl error fetching email banner: ' . curl_error($ch_emailSvg));
                    }
                    curl_close($ch_emailSvg);

                    // cURL email background
                    $ch_emailBg = curl_init();
                    curl_setopt($ch_emailBg, CURLOPT_URL, $emailBg);
                    curl_setopt($ch_emailBg, CURLOPT_RETURNTRANSFER, 1);
                    $emailBgData = curl_exec($ch_emailBg);
                    if (curl_errno($ch_emailBg)) {
                        throw new Exception('Curl error fetching email background: ' . curl_error($ch_emailBg));
                    }
                    curl_close($ch_emailBg);

                    // cURL fetch email template
                    $ch_html = curl_init();
                    $html_url = "file://" . APP . "view/_templates/email.php";
                    curl_setopt($ch_html, CURLOPT_URL, $html_url);
                    curl_setopt($ch_html, CURLOPT_RETURNTRANSFER, 1);
                    $html_content = curl_exec($ch_html);
                    if (curl_errno($ch_html)) {
                        throw new Exception('Curl error fetching HTML content from ' . $html_url . ': ' . curl_error($ch_html));
                    }
                    curl_close($ch_html);

                    // Placeholders for actual data
                    $dateTime = date("F j, Y \a\\t h:i A");
                    $placeholders = array(
                        '{logo}' => 'cid:logo',
                        '{brand}' => $brand,
                        '{link}' => $link,
                        '{emailSvg}' => 'cid:emailSvg',
                        '{emailBg}' => 'cid:emailBg',
                        '{dateTime}' => $dateTime
                    );

                    if (isset($data['name'])) {
                        $placeholders['{name}'] = $data['name'];
                    } else {
                        $placeholders['{name}'] = "No name";
                    }

                    if (isset($data['email'])) {
                        $placeholders['{email}'] = $data['email'];
                    } else {
                        $placeholders['{email}'] = "not set";
                    }

                    if (isset($data['phone'])) {
                        $placeholders['{phone}'] = $data['phone'];
                    } else {
                        $placeholders['{phone}'] = "not set";
                    }

                    $html_content = strtr($html_content, $placeholders);

                    $mail->Body = $html_content;

                    $mail->addStringEmbeddedImage($logoData, 'logo', 'logo.png', 'base64', 'image/png');
                    $mail->addStringEmbeddedImage($emailSvgData, 'emailSvg', 'email.svg', 'base64', 'image/png');
                    $mail->addStringEmbeddedImage($emailBgData, 'emailBg', 'emailbg.png', 'base64', 'image/png');
                    if (empty($html_content)) {
                        throw new Exception('HTML content is empty.');
                    }

                    $mail->send();
                    echo json_encode(['success' => true, 'message' => 'Signup form is submitted successfully']);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
                }
                exit();
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to submit data. Please try again.']);
                exit();
            }
        }
    }


    public function submitVendorIntro()
    {
        $landingPageBuilderModel = new LandingPageBuilderModel();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fields = [
                "name" => "Name",
                "email" => "Email",
                "phone" => "Phone"
            ];

            if (!empty($_POST['honeypot'])) {
                echo json_encode(['success' => false, 'message' => 'Form submission suspected to be automated. Please try again.']);
                exit;
                // die("Form submission suspected to be automated. Please try again.");
            }

            $logo = isset($_POST["logo"]) ? htmlspecialchars($_POST["logo"]) : null;
            $brand = isset($_POST["brand"]) ? htmlspecialchars($_POST["brand"]) : null;
            $link = isset($_POST["link"]) ? htmlspecialchars($_POST["link"]) : null;
            $landingPageId = isset($_POST["landing_page_id"]) ? intval($_POST["landing_page_id"]) : null;
            $mailto = isset($_POST["mailto"]) ? htmlspecialchars($_POST["mailto"]) : null;
            $emailSvg = isset($_POST["email_svg"]) ? htmlspecialchars($_POST["email_svg"]) : null;
            $emailBg = isset($_POST["email_bg"]) ? htmlspecialchars($_POST["email_bg"]) : null;
            $subject = isset($_POST["subject"]) ? htmlspecialchars($_POST["subject"]) : null;

            if ($landingPageId === null) {
                die("Error: Landing Page ID is missing.");
            }

            $errors = [];

            foreach ($fields as $fieldName => $fieldLabel) {
                if (isset($_POST[$fieldName])) {
                    $fieldValue = htmlspecialchars($_POST[$fieldName]);

                    if (empty($fieldValue)) {
                        $errors[] = "Please enter a valid $fieldLabel.";
                    } else {
                        if ($fieldName === "name" && empty($fieldValue)) {
                            $errors[] = "Please enter a valid $fieldLabel .";
                        }
                        if ($fieldName === "email" && !filter_var($fieldValue, FILTER_VALIDATE_EMAIL)) {
                            $errors[] = "Please enter a valid $fieldLabel address.";
                        }
                        if ($fieldName === "phone" && !preg_match("/^\d+$/", $fieldValue)) {
                            $errors[] = "Please enter a valid $fieldLabel number.";
                        }
                    }
                }
            }

            if (!empty($errors)) {
                echo json_encode(['success' => false, 'message' => implode(" ", $errors)]);
                exit;
            }

            $data = [
                'landing_page_id' => $landingPageId
            ];

            foreach ($fields as $fieldName => $fieldLabel) {
                if (isset($_POST[$fieldName])) {
                    $fieldValue = htmlspecialchars($_POST[$fieldName]);
                    if ($fieldName === "name") {
                        $data['name'] = $fieldValue;
                    } else {
                        $data[$fieldName] = $fieldValue;
                    }
                }
            }

            $table = "vendor_forms";

            $result = $landingPageBuilderModel->submitPage($data, $table);

            if ($result) {
                try {
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = EMAIL_HOST;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->SMTPAuth = true;
                    $mail->Username = EMAIL_USERNAME;
                    $mail->Password = EMAIL_PASSWORD;
                    $mail->SMTPSecure = EMAIL_SMTP_SECURE;
                    $mail->Port = EMAIL_PORT;

                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );

                    if (isset($data['name'])) {
                        $mail->setFrom(EMAIL_USERNAME, $data['name']);
                    } else {
                        $mail->setFrom(EMAIL_USERNAME, "No name");
                    }

                    // recipients
                    if ($mailto) {
                        $recipients = preg_split('/[;,]/', $mailto);
                        foreach ($recipients as $recipient) {
                            $mail->addAddress(trim($recipient));
                        }
                    }

                    $mail->isHTML(true);
                    if ($subject) {
                        $mail->Subject = $subject;
                    } else {
                        if (isset($data['name'])) {
                            $mail->Subject = "Enquiry from " . $data['name'] .  " via " . $brand;
                        } else {
                            $mail->Subject = "Enquiry from " . "No name" .  " via " . $brand;
                        }
                    }

                    // cURL logo
                    $ch_logo = curl_init();
                    curl_setopt($ch_logo, CURLOPT_URL, $logo);
                    curl_setopt($ch_logo, CURLOPT_RETURNTRANSFER, 1);
                    $logoData = curl_exec($ch_logo);
                    if (curl_errno($ch_logo)) {
                        throw new Exception('Curl error fetching logo: ' . curl_error($ch_logo));
                    }
                    curl_close($ch_logo);

                    // cURL email banner
                    $ch_emailSvg = curl_init();
                    curl_setopt($ch_emailSvg, CURLOPT_URL, $emailSvg);
                    curl_setopt($ch_emailSvg, CURLOPT_RETURNTRANSFER, 1);
                    $emailSvgData = curl_exec($ch_emailSvg);
                    if (curl_errno($ch_emailSvg)) {
                        throw new Exception('Curl error fetching email banner: ' . curl_error($ch_emailSvg));
                    }
                    curl_close($ch_emailSvg);

                    // cURL email background
                    $ch_emailBg = curl_init();
                    curl_setopt($ch_emailBg, CURLOPT_URL, $emailBg);
                    curl_setopt($ch_emailBg, CURLOPT_RETURNTRANSFER, 1);
                    $emailBgData = curl_exec($ch_emailBg);
                    if (curl_errno($ch_emailBg)) {
                        throw new Exception('Curl error fetching email background: ' . curl_error($ch_emailBg));
                    }

                    // cURL fetch email template
                    $ch_html = curl_init();
                    $html_url = "file://" . APP . "view/_templates/vendor-email.php";
                    curl_setopt($ch_html, CURLOPT_URL, $html_url);
                    curl_setopt($ch_html, CURLOPT_RETURNTRANSFER, 1);
                    $html_content = curl_exec($ch_html);
                    if (curl_errno($ch_html)) {
                        throw new Exception('Curl error fetching HTML content from ' . $html_url . ': ' . curl_error($ch_html));
                    }
                    curl_close($ch_html);

                    // Placeholders for actual data
                    $dateTime = date("F j, Y \a\\t h:i A");
                    $placeholders = array(
                        '{logo}' => 'cid:logo',
                        '{brand}' => $brand,
                        '{link}' => $link,
                        '{emailSvg}' => 'cid:emailSvg',
                        '{emailBg}' => 'cid:emailBg',
                        '{dateTime}' => $dateTime
                    );

                    if (isset($data['name'])) {
                        $placeholders['{name}'] = $data['name'];
                    } else {
                        $placeholders['{name}'] = "No name";
                    }

                    if (isset($data['email'])) {
                        $placeholders['{email}'] = $data['email'];
                    } else {
                        $placeholders['{email}'] = "not set";
                    }

                    if (isset($data['phone'])) {
                        $placeholders['{phone}'] = $data['phone'];
                    } else {
                        $placeholders['{phone}'] = "not set";
                    }

                    $html_content = strtr($html_content, $placeholders);

                    $mail->Body = $html_content;

                    $mail->addStringEmbeddedImage($logoData, 'logo', 'logo.png', 'base64', 'image/png');
                    $mail->addStringEmbeddedImage($emailSvgData, 'emailSvg', 'email.svg', 'base64', 'image/png');
                    $mail->addStringEmbeddedImage($emailBgData, 'emailBg', 'emailbg.png', 'base64', 'image/png');

                    if (empty($html_content)) {
                        throw new Exception('HTML content is empty.');
                    }

                    $mail->send();
                    echo json_encode(['success' => true, 'message' => 'Contact form is submitted successfully']);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
                }
                exit();
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to submit data. Please try again.']);
                exit();
            }
        }
    }
}
