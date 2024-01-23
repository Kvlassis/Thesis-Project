<?php
/* Template Name: success */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

session_start();

get_header();
?>

<?php if (astra_page_layout() == 'left-sidebar') : ?>
    <?php get_sidebar(); ?>
<?php endif ?>
<?php
$orderId = isset($_GET['order_id']) ? $_GET['order_id'] : null;
date_default_timezone_set('Europe/Athens');

$firstName = '';
$lastName = '';
$timestamp = '';

// Retrieve additional information from the database based on $orderId
if ($orderId) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'orders'; // Replace 'your_table_name' with your actual table name

    $result = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE id0 = %d",
        $orderId
    ));

    if ($result) {
        $firstName = $result->first;
        $lastName = $result->last;
        // Use the current time as a placeholder for timestamp
        $timestamp = date("Y-m-d H:i:s");
    }
}
?>

<div id="primary" <?php astra_primary_class(); ?>>

    <?php astra_primary_content_top(); ?>

    
        <h3>Order no <?php echo $orderId; ?> placed by <?php echo $firstName . ' ' . $lastName; ?> on <?php echo $timestamp; ?> (GMT+2) : received</h3>
        <p>You can view your order details <a href="<?php echo esc_url(home_url('/OrderDetails_' . $orderId . '.pdf')); ?>" target="_blank">here</a>.</p>


    <div>E-fetcher activity for collecting your items</div>
    <div id="orderStatus"></div>

<script>
    const orderStatusElement = document.getElementById('orderStatus');
    const urlParams = new URLSearchParams(window.location.search);
    const orderId = urlParams.get('order_id');
    const numMessages = parseInt('<?php echo isset($_GET['sum']) ? $_GET['sum'] : 0; ?>', 10);
    let messagesDisplayed = 0;
    let offlineMessageDisplayed = false;
    
    function showOfflineMessage() {
        if (!offlineMessageDisplayed) {
            var offlineMessageElement = document.createElement('div');
            offlineMessageElement.innerHTML = `<div>System is offline and will process your order later.</div>`;
            orderStatusElement.appendChild(offlineMessageElement);
            offlineMessageDisplayed = true;
        }
    }

    // Setup a timeout to show an offline message if no messages are received within 5 seconds
    let offlineTimer = setTimeout(showOfflineMessage, 8000);

    function updateOrderStatus() {
        fetch(`http://e-shopaholic.atwebpages.com/wp-content/themes/astra/get-status.php?order_id=${orderId}`)
            .then(response => response.json())
            .then(data => {
                // Find the relevant order by order_id
                const order = data.find(order => order.order_id === orderId);
                if (!order) {
                    console.error('No order found with the given order_id.');
                    return;
                }
                
                // Cancel the offline message timer if we get a response
                clearTimeout(offlineTimer);
                
                // Process each message in the chain
                order.chain.forEach(message => {
                    // Check if the message is already displayed
                    if (!document.querySelector(`[data-timestamp="${message.timestamp}"]`)) {
                        const messageElement = document.createElement('div');
                        messageElement.setAttribute('data-timestamp', message.timestamp);
                        messageElement.innerHTML = `
                        		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05"/>
                                </svg>
                                <span>${message.timestamp}</span> - ${message.message}`;
                        orderStatusElement.appendChild(messageElement);
                        messagesDisplayed++;
                    }
                });

                // Check if we have displayed all messages
                if (messagesDisplayed >= numMessages + 1) {
                    clearInterval(intervalId);
                    addCompletionMessage();
                    clearStatusMessages();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                clearInterval(intervalId);
            });
    }

    function addCompletionMessage() {
        // Only append the completion message if it hasn't been appended yet
        if (!document.getElementById('completion-message')) {
            const completionMessageElement = document.createElement('div');
            completionMessageElement.id = 'completion-message';
            completionMessageElement.innerHTML = `
            			<span>___________________________________</span>
                        <br>
                        <span>Order items collection: completed</span>
                        `;
            orderStatusElement.appendChild(completionMessageElement);
        }
    }

    function clearStatusMessages() {
        fetch(`http://e-shopaholic.atwebpages.com/wp-content/themes/astra/clear-status.php?order_id=${orderId}`, {
            method: 'POST'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            console.log('Status messages cleared:', data);
        })
        .catch(error => console.error('Error clearing status messages:', error));
    }

    // Start polling
    const intervalId = setInterval(updateOrderStatus, 1000);
    updateOrderStatus(); // Initial call
</script>




    

    <?php astra_primary_content_bottom(); ?>

</div><!-- #primary -->

<?php if (astra_page_layout() == 'right-sidebar') : ?>
    <?php get_sidebar(); ?>
<?php endif ?>

<?php get_footer(); ?>

<?php ?>


<style>
     
   
   h3{
        margin-top:150px;
        
        }     
    
</style>
