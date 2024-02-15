<?php
/**
 custom functions added 
 */



function enqueue_select2() {
    // Enqueue Select2 CSS
    wp_enqueue_style('select2-css', get_template_directory_uri() . '/select2.min.css', array(), '4.0.13');

    // Enqueue jQuery (if not already enqueued)
    wp_enqueue_script('jquery');

    // Enqueue Select2 JS
    wp_enqueue_script('select2-js', get_template_directory_uri() . '/select2.min.js', array('jquery'), '4.0.13', true);
    
    // Enqueue your custom script to initialize Select2
    wp_enqueue_script('custom-select2-init', get_template_directory_uri() . '/OrderForm.php', array('select2-js'), '1.0', true);
}

add_action('wp_enqueue_scripts', 'enqueue_select2');

// Enqueue the custom js
function enqueue_custom_scripts() {
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/custom.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

// Enqueue the custom styles
function enqueue_custom_styles() {
    
    wp_enqueue_style('custom-styles', get_template_directory_uri() . '/custom-styles.css', array(), '1.0', 'all');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');




if (isset($_POST['sbmt'])) {
    $product_names = implode(',', $_POST['orderedSelection']);
    $poso = implode(',', $_POST['quantities']);
        
    $data = array(
        'first' => $_POST['fname'],
        'last' => $_POST['lname'],
        'address' => $_POST['add'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'product_name' => $product_names,
        'quantity' => $poso,
        'executed' => 'no'
    );
    $data['first'] = ucfirst($data['first']);
    $data['last'] = ucfirst($data['last']);
    $data['address'] = ucwords($data['address']);
    $table_name = 'wp_orders';
    $result = $wpdb->insert($table_name, $data, $format = NULL);

       if ($result == 1) {
        $price = round($_POST['price'], 2);
        $productNames = explode(',', $data['product_name']);
        $quantities = explode(',', $data['quantity']);

        // Initialize an array to hold the formatted product names with quantities
        $formattedProductNames = array();

        // Loop through the product names and match them with their quantities
        foreach ($productNames as $index => $productName) {
            // Replace hyphens with spaces for display
            $productName = str_replace('-', ' ', $productName);
            $quantity = $quantities[$index];

            // If the quantity is more than one, append it to the product name
            $formattedName = ($quantity > 1) ? "{$productName} ({$quantity})" : $productName;
            $formattedProductNames[] = $formattedName;
        }

        // Join the formatted names with a comma and a space
        $productNames1 = implode(', ', $formattedProductNames);
        require('fpdf/fpdf.php'); // Include FPDF library
        include('fpdf/DejaVuSans.php');

        // Create a PDF document
        $pdf = new FPDF();
        $pdf->AddFont('DejaVuSans','','DejaVuSans.php');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        
        $pdf->Cell(40, 10, 'Here are your Order Details:');

        // Add form data to the PDF
        
        $pdf->Ln(20);
        $pdf->SetFont('Arial', 'B', 12);  // Set the font to bold
		$pdf->Cell(30, 10, "First Name:", 0);
		$pdf->SetFont('DejaVuSans', '', 12);  // Reset the font to regular
		$pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-7', $data['first']), 0, 1);

		$pdf->SetFont('Arial', 'B', 12);  // Set the font to bold
		$pdf->Cell(30, 10, "Last Name:", 0);
		$pdf->SetFont('DejaVuSans', '', 12);  // Reset the font to regular
		$pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-7', $data['last']), 0, 1);

		$pdf->SetFont('Arial', 'B', 12);  // Set the font to bold
		$pdf->Cell(30, 10, "Address:", 0);
		$pdf->SetFont('DejaVuSans', '', 12);  // Reset the font to regular
		$pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-7', $data['address']), 0, 1);
               
        $pdf->SetFont('Arial', 'B', 12);  // Set the font to bold
		$pdf->Cell(30, 10, "Email:", 0);
		$pdf->SetFont('DejaVuSans', '', 12);  // Reset the font to regular
		$pdf->Cell(0, 10, $data['email'], 0, 1);

		$pdf->SetFont('Arial', 'B', 12);  // Set the font to bold
		$pdf->Cell(30, 10, "Phone:", 0);
		$pdf->SetFont('DejaVuSans', '', 12);  // Reset the font to regular
		$pdf->Cell(0, 10, $data['phone'], 0, 1);

		$pdf->SetFont('Arial', 'B', 12);  // Set the font to bold
        $pdf->Cell(30, 10, "Product(s):", 0);
        $pdf->SetFont('DejaVuSans', '', 12);  // Reset the font to regular
        $pdf->MultiCell(0, 10, $productNames1, 0, 1);
		
        
        $pdf->SetFont('Arial', 'B', 12);  // Set the font to bold
        $pdf->Cell(30, 10, "Price:", 0);
        $pdf->SetFont('DejaVuSans', '', 12);  // Reset the font to regular
        $pdf->Cell(0, 10, $price . " euros", 0, 1);
               
        $pdf->Ln(25);
        $pdf->SetFont('Helvetica', 'B', 14);
        $pdf->Cell(0, 10, "Thank you for choosing e-shopaholic", 0, 0, 'C');
         
        
        //get last id
        $orderId = $wpdb->insert_id;
        $num = count($_POST['sele']);
            
        $quanquan = explode(',', $_POST['quantities'][0]);

        // Convert the array values to integers
        $quanquan = array_map('intval', $quanquan);

        // Calculate the sum of quantities
        $sum = array_sum($quanquan);
               
        // Output the PDF       
        $pdf->Output('F', 'OrderDetails_' . $orderId . '.pdf');
               
		header("Location: http://e-shopaholic.atwebpages.com/151-2/?order_id=" . urlencode($orderId) . "&sum=" . urlencode($sum));
        exit();
        } else {
        echo "<script>alert('Unable to Save your Data...please try again Later!');</script>";
    }
}
