<?php

require_once("src/Controllers/Homepage.php");

use App\Controllers\Homepage\Homepage;


// Router
try {

  if (isset($_GET["action"])) {
    // 
  } else {
    (new Homepage())->getPage();
  }
} catch (Exception $e) {
  $errorMessage = $e->getMessage();

  require("templates/error.php");
}
