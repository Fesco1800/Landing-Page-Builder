<!-- Landing Pages Modal -->
<div class="modal fade" id="landing-page-list-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title" id="modal-title">
                    Landing Pages
                </h5>
                <i class="bi bi-arrow-clockwise ms-2" id="refreshButton"></i>
                <button type="button" class="close btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <hr class="bg-white">
            <div class="deleted-pages-button-container">
                <button type="button" class="btn btn-primary float-end rounded-corners-button-red deleted-pages-button" id="deleted-pages-button">
                    Deleted Pages
                </button>
            </div>

            <div class="landing-pages-button-container">
                <button type="button" class="btn btn-primary float-end rounded-corners-button-violet landing-pages-button-2 d-none" id="landing-pages-button-2">
                    Landing Pages
                </button>
            </div>
            <!-- <hr class="bg-white mb-0"> -->
            <div class="modal-body" id="landing-page-list-modalBody">
                <div class="row">
                    <div class="col-md-6 page-links">
                        <h5 class="text-center">Vendor Intro</h5>
                        <div id="vendorLinks" class="">

                        </div>
                    </div>
                    <div class="col-md-6 page-links">
                        <h5 class="text-center">Referral Partner Signup</h5>
                        <div id="signupLinks" class="">

                        </div>
                    </div>

                    <div class="table-responsive d-none" id="tableContainer"></div>
                    <div class="deleted-pages-container d-none">
                        <div class="row">
                            <div class="col-md-6 deleted-page-links">
                                <h5 class="text-center">Vendor Intro</h5>
                                <div id="deletedVendorLinks" class="">

                                </div>
                            </div>
                            <div class="col-md-6 deleted-page-links">
                                <h5 class="text-center">Referral Partner Signup</h5>
                                <div id="deletedSignupLinks" class="">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="confirmDialog" class="confirm-dialog">
    <div class="confirm-dialog-content">
        <p>Are you sure you want to continue?</p>
        <button id="confirmYes">Yes</button>
        <button id="confirmNo">No</button>
    </div>
</div>