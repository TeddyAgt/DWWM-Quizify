<!DOCTYPE html>
<html lang="en">

<?php require("templates/includes/head.php"); ?>

<body>

  <?php require("templates/includes/header.php"); ?>


  <?php require($content); ?>


  <?php require("templates/includes/footer.php"); ?>

  <script src="public/js/app.js"></script>
  <?= $js ?? ""; ?>
</body>

</html>