<?php
// Single unified auth page used. Redirect legacy login page to auth.php
session_start();
header('Location: auth.php?tab=login');
exit();

