<?php

require_once "../../core.php";

$accessControl->check_access([1, 2]);

$search = isset($_GET['search']) ? $_GET['search'] : '';
$page   = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit  = 10;
$offset = ($page - 1) * $limit;

$orderColumn    = 'person_id';
$orderDirection = 'DESC';

// Condiciones adicionales dinámicas
$searchColumns = ['person_dni', 'person_name', 'person_email'];

$additionalConditions = [];

$total_results = getTotalResults('persons', $searchColumns, $search, $additionalConditions, $connect);
$total_pages   = ceil($total_results / $limit);

$persons = getPaginatedResults('persons', $searchColumns, $search, $additionalConditions, $limit, $offset, $connect, $orderColumn, $orderDirection);


/* ========== Theme config ========= */
$theme_title = "Lista de usuarios";
$theme_path  = "persons-list";
include BASE_DIR_ADMIN . "/views/persons/list.view.php";
/* ================================= */