<!-- Js Bootstrap-->
<script src="<?= SITE_URL ?>/assets/js/piruui.js"></script>
<script src="<?= SITE_URL ?>/assets/js/prism.js"></script>
<script src="<?= SITE_URL ?>/assets/js/extra.js"></script>
<script src="<?= SITE_URL ?>/assets/js/toastifyjs.js"></script>

<?php block("script"); ?>

<?= $messageHandler->displayToasts(); ?>
</body>

</html>