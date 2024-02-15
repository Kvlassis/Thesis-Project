<?php
// clear-status.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the order_id from the request parameters
    $orderId = isset($_GET['order_id']) ? $_GET['order_id'] : null;

    if ($orderId !== null) {
        // Retrieve the existing messages array from the file
        $existingMessages = json_decode(file_get_contents('status.json'), true);

        // Remove the messages associated with the given order ID
        $existingMessages = array_map(function ($message) use ($orderId) {
            if (isset($message['order_id']) && $message['order_id'] == $orderId) {
                // Clear only the messages in the chain with the specified order ID
                $message['chain'] = [];
            }
            return $message;
        }, $existingMessages);

        // Save the updated array back to the file
        file_put_contents('status.json', json_encode(array_values($existingMessages)));

        echo 'OK';
    } else {
        http_response_code(400);
        echo 'Bad Request: Missing order_id parameter';
    }
} else {
    http_response_code(405);
    echo 'Method Not Allowed';
}
?>


