<!-- Success Modal -->
<div id="success_tic" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="page-body">
                <div class="head">
                    <h3 style="margin-top:5px;">Success !</h3>
                    <!-- <h4>The Landing Page is updated successfully</h4> -->
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
                    <?php
                    if (!empty($error_message)) {
                        echo
                        "<h4>
                            " . htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8') . "
                        </h4>";
                    } else {
                        echo
                        "<h4>
                            Ensure all fields are filled
                        </h4>";
                    }
                    ?>
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
<script>
    // document.addEventListener("DOMContentLoaded", function() {
    //     var successModal = new bootstrap.Modal(document.getElementById("success_tic"));
    //     successModal.show();
    // });

    // document.addEventListener("DOMContentLoaded", function() {
    //     var errorModal = new bootstrap.Modal(document.getElementById("error_tic"));
    //     errorModal.show();
    // });
</script>