<?php
include 'models.php';
header('Content-Type: application/json');
echo json_encode(systems_by_id(0.5));