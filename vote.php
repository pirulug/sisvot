<?php

require_once "core.php";

$query      = $connect->query("SELECT * FROM candidates");
$candidates = $query->fetchAll(PDO::FETCH_OBJ);

$pageTitle = "Formulario de votación";
include "views/vote.view.php";