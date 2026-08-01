<?php
session_start();
session_destroy();
header('Location: ../../frontend/pages/index.html');
exit;
