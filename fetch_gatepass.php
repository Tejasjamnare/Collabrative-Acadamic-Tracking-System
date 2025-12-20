<?php
include 'db_config.php';

$query = "SELECT * FROM gate_pass WHERE status = 'Pending'";
$result = $conn->query($query);

$gatepass_data = [];

while ($row = $result->fetch_assoc()) {
    $gatepass_data[] = $row;
}

echo json_encode($gatepass_data);

$conn->close();
?>
