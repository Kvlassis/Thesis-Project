<?php
/**
 * Astra functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Define Constants
 */
define( 'ASTRA_THEME_VERSION', '4.1.4' );
define( 'ASTRA_THEME_SETTINGS', 'astra-settings' );
define( 'ASTRA_THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'ASTRA_THEME_URI', trailingslashit( esc_url( get_template_directory_uri() ) ) );
define( 'ASTRA_PRO_UPGRADE_URL', 'https://wpastra.com/pro/?utm_source=dashboard&utm_medium=free-theme&utm_campaign=upgrade-now' );
define( 'ASTRA_PRO_CUSTOMIZER_UPGRADE_URL', 'https://wpastra.com/pro/?utm_source=customizer&utm_medium=free-theme&utm_campaign=upgrade' );

/**
 * Minimum Version requirement of the Astra Pro addon.
 * This constant will be used to display the notice asking user to update the Astra addon to the version defined below.
 */
define( 'ASTRA_EXT_MIN_VER', '4.1.0' );

/**
 * Setup helper functions of Astra.
 */
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-theme-options.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-theme-strings.php';
require_once ASTRA_THEME_DIR . 'inc/core/common-functions.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-icons.php';

/**
 * Update theme
 */
require_once ASTRA_THEME_DIR . 'inc/theme-update/astra-update-functions.php';
require_once ASTRA_THEME_DIR . 'inc/theme-update/class-astra-theme-background-updater.php';

/**
 * Fonts Files
 */
require_once ASTRA_THEME_DIR . 'inc/customizer/class-astra-font-families.php';
if ( is_admin() ) {
	require_once ASTRA_THEME_DIR . 'inc/customizer/class-astra-fonts-data.php';
}

require_once ASTRA_THEME_DIR . 'inc/lib/webfont/class-astra-webfont-loader.php';
require_once ASTRA_THEME_DIR . 'inc/customizer/class-astra-fonts.php';

require_once ASTRA_THEME_DIR . 'inc/dynamic-css/custom-menu-old-header.php';
require_once ASTRA_THEME_DIR . 'inc/dynamic-css/container-layouts.php';
require_once ASTRA_THEME_DIR . 'inc/dynamic-css/astra-icons.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-walker-page.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-enqueue-scripts.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-gutenberg-editor-css.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-wp-editor-css.php';
require_once ASTRA_THEME_DIR . 'inc/dynamic-css/block-editor-compatibility.php';
require_once ASTRA_THEME_DIR . 'inc/dynamic-css/inline-on-mobile.php';
require_once ASTRA_THEME_DIR . 'inc/dynamic-css/content-background.php';
require_once ASTRA_THEME_DIR . 'inc/class-astra-dynamic-css.php';
require_once ASTRA_THEME_DIR . 'inc/class-astra-global-palette.php';

/**
 * Custom template tags for this theme.
 */
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-attr.php';
require_once ASTRA_THEME_DIR . 'inc/template-tags.php';

require_once ASTRA_THEME_DIR . 'inc/widgets.php';
require_once ASTRA_THEME_DIR . 'inc/core/theme-hooks.php';
require_once ASTRA_THEME_DIR . 'inc/admin-functions.php';
require_once ASTRA_THEME_DIR . 'inc/core/sidebar-manager.php';

/**
 * Markup Functions
 */
require_once ASTRA_THEME_DIR . 'inc/markup-extras.php';
require_once ASTRA_THEME_DIR . 'inc/extras.php';
require_once ASTRA_THEME_DIR . 'inc/blog/blog-config.php';
require_once ASTRA_THEME_DIR . 'inc/blog/blog.php';
require_once ASTRA_THEME_DIR . 'inc/blog/single-blog.php';

/**
 * Markup Files
 */
require_once ASTRA_THEME_DIR . 'inc/template-parts.php';
require_once ASTRA_THEME_DIR . 'inc/class-astra-loop.php';
require_once ASTRA_THEME_DIR . 'inc/class-astra-mobile-header.php';

/**
 * Functions and definitions.
 */
require_once ASTRA_THEME_DIR . 'inc/class-astra-after-setup-theme.php';

// Required files.
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-admin-helper.php';

require_once ASTRA_THEME_DIR . 'inc/schema/class-astra-schema.php';

/* Setup API */
require_once ASTRA_THEME_DIR . 'admin/includes/class-astra-api-init.php';

if ( is_admin() ) {
	/**
	 * Admin Menu Settings
	 */
	require_once ASTRA_THEME_DIR . 'inc/core/class-astra-admin-settings.php';
	require_once ASTRA_THEME_DIR . 'admin/class-astra-admin-loader.php';
	require_once ASTRA_THEME_DIR . 'inc/lib/astra-notices/class-astra-notices.php';
}

/**
 * Metabox additions.
 */
require_once ASTRA_THEME_DIR . 'inc/metabox/class-astra-meta-boxes.php';

require_once ASTRA_THEME_DIR . 'inc/metabox/class-astra-meta-box-operations.php';

/**
 * Customizer additions.
 */
require_once ASTRA_THEME_DIR . 'inc/customizer/class-astra-customizer.php';

/**
 * Astra Modules.
 */
require_once ASTRA_THEME_DIR . 'inc/modules/posts-structures/class-astra-post-structures.php';
require_once ASTRA_THEME_DIR . 'inc/modules/related-posts/class-astra-related-posts.php';

/**
 * Compatibility
 */
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-gutenberg.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-jetpack.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/woocommerce/class-astra-woocommerce.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/edd/class-astra-edd.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/lifterlms/class-astra-lifterlms.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/learndash/class-astra-learndash.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-beaver-builder.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-bb-ultimate-addon.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-contact-form-7.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-visual-composer.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-site-origin.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-gravity-forms.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-bne-flyout.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-ubermeu.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-divi-builder.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-amp.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-yoast-seo.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-starter-content.php';
require_once ASTRA_THEME_DIR . 'inc/addons/transparent-header/class-astra-ext-transparent-header.php';
require_once ASTRA_THEME_DIR . 'inc/addons/breadcrumbs/class-astra-breadcrumbs.php';
require_once ASTRA_THEME_DIR . 'inc/addons/scroll-to-top/class-astra-scroll-to-top.php';
require_once ASTRA_THEME_DIR . 'inc/addons/heading-colors/class-astra-heading-colors.php';
require_once ASTRA_THEME_DIR . 'inc/builder/class-astra-builder-loader.php';

// Elementor Compatibility requires PHP 5.4 for namespaces.
if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
	require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-elementor.php';
	require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-elementor-pro.php';
	require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-web-stories.php';
}

// Beaver Themer compatibility requires PHP 5.3 for anonymus functions.
if ( version_compare( PHP_VERSION, '5.3', '>=' ) ) {
	require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-beaver-themer.php';
}

require_once ASTRA_THEME_DIR . 'inc/core/markup/class-astra-markup.php';

/**
 * Load deprecated functions
 */
require_once ASTRA_THEME_DIR . 'inc/core/deprecated/deprecated-filters.php';
require_once ASTRA_THEME_DIR . 'inc/core/deprecated/deprecated-hooks.php';
require_once ASTRA_THEME_DIR . 'inc/core/deprecated/deprecated-functions.php';

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