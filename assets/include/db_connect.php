
<?php
$conn = new mysqli('localhost', 'root', '', 'jobverse');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>