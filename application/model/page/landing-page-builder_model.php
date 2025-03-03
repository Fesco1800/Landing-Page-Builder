<?php

class LandingPageBuilderModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    // custom query
    public function custom($query, $params = [])
    {
        return $this->customQry($query, $params);
    }

    //save landing page
    public function save($logo, $logoStyles, $brand, $pageTitleStyles, $banner, $topSection, $midSection, $midSectionBg, $bottomSection, $mailto, $bottomSectionBg, $bottomSectionId, $footer, $isDeleted)
    {
        $data = array(
            'logo_path' => $logo,
            'logo_styles' => $logoStyles,
            'brand_name' => $brand,
            'page_title_styles' => $pageTitleStyles,
            'banner_path' => $banner,
            'top_section_content' => $topSection,
            'mid_section_content' => $midSection,
            'mid_section_bg' => $midSectionBg,
            'bottom_section_content' => $bottomSection,
            'mailto' => $mailto,
            'bottom_section_bg' => $bottomSectionBg,
            'bottom_section_id' => $bottomSectionId,
            'footer_content' => $footer,
            'is_deleted' => $isDeleted
        );

        $table = ($bottomSectionId === "signup-form-div") ? 'signup_pages' : 'vendor_pages';

        $lastInsertedId = $this->add($table, $data, true);

        if ($lastInsertedId) {
            return $lastInsertedId;
        } else {
            return false;
        }
    }

    //save as template
    public function saveAsTemplate($logo, $logoSytles, $brand, $pageTitleStyles, $banner, $topSection, $midSection, $midSectionBg, $bottomSection, $mailto, $bottomSectionBg, $bottomSectionId, $footer, $isDeleted)
    {
        $data = array(
            'logo_path' => $logo,
            'logo_styles' => $logoSytles,
            'brand_name' => $brand,
            'page_title_styles' => $pageTitleStyles,
            'banner_path' => $banner,
            'top_section_content' => $topSection,
            'mid_section_content' => $midSection,
            'mid_section_bg' => $midSectionBg,
            'bottom_section_content' => $bottomSection,
            'mailto' => $mailto,
            'bottom_section_bg' => $bottomSectionBg,
            'bottom_section_id' => $bottomSectionId,
            'footer_content' => $footer,
            'is_deleted' => $isDeleted
        );

        $table = 'page_templates';

        $lastInsertedId = $this->add($table, $data, true);

        if ($lastInsertedId) {
            return $lastInsertedId;
        } else {
            return false;
        }
    }

    //update a landing page
    public function updateLandingPageLink($id, $bottomSectionId, $landingPageLink)
    {
        $data = array(
            'landing_page_link' => $landingPageLink
        );

        $table = ($bottomSectionId === "signup-form-div") ? 'signup_pages' : 'vendor_pages';
        $where = 'id = :id';

        $this->update($table, $data, $where, array('id' => $id));
    }

    // visit the landing page
    public function visit($landingPageId, $bottomSectionId)
    {
        $templateTable = '';
        switch ($bottomSectionId) {
            case "contact-form-div":
                $templateTable = 'vendor_pages';
                break;
            case "signup-form-div":
            case "signup-form-div?success=1":
                $templateTable = 'signup_pages';
                break;
            default:
                $templateTable = 'vendor_pages';
                break;
        }

        return $this->selectOne('*', $templateTable, "id = $landingPageId");
    }

    // get landing pages
    public function getLandingPages($query)
    {
        return $this->customQry($query);
    }

    // get templates
    public function getTemplates($query)
    {
        return $this->customQry($query);
    }

    // update a landing page
    public function updateLandingPage($data)
    {
        $logoFileName = $data['logo'];
        $bannerFileName = $data['banner'];
        $logoStyles = $data['logoStyles'];
        $pageTitleStyles = $data['pageTitleStyles'];
        $topSectionContent = $data['topSectionContent'];
        $midSectionContent = $data['midSectionContent'];
        $midSectionBg = $data['midSectionBg'];
        $bottomSectionContent = $data['bottomSectionContent'];
        $brandName = $data['brandName'];
        $pageId = $data['pageId'];
        $bottomSectionIdConfirmed = $data['bottomSectionIdConfirmed'];
        $mailto = $data['mailto'];
        $bottomSectionBg = $data['bottomSectionBg'];
        $footerContent = $data['footerContent'];

        $tableName = '';
        switch ($bottomSectionIdConfirmed) {
            case 'signup-form-div':
                $tableName = 'signup_pages';
                break;
            case 'contact-form-div':
                $tableName = 'vendor_pages';
                break;
            default:
                break;
        }

        if ($tableName) {
            return $this->update(
                $tableName,
                [
                    'logo_path' => $logoFileName,
                    'logo_styles' => $logoStyles,
                    'page_title_styles' => $pageTitleStyles,
                    'brand_name' => $brandName,
                    'banner_path' => $bannerFileName,
                    'top_section_content' => $topSectionContent,
                    'mid_section_content' => $midSectionContent,
                    'mid_section_bg' => $midSectionBg,
                    'bottom_section_content' => $bottomSectionContent,
                    'mailto' => $mailto,
                    'bottom_section_bg' => $bottomSectionBg,
                    'footer_content' => $footerContent
                ],
                'id = :pageId',
                ['pageId' => $pageId]
            );
        } else {
            return false;
        }
    }

    public function deleteLandingPage($tbl, $pageId)
    {
        $table = $tbl;
        $id = $pageId;

        return $this->update($table, ['is_deleted' => 1], 'id = :id', ['id' => $id]);
    }

    public function restoreLandingPage($tbl, $pageId)
    {
        $table = $tbl;
        $id = $pageId;

        return $this->update($table, ['is_deleted' => 0], 'id = :id', ['id' => $id]);
    }

    public function formEnquiryAction($tbl, $pageId, $act)
    {
        $table = $tbl;
        $id = $pageId;
        $action = $act;
        $data = "";

        if ($action === "yes") {
            $data = ['is_deleted' => 1];
        } else if ($action === "no") {
            $data = ['is_deleted' => 0];
        }

        // echo $table . "<br>";
        // echo $id . "<br>";
        // echo $action . "<br>";
        // echo "<pre>";
        // print_r($query);
        // echo "</pre>";
        // exit();

        return $this->update($table, $data, 'id = :id', ['id' => $id]);
    }


    // public function preview($previewData)
    // {
    //     // echo "<pre>";
    //     // print_r($previewData);
    //     // echo "</pre>";
    //     // exit;
    //     $data = array(
    //         'logo_path' => $previewData['logo'],
    //         'banner_path' => $previewData['banner'],
    //         'brand_name' => $previewData['brand'],
    //         'mid_section_content' => $previewData['mid_section'],
    //         'bottom_section_content' => $previewData['bottom_section'],
    //         'bottom_section_id' => $previewData['bottom_section_id']
    //     );

    //     $table = "preview";

    //     $lastInsertedId = $this->add($table, $data, true);

    //     if ($lastInsertedId) {
    //         return $lastInsertedId;
    //     } else {
    //         return false;
    //     }
    // }


    // public function getPreviewPage($id)
    // {
    //     return $this->selectOne('*', "preview", "id = $id");
    // }


    // public function deletePreview()
    // {
    //     $sql = "DELETE FROM preview";
    //     $rowsAffected = $this->deleteCustom($sql);

    //     if ($rowsAffected === false) {
    //         return false;
    //     }

    //     return true;
    // }


    public function submitPage($data, $table)
    {
        return $this->add($table, $data);
    }

    public function getSubmittedForms($table, $landingPageId)
    {
        $where = "landing_page_id = :landingPageId AND (is_deleted = 0 OR is_deleted IS NULL)";
        $wParamData = ['landingPageId' => $landingPageId];
        return $this->select('*', $table, $where, $wParamData);
    }

    public function checkFormIsDeleted($table, $pageId)
    {
        $where = "landing_page_id = :pageId";
        $wParamData = ['pageId' => $pageId];

        $result = $this->select('*', $table, $where, $wParamData);

        return $result;
    }
}
