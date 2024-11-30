<?php

require_once "core.php";

$query      = $connect->query("SELECT * FROM candidates");
$candidates = $query->fetchAll(PDO::FETCH_OBJ);

$pageTitle = "Candidatos";
include "views/candidates.view.php";