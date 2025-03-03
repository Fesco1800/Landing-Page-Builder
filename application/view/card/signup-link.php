<form class="landing-page-card signup-card" method="POST" action="<?= URL ?>landing-page-builder/getLandingPageRow">
    <input type="hidden" class="page_id signup_id" name="signup_id" value="<?= $rowSignup->id ?>">
    <div class="card" data-link="<?= $landingPageLink ?>" style="border-radius: 0px 10px 10px 0px; margin-bottom: 10px;">
        <div class="row">
            <div class="col-sm-5">
                <a href="<?= $landingPageLink ?>" class="card-link">
                    <div style="height: 100%;">
                        <img class="d-block w-100 img-fluid float-end" src="<?= $path . $rowSignup->banner_path ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </a>
            </div>
            <div class="col-sm-7">
                <div class="card-block">
                    <div>
                        <div class="row">
                            <div class="col-3">
                                <img src="<?= $path . $rowSignup->logo_path ?>" alt="Logo" class="img-fluid page-logo" style="max-width: 50px;">
                            </div>
                            <div class="col-9 d-block">
                                <div class="d-block">
                                    <input type="hidden" class="page-brand-complete" value="<?= $rowSignup->brand_name ?>">
                                    <span class="page-brand"><?= strlen($rowSignup->brand_name) > 13 ? rtrim(substr($rowSignup->brand_name, 0, 13)) . '...' : $rowSignup->brand_name ?></span>

                                    <button type="submit" class="btn btn-small edit-page-button">
                                        <div>
                                            <img src="<?= URL ?>img/landing-page-builder/edit-page.svg" style="width: 27px; opacity: 0.7;">
                                        </div>
                                    </button>
                                </div>
                                <span class="d-block" style="font-size: 12px;"><?= $formattedCreatedAt ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="float-end" style="font-size: 25px;">
                        <button type="button" class="btn btn-small landing-page-form-submission-button">
                            <div>
                                <img src="<?= URL ?>img/landing-page-builder/contact-forms.svg" style="width: 24px; opacity: 0.7;">
                            </div>
                        </button>
                        <i class="bi bi-clipboard"></i>
                        <i class="bi bi-trash2 text-danger" id="delete-page-button"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>