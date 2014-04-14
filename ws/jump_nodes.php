<?php
include 'models.php';
header('Content-Type: application/json');
echo json_encode(jump_nodes(0.5));//
