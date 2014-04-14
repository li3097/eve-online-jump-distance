<?php
include 'models.php';
header('Content-Type: application/json');
echo json_encode(systems_ac(0.5));