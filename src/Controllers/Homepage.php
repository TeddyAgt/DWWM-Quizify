<?php

namespace App\Controllers\Homepage;

require_once("src/tools/database-connection.php");

class Homepage
{

  public function getPage()
  {
    // fetch les quiz

    require("templates/home/home.php");
  }
}
