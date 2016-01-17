<?php
/**
 * Created by PhpStorm.
 * User: Fox
 * Date: 09/01/2016
 * Time: 14:30
 */
session_start();
session_destroy();
header("Location:main.php");

?>