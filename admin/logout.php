<?php
include '../database/connection.php';

session_start();
session_unset();
session_destroy();

header('Location: admin_login.php');
