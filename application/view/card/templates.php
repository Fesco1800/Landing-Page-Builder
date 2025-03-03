<div class="col-lg-3 d-flex justify-content-evenly mt-5">
    <div class="custom-card">
        <div class="image_container">
            <?php
            if ($banner) {
                echo '<img class="image" src="' . htmlspecialchars($path . $banner, ENT_QUOTES, 'UTF-8') . '" alt="Banner Image">';
            } else {
                echo '
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="default-image">
                <path d="M20 5H4V19L13.2923 9.70649C13.6828 9.31595 14.3159 9.31591 14.7065 9.70641L20 15.0104V5ZM2 3.9934C2 3.44476 2.45531 3 2.9918 3H21.0082C21.556 3 22 3.44495 22 3.9934V20.0066C22 20.5552 21.5447 21 21.0082 21H2.9918C2.44405 21 2 20.5551 2 20.0066V3.9934ZM8 11C6.89543 11 6 10.1046 6 9C6 7.89543 6.89543 7 8 7C9.10457 7 10 7.89543 10 9C10 10.1046 9.10457 11 8 11Z">
                </path>
            </svg>';
            }
            ?>
        </div>
        <div class="title">
            <span><i class="bi bi-card-heading"></i> <?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="date">
            <img src="<?php echo htmlspecialchars($url, ENT_QUOTES, 'UTF-8') ?>img/landing-page-builder/calendar.svg" alt="">
            <?php echo htmlspecialchars($formattedCreatedAt, ENT_QUOTES, 'UTF-8'); ?>
        </div>
        <div class="type">
            <img src="<?php echo htmlspecialchars($url, ENT_QUOTES, 'UTF-8') ?>img/landing-page-builder/heart.svg" alt="">
            <?php echo htmlspecialchars($type, ENT_QUOTES, 'UTF-8'); ?>
        </div>
        <div class="action">
            <span></span>
            <button type="button" class="cart-button" onclick="useTemplate(<?php echo $id; ?>, '<?php echo URL; ?>')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                    <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                    <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                </svg>
                <div class="button-text">Select</div>
            </button>
        </div>
    </div>
</div>