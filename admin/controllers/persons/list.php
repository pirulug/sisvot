<?php

require_once "../../core.php";

$accessControl->check_access([1, 2]);

$search = isset($_GET['search']) ? $_GET['search'] : '';
$page   = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit  = 10;
$offset = ($page - 1) * $limit;

$orderColumn    = 'user_id';
$orderDirection = 'DESC';

$currentUserId = $_SESSION['user_id'];

// Condiciones adicionales dinámicas
$searchColumns = ['user_name', 'user_email'];

$additionalConditions = [
  [
    'sql'   => 'user_role != 1',
    'param' => null,
    'value' => null,
    'type'  => null,
  ],
  [
    'sql'   => 'user_id != :currentUserId',
    'param' => ':currentUserId',
    'value' => $currentUserId,
    'type'  => PDO::PARAM_INT,
  ]
];

$total_results = getTotalResults('users', $searchColumns, $search, $additionalConditions, $connect);
$total_pages   = ceil($total_results / $limit);

$users = getPaginatedResults('users', $searchColumns, $search, $additionalConditions, $limit, $offset, $connect, $orderColumn, $orderDirection);


/* ========== Theme config ========= */
$theme_title = "Lista de usuarios";
$theme_path  = "persons-list";
include BASE_DIR_ADMIN . "/views/persons/list.view.php";
/* ================================= */