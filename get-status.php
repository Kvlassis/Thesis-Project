<?php
// get-status.php

// Get the order_id parameter from the URL
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;

// Read the status JSON from the file
$status = file_get_contents('status.json');

// Decode the JSON string into an array
$messages = json_decode($status, true);

// If order_id is provided, filter messages for that order_id
if ($order_id !== null) {
    $filteredMessages = array_filter($messages, function ($message) use ($order_id) {
        return isset($message['order_id']) && $message['order_id'] == $order_id;
    });
    // Convert the filtered messages back to JSON
    $filteredStatus = json_encode(array_values($filteredMessages));
    // Send the filtered status back to the front-end as JSON
    header('Content-Type: application/json');
    echo $filteredStatus;
} else {
    // Send the original status back to the front-end as JSON
    header('Content-Type: application/json');
    echo $status;
}
?>
