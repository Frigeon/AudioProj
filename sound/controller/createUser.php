<?php

include '../model/db.php';

$con = new DB();
$con->connect();
var_dump($con->db);