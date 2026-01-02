<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to landing page (login page)
header("Location: landing_page.php");
exit;
