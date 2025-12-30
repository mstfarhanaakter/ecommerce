<?php
include 'database.php';

$sql = "SELECT * FROM users";
$result = $con->query($sql);

if ($result) {
    echo "Query success! Total rows: " . $result->num_rows;
} else {
    echo "Query failed!";
}
?>
