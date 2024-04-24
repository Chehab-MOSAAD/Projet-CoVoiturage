<?php
require 'db.php';
$query = $db->query('SELECT version()');
$version = $query->fetch();
echo "La version de PostgreSQL est : " . $version[0];
?>
