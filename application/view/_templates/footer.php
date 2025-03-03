		</div> <!-- #main -->
		</div> <!-- #pageWrapper -->

		<script>
			var url = "<?= URL ?>";
			var builderMode = "<?= $builderMode ?>";
		</script>
		<script>
			var publicUrl = "<?= URL_PUBLIC_FOLDER ?>";
		</script>
		<script src="<?= URL ?>plugins/jquery-3.7.1.min.js"></script>
		<script src="<?= URL ?>plugins/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
		<script src="<?= URL ?>/plugins/ckeditor5-40.2.0-ftgfkqr4ghlf/build/ckeditor.js"></script>
		<script src="<?= URL ?>/plugins/simplebar/dist/simplebar.js"></script>
		<script src="<?= URL ?>js/application.js?v=<?= APP_VERSION ?>"></script>

		<!-- -----RMS CDN Scripts----- -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
		</script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer">
		</script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pako/2.1.0/pako.min.js" integrity="sha512-g2TeAWw5GPnX7z0Kn8nFbYfeHcvAu/tx6d6mrLe/90mkCxO+RcptyYpksUz35EO337F83bZwcmUyHiHamspkfg==" crossorigin="anonymous" referrerpolicy="no-referrer">
		</script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/intro.min.js" crossorigin="anonymous" referrerpolicy="no-referrer">
		</script>
		<!-- <script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-inline@43.1.0/build/ckeditor.min.js"></script> -->

		<!-- Inline Element Edit -->
		<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>


		<?php
		if (!empty($pluginJS)) {
			foreach ($pluginJS as $v) {
				if (file_exists(ROOT . "public/plugins/" . $v . ".js")) { ?>
					<script src="<?= URL ?>plugins/<?= $v ?>.js"></script>
		<?php }
			}
		}
		?>

		<?php if ($this->urlDetails["controller"] && file_exists(ROOT . "public/js/page/" . $this->urlDetails['controller'] . ".js")) { # page script 
		?>
			<script src="<?= URL ?>js/page/<?= $this->urlDetails["controller"]; ?>.js?v=<?= APP_VERSION ?>"></script>
		<?php } ?>

		<?php
		if (!empty($customJS)) {
			foreach ($customJS as $v) {
				if (file_exists(ROOT . "public/js/custom/" . $v . ".js")) { ?>
					<script src="<?= URL ?>js/custom/<?= $v ?>.js?v=<?= APP_VERSION ?>"></script>
		<?php }
			}
		}
		?>

		</body>

		</html>