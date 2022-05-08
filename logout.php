<?php
include_once "include.php";
session_destroy();
session_unset();
header("location:login.php");