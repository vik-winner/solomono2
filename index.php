<?php
$start = microtime(true);

$dsn = "mysql:host=mariadb;dbname=solomono";
$db = new PDO($dsn, "solomono", "Solomono20!");
$result = [];

$query = $db->query("SELECT categories_id FROM categories");
while ($row = $query->fetch()) {
    $parent = $db->query("SELECT categories_id FROM categories WHERE parent_id={$row['categories_id']}");
    if ($parents = $parent->fetchAll()) {
        foreach ($parents as $parent) {
            $result[$row['categories_id']][$parent['categories_id']] = $parent['categories_id'];
        }
    } else {
        $result[$row['categories_id']] = $row['categories_id'];
    }

}
foreach ($result as $key => $value) {
    if (is_array($value)) {
        foreach ($value as $value1) {
            $result1[$key][$value1] = $result[$value1];
        }
    } else {
        $result1[$key] = $value;
    }
}

var_dump($result1);
echo 'Время выполнения скрипта: '.round(microtime(true) - $start, 4).' сек.';
