<?php
/* Template Name: orderForm */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
    header('Content-Type: text/html; charset=utf-8');
}

get_header(); ?>

<?php if ( astra_page_layout() == 'left-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

	<div id="primary" <?php astra_primary_class(); ?>>

		<?php astra_primary_content_top(); ?>

		<?php astra_content_page_loop(); ?>

		<?php astra_primary_content_bottom(); ?>
            


            


<div class="form-background">
<h3>            Place your order in the Form below!</h3>
<form action="" method="POST" class="form-1">   
 	<li>
First Name *
<input type="text" id="fname" name="fname" required="" class="box-1"></li>

 	<li>
Last Name *
<input type="text" id="lname" name="lname" required="" class="box-1"></li>


 	<li>
Street Address *
<input type="text" id="add" name="add" placeholder="House number and street name" required="" class="box-1"></li>
    
   <li>
E-mail *
<input type="email" id="email" name="email" placeholder="John@gmail.com" required="" class="box-1"></li>
        
   <li>
Phone number 
<input type="text" id="phone" name="phone" maxlength="10" class="box-1"></li>
        
<input type="hidden" id="priceInput" name="price" value="0">
<input type="hidden" id="quantitiesInput" name="quantities[]" value="">
<input type="hidden" id="orderedSelection" name="orderedSelection[]"> 	
 	
 	
 	<li>
Selected Products *
<select id="sele" class="select2" name="sele[]"  multiple="multiple">
<optgroup label="Kitchen">
<option data-img_src="/wp-content/themes/astra/images/coaster2.png" value="Sports-drink-coasters">Sports drink coaster</option>
<option data-img_src="/wp-content/themes/astra/images/coaster1.png" value="Grey-drink-coasters">Grey drink coaster</option>
<option data-img_src="/wp-content/themes/astra/images/plastic containers 1.png" value="Blue-plastic-containers">Blue plastic containers</option>
<option data-img_src="/wp-content/themes/astra/images/plastic conteiners 2.jpg" value="Orange-plastic-containers">Orange plastic containers</option>
</optgroup>
<optgroup label="Living Room">
<option data-img_src="/wp-content/themes/astra/images/lamp cover 1.png" value="Lamp-cover">Lamp cover</option>
<option data-img_src="/wp-content/themes/astra/images/candles 1.png" value="Grey-candles">Grey candles</option>
<option data-img_src="/wp-content/themes/astra/images/lamp-2.jpg" value="Mushroom-lamp">Mushroom lamp</option>
<option data-img_src="/wp-content/themes/astra/images/lamp 1.png"value="Pink-table-lamp">Pink table lamp</option>
<option data-img_src="/wp-content/themes/astra/images/clock 2.png" value="Sharp-digital-clock">Sharp digital clock</option>
<option data-img_src="/wp-content/themes/astra/images/clock-1.jpg" value="Black-digital-clock">Black digital clock</option>
</optgroup>
<optgroup label="Office">
<option data-img_src="/wp-content/themes/astra/images/cam2.jpg" value="TEXET-web-cam">TEXET web cam</option>
<option data-img_src="/wp-content/themes/astra/images/web cam 1.jpg" value="Logitech-web-cam">Logitech web cam</option>
<option data-img_src="/wp-content/themes/astra/images/usb 2.png" value="SONY-USB-stick">SONY USB stick</option>
<option data-img_src="/wp-content/themes/astra/images/usb 1.jpg" value="Cruzer-USB-stick">Cruzer USB stick</option>
<option data-img_src="/wp-content/themes/astra/images/handsfree 1.png" value="Ideus-handsfree">Ideus handsfree</option>
<option data-img_src="/wp-content/themes/astra/images/handsfree 2.png" value="Black-handsfree">Black handsfree</option>
</optgroup>
</select></li>
        
<p id="totalMessage"></p>
<button type="submit" name="sbmt" class="button-1" >Submit</button>
</form>
</div>
           


	</div><!-- #primary -->

<script>
    // Pre-selecting the products and quantities from the drop-down menu

    const urlParams = new URLSearchParams(window.location.search);
    const seleParam = urlParams.get("sele");
    const quanParam = urlParams.get("quan");

    if (seleParam && quanParam) {
        const productNames = seleParam.split(',');
        const quantities = quanParam.split(',');

        const dropdown = document.getElementById("sele");

        if (dropdown && productNames.length === quantities.length) {
            for (let i = 0; i < productNames.length; i++) {
                const productName = productNames[i];
                const quantity = quantities[i];
                const option = Array.from(dropdown.options).find(option => option.value === productName);

                if (option) {
                    option.selected = true;
                }

                // Update quantities in your logic (e.g., use the quantities array)
                // You can access the quantity for each product using quantities[i]
            }
        }
    }
</script>

<script>
jQuery(document).ready(function($) {
    // Function to format the dropdown options with images
    function formatState (state) {
        if (!state.id) {
            return state.text;
        }
        var $state = $(
            '<span><img src="' + $(state.element).data('img_src') + '" class="img-flag" /> ' + state.text + '</span>'
        );
        return $state;
    };

    // Function to format the selected items with quantity buttons
	function formatSelection(state) {
            if (!state.id) {
                return state.text;
            }
            var quantity = itemQuantities[state.id] || 1; // Default quantity to 1 if not set
            
            var $img = $('<img class="img-flag">').css({
        		width: '50px', 
       	 		height: '50px', 
        		marginRight: '10px'
    		}).attr('src', $(state.element).data('img_src'));

            // Create the minus button with inline styles
            var $minusButton = $('<button type="button" class="quantity-minus" data-item-id="' + state.id + '">-</button>').css({
                padding: '0 5px',
                margin: '0 2px 0 10px',
                
                fontSize: '12px',
                lineHeight: '1.5',
                backgroundColor: '#f2f2f2',
                color: '#333',
                border: '1px solid #aaa',
                borderRadius: '4px',
                cursor: 'pointer'
            });

            // Create the plus button with inline styles
            var $plusButton = $('<button type="button" class="quantity-plus" data-item-id="' + state.id + '">+</button>').css({
                padding: '0 5px',
                margin: '0 2px',   
                fontSize: '12px',
                lineHeight: '1.5',
                backgroundColor: '#f2f2f2',
                color: '#333',
                border: '1px solid #aaa',
                borderRadius: '4px',
                cursor: 'pointer'
            });
            
			
            
            // Create the quantity display span
            var $quantityDisplay = $('<span class="quantity">' + quantity + '</span>');

            // Combine them into the quantity controls container
            var $quantityControls = $('<span class="quantity-controls"></span>')
                .append($minusButton, $quantityDisplay, $plusButton);

            // Create the selection item
            var $selection = $('<span class="selection-item"></span>')
        		.append($img, state.text, $quantityControls);
            
            $selection.css({
                display: 'flex',
                alignItems: 'center',
                padding: '4px',
                marginBottom: '4px',
                marginTop: '4px',
                marginLeft: '4px',
                backgroundColor: '#fff',
                border: '1px solid black',
                borderRadius: '4px',                
                boxShadow: '0 2px 4px rgba(0, 0, 0, 0.1)'
            });

            
            
            return $selection;
       
            
        }
    var selectionOrder = []; // Array to keep track of the selection order
    var itemQuantities = {}; // Object to store item quantities
	
    // Initialize the Select2 component
    $('#sele').select2({
        theme: 'default',
        width: '350px',
        placeholder: 'Product List',
        templateResult: formatState,
        templateSelection: formatSelection, // Separate function for formatting selections
            
    });
        

      
       
     function updateSelectionDisplay() {
        // Clear the current selections in the display
        var $rendered = $('#sele').next('.select2-container').find('.select2-selection__rendered');
        $rendered.empty();

        // Append selections in the order they were added with quantity controls
        selectionOrder.forEach(function(id) {
            var option = $('#sele').find('option[value="' + id + '"]')[0];
            var quantity = itemQuantities[id] || 1; // Use 1 as the default quantity
            var $selection = formatSelection({id: id, text: option.text, element: option});
            $rendered.append($selection);
        });
    }
        
         // Initialize selectionOrder from URL parameter if present   
function initializeSelectionsFromUrl() {
    var searchParams = new URLSearchParams(window.location.search);
    var seleValues = searchParams.get('sele');
    var quanValues = searchParams.get('quan');

    if (seleValues && quanValues) {
        var productNames = seleValues.split(',').map(decodeURIComponent);
        var quantities = quanValues.split(',').map(Number); // Convert string quantities to numbers

        if (productNames.length === quantities.length) {
            selectionOrder = productNames;
            productNames.forEach(function (productName, index) {
                itemQuantities[productName] = quantities[index]; // Initialize with the provided quantity
                $('#sele').find('option[value="' + productName + '"]').prop("selected", true);
            });

            // Trigger the change event to make Select2 aware of the preselected items
            $('#sele').trigger('change');

            // Delay the update to ensure Select2 has finished initializing
            setTimeout(updateSelectionDisplay, 0);
        }
    }
}
   
     initializeSelectionsFromUrl(); 

    function updateTotal() {
        var total = 0;
        var quantitiesArray = [];    
        selectionOrder.forEach(function(itemId) {
            total += (productPrices[itemId] || 0) * (itemQuantities[itemId] || 0);
            var quantity = itemQuantities[itemId] || 0;
            quantitiesArray.push(quantity);    
        });
        $('#totalMessage').html('Your total is ' + total.toFixed(2) + '€');
        document.getElementById("priceInput").value = total;
        document.getElementById("quantitiesInput").value = quantitiesArray;
        document.getElementById("orderedSelection").value = selectionOrder;
    }

    // Event handlers for quantity controls
    $(document).on('click', '.quantity-minus', function(event) {   
        var itemId = $(this).data('item-id');
        var currentQuantity = itemQuantities[itemId];
        if (currentQuantity > 1) {
            itemQuantities[itemId]--;
        } else {
            var index = selectionOrder.indexOf(itemId);
            if (index > -1) {
                selectionOrder.splice(index, 1);
                delete itemQuantities[itemId];
                $('#sele').find('option[value="' + itemId + '"]').prop("selected", false);
                $('#sele').trigger('change');
            }
        }
        updateSelectionDisplay();
        updateTotal();
            
            
    });

    $(document).on('click', '.quantity-plus', function(event) {
            
            
        var itemId = $(this).data('item-id');
        itemQuantities[itemId] = (itemQuantities[itemId] || 0) + 1;
        updateSelectionDisplay();
        updateTotal();
            
        
    });

    // Prevent default behavior for quantity controls
        $(document).on('mousedown', '.quantity-minus, .quantity-plus', function (event) {
            event.preventDefault();
        });

        // Toggle dropdown on quantity controls click
        $(document).on('click', '.quantity-controls', function (event) {
            var $select2 = $('#sele').data('select2');
            if ($select2.isOpen()) {
                $select2.close();
            } else {
                $select2.open();
            }
        });

        // Close dropdown on outside click
        $(document).on('click', function (event) {
            var $target = $(event.target);
            var $select2 = $('#sele').data('select2');
            if ($target.closest('.select2-container').length === 0 && $select2.isOpen()) {
                $select2.close();
            }
        });

    $('#sele').on('select2:select', function(e) {
        var id = e.params.data.id;
        if (!selectionOrder.includes(id)) {
            selectionOrder.push(id);
            itemQuantities[id] = 1; // Initialize with a quantity of 1
        }
        updateSelectionDisplay();
        updateTotal();
    }).on('select2:unselect', function(e) {
        var id = e.params.data.id;
        var index = selectionOrder.indexOf(id);
        if (index > -1) {
            selectionOrder.splice(index, 1);
            delete itemQuantities[id];
        }
        updateSelectionDisplay();
        updateTotal();
    });

    $('#sele').on('change', function() {
        updateTotal();
    });
	

    $('#sele').trigger('change'); // Trigger change event to initialize the total message
});
</script>



<script>
        
    //Handling the price
        
    var productPrices = {
      "": 0,
      "Sports-drink-coasters": 9.99,
      "Grey-drink-coasters": 4.50,
      "Blue-plastic-containers": 6.49,
      "Orange-plastic-containers": 4.99,
      "Lamp-cover": 9.99,
      "Grey-candles": 6.79,
      "Mushroom-lamp": 14.99,
      "Pink-table-lamp": 13.49,
      "Sharp-digital-clock": 20.99,
      "Black-digital-clock": 22.59,
      "TEXET-web-cam": 36.99,
      "Logitech-web-cam": 45.99,
      "SONY-USB-stick": 14.99,
      "Cruzer-USB-stick": 13.49,
      "Ideus-handsfree": 23.99,
      "Black-handsfree": 17.49,
    };

  
    	// reset the cart
        document.addEventListener('DOMContentLoaded', function() {
            // Clear the selected products from local storage
            localStorage.removeItem('selectedProducts');

            // Optionally, you can also reset the cart count display if it's on the page
            var cartCountElement = document.querySelector('#menu-item-317 .cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = '0';
                cartCountElement.style.display = 'none';
            }
        });
        
  </script>



<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>
<style>
	

/* CSS */
.button-1 {
  background-color: #CCC281;
  border-radius: 8px;
  border-style: none;
  box-sizing: border-box;
  color: #FFFFFF;
  cursor: pointer;
  display: inline-block;
  font-family: "Haas Grot Text R Web", "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 14px;
  font-weight: 500;
  height: 40px;
  line-height: 20px;
  list-style: none;
  margin-left: 10px;
  outline: none;
  padding: 10px 16px;
  position: relative;
  text-align: center;
  text-decoration: none;
  transition: color 100ms;
  vertical-align: baseline;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  
}
        
#fname{
	margin-left: 56px;        
}
#lname{
	margin-left: 56px;        
}
#add{
	margin-left: 29px;        
} 
#email{
	margin-left: 88px;        
} 
#phone{
	margin-left: 41px;        
} 
        
.form-background {
    background-image: url('/wp-content/themes/astra/images/back.png');
    background-size: cover;
    background-position: center;
    background-attachment: fixed; /* Keeps the background fixed with the viewport */
    padding: 60px;
    min-height: 100vh; /* Adjust as needed for your design */
}

@media screen and (max-width: 768px) {
    .form-background {
        background-size: contain; /* or adjust as necessary for smaller screens */
    }
}
        
        
li {
  padding-left: 20px; 
}
       
h3 {
  font-family: "Lucida Console", "Courier New", monospace;
  color: #CCC281;
  padding-left: 20px;
  margin:20px;
  margin-top: 150px;      
}
       
#totalMessage{
	margin-left:10px;        
        
}

.button-1:hover,
.button-1:focus {
  background-color: #E0A526;
}
		
.form-1 {
	box-shadow:0 0 15px 4px rgba(0,0,0,0.2);
	border-radius: 30px;
	margin:30px 0;
	padding:60px 0;
    width: 50%;
    margin-left: 20px;
    background-color: #ffffff
    }
               
        
input[type=text] {
    border: 1px  solid black;
    border-radius: 10px;
	background-color: #f1f1f1;
    }
		
input[type=tel] {
    border: 1px solid black;
    border-radius: 10px;
	background-color: #f1f1f1;
    }
        
input[type=email] {
    border: 1px solid black;
    border-radius: 10px;
	background-color: #f1f1f1;
	}
		
.box-1 {
	margin:10px 0;
	border-radius:10px;
	border: 1px solid black;
        
    }
        
input:-webkit-autofill {
    -webkit-box-shadow:0 0 0 50px #f1f1f1 inset; 
    -webkit-text-fill-color: #333;
}   
        
.select2-selection--multiple {
	min-height: 50px !important;
	margin:10px 0;
    border: 1px solid black !important;
    border-radius: 10px !important;
    background-color: #f1f1f1 !important;
    margin-left: 8px;            
}
.select2-search__field {
    text-align: left !important;
}        

 .select2-selection__rendered {
      border-radius:10px !important;   
      width: 100%;
      padding: 0 !important;
      margin: 0 !important;
}
      
.select2-results__option img {
    width: 40px !important; /* Adjust as needed */
    height: 40px !important; /* Adjust as needed */
    margin-right: 10px !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice img {
    width: 50px !important; /* Adjust as needed */
    height: 50px !important; /* Adjust as needed */
    margin-right: 10px !important;
}
.select2-results__option img.img-flag {
    width: 50px !important; /* Or the width of your choice */
    height: 50px !important; /* Keep the aspect ratio */
    margin-right: 10px !important;
}
        

</style>