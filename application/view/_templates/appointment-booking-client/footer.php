<script>
    var url = "<?= URL ?>";
</script>
<script>
    var publicUrl = "<?= URL_PUBLIC_FOLDER ?>";
</script>
<script src="<?= URL ?>plugins/jquery-3.7.1.min.js"></script>
<script src="<?= URL ?>plugins/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>

<!-- -----RMS CDN Scripts----- -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer">
</script>

<?php
if (!empty($pluginJS)) {
    foreach ($pluginJS as $v) {
        if (file_exists(ROOT . "public/plugins/" . $v . ".js")) { ?>
            <script src="<?= URL ?>plugins/<?= $v ?>.js"></script>
<?php }
    }
}
?>

<?php
if (!empty($customJS)) {
    foreach ($customJS as $v) {
        if (file_exists(ROOT . "public/js/custom/appointment-booking-client/" . $v . ".js")) { ?>
            <script src="<?= URL ?>js/custom/appointment-booking-client/<?= $v ?>.js?v=<?= APP_VERSION ?>"></script>
<?php }
    }
}
?>

</body>

</html>