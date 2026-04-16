<?php

require_once "../db.php";
require_once "../router.php";
require_once "../lib.php";
session_start();
require_once "../controller/page.php";
router::handleRequest();