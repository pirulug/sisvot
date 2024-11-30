<?php

require_once "../../core.php";

$accessControl->check_access([1, 2]);

$search = isset($_GET['search']) ? $_GET['search'] : '';
$page   = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit  = 10;
$offset = ($page - 1) * $limit;

$orderColumn    = 'candidate_id';
$orderDirection = 'DESC';

// $currentUserId = $_SESSION['candidate_id'];

// Condiciones adicionales dinámicas
$searchColumns = ['candidate_name'];

$additionalConditions = [];

$total_results = getTotalResults('candidates', $searchColumns, $search, $additionalConditions, $connect);
$total_pages   = ceil($total_results / $limit);

$candidates = getPaginatedResults('candidates', $searchColumns, $search, $additionalConditions, $limit, $offset, $connect, $orderColumn, $orderDirection);


/* ========== Theme config ========= */
$theme_title = "Lista de candidatos";
$theme_path  = "candidates-list";
include BASE_DIR_ADMIN . "/views/candidates/list.view.php";
/* ================================= */