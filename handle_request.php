<?php
// handle-request.php
date_default_timezone_set('Europe/Athens');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    // Retrieve the existing messages array from the file
    $existingMessages = json_decode(file_get_contents('status.json'), true);

    // Extract order ID from the message
    preg_match('/Order id\s*(\d+)\D/is', $message, $matches);
    $orderId = isset($matches[1]) ? $matches[1] : null;

    // If a new order ID is found, start a new chain
    if ($orderId !== null) {
        $existingMessages[] = [
            'order_id' => $orderId,
            'chain' => []
        ];
    }

    // Add the new message to the chain along with a timestamp
    $newMessage = [
        'timestamp' => date('Y-m-d H:i:s') . ' (GMT+2)',
        'message' => $message,
    ];

    // Add the new message to the last chain in the array
    end($existingMessages);
    $lastKey = key($existingMessages);
    $existingMessages[$lastKey]['chain'][] = $newMessage;

    // Save the updated array back to the file
    file_put_contents('status.json', json_encode($existingMessages));

        if ($orderId !== null) {
            // Include WordPress
            require_once('../../../wp-load.php');

            global $wpdb;

            // Check if the order has not been executed yet
            $table_name = $wpdb->prefix . 'orders';
            $executed_status = $wpdb->get_var($wpdb->prepare("SELECT executed FROM $table_name WHERE id0 = %d", $orderId));

            if ($executed_status !== 'yes') {
                // Update the 'executed' field in the database
                $result = $wpdb->update($table_name, array('executed' => 'yes'), array('id0' => $orderId));
            }
        }


    // Send a response back to the ESP8266
    echo 'OK';
} else {
    http_response_code(405);
    echo 'Method Not Allowed';
}
?>




