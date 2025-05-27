document.addEventListener('DOMContentLoaded', function() {
    // Create the background element if it doesn't exist
    let pizzaBackground = document.getElementById('pizzaBackground');
    if (!pizzaBackground) {
        pizzaBackground = document.createElement('div');
        pizzaBackground.id = 'pizzaBackground';
        pizzaBackground.className = 'pizza-background';
        document.body.insertBefore(pizzaBackground, document.body.firstChild);
    }
    
    // Get all pizza items
    const pizzaItems = document.querySelectorAll('.pizza-item');
    if (pizzaItems.length === 0) {
        console.log('No pizza items found on the page');
        return;
    }
    
    console.log('Found', pizzaItems.length, 'pizza items');
    
    // Function to set the background image
    function setPizzaBackground(imageUrl) {
        console.log('Setting background to:', imageUrl);
        
        // Create a new image to preload
        const img = new Image();
        img.onload = function() {
            // Once image is loaded, apply it to the background with a fade effect
            pizzaBackground.style.opacity = '0';
            
            setTimeout(() => {
                pizzaBackground.style.backgroundImage = `url(${imageUrl})`;
                pizzaBackground.style.opacity = '0.15';
            }, 300);
        };
        img.onerror = function() {
            console.error('Failed to load image:', imageUrl);
        };
        img.src = imageUrl;
    }
    
    // Add click event to each pizza item
    pizzaItems.forEach(item => {
        item.addEventListener('click', function() {
            console.log('Pizza item clicked');
            
            // Remove selected class from all items
            pizzaItems.forEach(p => p.classList.remove('selected'));
            
            // Add selected class to clicked item
            this.classList.add('selected');
            
            // Get the image URL from the data attribute
            const imageUrl = this.getAttribute('data-image');
            console.log('Image URL:', imageUrl);
            
            // Set the background image
            setPizzaBackground(imageUrl);
        });
    });
    
    // Set initial background to the first pizza
    if (pizzaItems.length > 0) {
        pizzaItems[0].classList.add('selected');
        const initialImage = pizzaItems[0].getAttribute('data-image');
        console.log('Initial image:', initialImage);
        setPizzaBackground(initialImage);
    }
});
