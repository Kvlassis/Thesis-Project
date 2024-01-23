// Function to retrieve selected products from local storage or initialize a new array
function getSelectedProducts() {
    if (localStorage.getItem('selectedProducts')) {
        window.selectedProducts = JSON.parse(localStorage.getItem('selectedProducts'));
    } else {
        window.selectedProducts = window.selectedProducts || [];
    }
    return window.selectedProducts;
}

// Function to save the selected products to local storage
function saveSelectedProducts() {
    localStorage.setItem('selectedProducts', JSON.stringify(window.selectedProducts));
}

// Function to create or update the popup content
function updatePopupContent() {
    const selectedProducts = getSelectedProducts();
    const popupContainer = document.querySelector('.selected-products-popup') || document.createElement('div');
    popupContainer.classList.add('selected-products-popup');
    popupContainer.innerHTML = '';

    let total = 0;    
        
    if (selectedProducts.length > 0) {
        const productList = document.createElement('ul');
        productList.style.listStyle = 'none'; // Remove default list style

        selectedProducts.forEach((product, index) => {
            total += product.price * product.quantity;    
            const listItem = document.createElement('li');
            const formattedName = product.name.replace(/-/g, ' ');
            listItem.style.display = 'flex';
            listItem.style.alignItems = 'center';
            listItem.style.justifyContent = 'space-between';



            // Product name and price
            const productInfo = document.createElement('span');
            productInfo.textContent = `• ${formattedName} : ${product.price.toFixed(2)}€`;
            productInfo.style.flex = '1'; // Take remaining space
            listItem.appendChild(productInfo);

            // Remove button
            const removeButton = document.createElement('button');
            removeButton.textContent = '-';
            removeButton.classList.add('remove-button');
            removeButton.addEventListener('click', function () {
                handleRemoveProduct(index);
            });
            listItem.appendChild(removeButton);

            // Quantity display
            const quantityDisplay = document.createElement('span');
            quantityDisplay.textContent = ` ${product.quantity || 1}`; // Default to 1 if quantity is not set
            quantityDisplay.style.marginRight = '10px'; // Add some margin to separate from buttons
            listItem.appendChild(quantityDisplay);

            // Plus button
            const plusButton = document.createElement('button');
            plusButton.textContent = '+';
            plusButton.classList.add('plus-button');
            plusButton.addEventListener('click', function () {
                handleIncreaseQuantity(index);
            });
            listItem.appendChild(plusButton);    
                
            productList.appendChild(listItem);
        });

        popupContainer.appendChild(productList);
        
        const totalElement = document.createElement('div');
        totalElement.classList.add('total-price');
        totalElement.textContent = `Total: ${total.toFixed(2)}€`; // Format total to 2 decimal places
        totalElement.style.textAlign = 'right'; // Align the total to the right
        totalElement.style.padding = '10px'; // Add some padding
        popupContainer.appendChild(totalElement);
    } else {
        const noItemsMessage = document.createElement('p');
        noItemsMessage.textContent = 'You have no items in your cart.';
        popupContainer.appendChild(noItemsMessage);
    }
        
    let proceedButton = popupContainer.querySelector('.proceed-button');
    if (!proceedButton) {
        proceedButton = document.createElement('button');
        proceedButton.textContent = 'Proceed to Order Page';
        proceedButton.classList.add('proceed-button');
        popupContainer.appendChild(proceedButton);
    }

    // Update the event listener for the 'Proceed to Order Page' button
    proceedButton.onclick = function () {
        // Construct the product parameters string with quantities
    	const productParams = selectedProducts.map(product => `${product.name}`).join(',');
        const quantities = selectedProducts.map(product => `${product.quantity}`).join(',');
    	// Construct the full URL with parameters
    	window.location.href = `http://e-shopaholic.atwebpages.com/sample-page/12-2/?sele=${encodeURIComponent(productParams)}&quan=${encodeURIComponent(quantities)}`;
    };

    const closeButton = document.createElement('button');
    closeButton.textContent = 'Close';
    closeButton.classList.add('close-button');
    closeButton.addEventListener('click', function () {
        popupContainer.style.display = 'none';
    });
    popupContainer.appendChild(closeButton);

    const mainNavigation = document.querySelector('.main-navigation');
    if (mainNavigation) {
        mainNavigation.appendChild(popupContainer);
    }

    saveSelectedProducts();
}


function handleIncreaseQuantity(index) {
    const selectedProducts = getSelectedProducts();
    const product = selectedProducts[index];
    product.quantity = (product.quantity || 1) + 1; // Increment quantity or default to 1
    saveSelectedProducts();
    updatePopupContent();
    updateCartStatus();
}

// Function to handle the removal of a product
function handleRemoveProduct(index) {
    const selectedProducts = getSelectedProducts();
    const product = selectedProducts[index];

    if (product.quantity && product.quantity > 1) {
        // Decrement quantity if greater than 1
        product.quantity -= 1;
    } else {
        // Remove the entire product if quantity is 1 or less
        selectedProducts.splice(index, 1);
    }

    saveSelectedProducts();
    updatePopupContent();
    updateCartStatus();
}

// Function to handle the data sent through addToSelected
function handleAddToSelected(productName, productPrice) {
    const selectedProducts = getSelectedProducts();
    
    // Check if the product is already in the list
    const existingProductIndex = selectedProducts.findIndex(product => product.name === productName && product.price === productPrice);

    if (existingProductIndex !== -1) {
        // Product already in the list, increment the quantity
        selectedProducts[existingProductIndex].quantity = (selectedProducts[existingProductIndex].quantity || 1) + 1;
        alert(`You now have ${selectedProducts[existingProductIndex].quantity} ${productName.replace(/-/g, ' ')}s in your cart!`);
    } else {
        // Product not in the list, add it with quantity 1
        selectedProducts.push({ name: productName, price: productPrice, quantity: 1 });
        alert(`Product added to your cart! `);
    }

    saveSelectedProducts();
    updatePopupContent();
    updateCartStatus();
}

// Function to update the cart status
function updateCartStatus() {
    const cartMenuItem = document.querySelector('#menu-item-317');
    const selectedProducts = getSelectedProducts();

    if (cartMenuItem) {
        let countSpan = cartMenuItem.querySelector('.cart-count');
        if (!countSpan) {
            countSpan = document.createElement('span');
            countSpan.classList.add('cart-count');
            cartMenuItem.appendChild(countSpan);
        }

        if (selectedProducts.length > 0) {
            countSpan.textContent = selectedProducts.length;
            countSpan.style.display = 'inline-block';
        } else {
            countSpan.style.display = 'none';
        }
    }
}

// Function to toggle the popup visibility
function togglePopup() {
    const popupContainer = document.querySelector('.selected-products-popup');
    if (popupContainer) {
        popupContainer.style.display = popupContainer.style.display === 'block' ? 'none' : 'block';
        if (popupContainer.style.display === 'block') {
            updatePopupContent();
        }
    }
}

// Attach event listener to the main navigation for the cart
const mainNavigation = document.querySelector('.main-navigation');
if (mainNavigation && !mainNavigation.dataset.listenerAttached) {
    mainNavigation.addEventListener('click', function(event) {
        if (event.target.closest('#menu-item-317') || event.target.classList.contains('cart-count')) {
            event.preventDefault();
            togglePopup();
        }
    });
    mainNavigation.dataset.listenerAttached = 'true';
}
// Event listener for the "Add to order" buttons
document.addEventListener('DOMContentLoaded', function () {
    // Load the cart from local storage and update UI
    getSelectedProducts();
    updatePopupContent(); // This will create the popup container if it's not already there
    updateCartStatus();

    const addToOrderButtons = document.querySelectorAll('.add_to_order');
    addToOrderButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productName = button.getAttribute('data-product-name');
            const productPrice = parseFloat(button.getAttribute('data-product-price'));
            handleAddToSelected(productName, productPrice);
        });
    });
});
