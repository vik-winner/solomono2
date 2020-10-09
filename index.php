<?php
$start = microtime(true);

$dsn = "mysql:host=mariadb;dbname=solomono";
$option = [
    PDO::ATTR_STRINGIFY_FETCHES => false,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$db = new PDO($dsn, "solomono", "Solomono20!" , $option);

$query = $db->query("SELECT categories_id, parent_id FROM categories");
$result = $query->fetchAll();
$tree = [];
foreach ($result as $key => $value) {
    $tree[$value['parent_id']][$value['categories_id']] = &$tree[$value['categories_id']];
}
foreach ($tree as $key => $value) {
    if($tree[$key] === null) {
        $tree[$key] = $key;
    }
}

var_dump($tree[0]);
echo 'Время выполнения скрипта: '.round(microtime(true) - $start, 4).' сек.';
