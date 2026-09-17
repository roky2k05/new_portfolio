<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: admin/logout.php
 */
session_start();
session_unset();
session_destroy();
header('Location: login.php');
exit;
