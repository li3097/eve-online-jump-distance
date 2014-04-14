<?php
include 'models.php';
header('Content-Type: application/json');
echo json_encode(systemsByID(0.5));