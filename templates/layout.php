<!DOCTYPE html>
<html lang="en">

<?php require("templates/includes/head.php"); ?>

<body>

  <?php require("templates/includes/header.php"); ?>

  <main>
    <?php require($content); ?>
  </main>

  <?php require("templates/includes/footer.php"); ?>

  <script src="public/js/app.js"></script>
  <?= $js ?? ""; ?>
</body>

</html>