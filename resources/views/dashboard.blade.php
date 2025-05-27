<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add this div at the top of your body, right after the opening body tag -->
    <div class="pizza-background" id="pizzaBackground"></div>

    <!-- Add this section where you want to display the pizza selection -->
    <div class="dashboard-section pizza-selection">
        <h2>Select Your Pizza</h2>
        <div class="pizza-grid">
            @php
                $pizzaItems = [
                    [
                        "name" => "Pepperoni Pizza",
                        "price" => "₱149",
                        "img" => "pepporoni pizza.png",
                        "desc" => "Zesty pepperoni slices, tangy tomato sauce, melted mozzarella cheese, and a sprinkle of oregano on a golden crust."
                    ],
                    [ 
                        "name" => "Cheese Pizza", 
                        "price" => "₱129", 
                        "img" => "Cheese pizza.png", 
                        "desc" => "Classic cheese pizza with our signature tomato sauce and a blend of premium mozzarella and cheddar cheeses." 
                    ],
                    [ 
                        "name" => "Hawaiian Pizza", 
                        "price" => "₱159", 
                        "img" => "hawaian pizza.png", 
                        "desc" => "Sweet pineapple chunks, savory ham, tomato sauce, and melted mozzarella cheese on our hand-tossed crust." 
                    ],
                    [ 
                        "name" => "Meat Pizza", 
                        "price" => "₱189", 
                        "img" => "meaty pizza.png", 
                        "desc" => "Loaded with pepperoni, Italian sausage, bacon, and ground beef on our signature sauce and cheese blend." 
                    ],
                    [ 
                        "name" => "Overload Cheese Pizza", 
                        "price" => "₱169", 
                        "img" => "overload cheese pizza.png", 
                        "desc" => "Five premium cheeses - mozzarella, cheddar, provolone, parmesan, and ricotta - melted to perfection." 
                    ]
                ];
            @endphp

            @foreach ($pizzaItems as $index => $pizza)
                <div class="pizza-item" data-index="{{ $index }}" data-image="{{ asset('images/' . $pizza['img']) }}">
                    <div class="pizza-item-content">
                        <img src="{{ asset('images/' . $pizza['img']) }}" alt="{{ $pizza['name'] }}" class="pizza-thumbnail">
                        <h3>{{ $pizza['name'] }}</h3>
                        <p class="pizza-price">{{ $pizza['price'] }}</p>
                        <p class="pizza-desc">{{ $pizza['desc'] }}</p>
                        <button class="btn btn-primary order-btn" data-pizza="{{ $pizza['name'] }}">Order Now</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Add this JavaScript at the end of your file, before the closing body tag -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the background element
        const pizzaBackground = document.getElementById('pizzaBackground');
        
        // Get all pizza items
        const pizzaItems = document.querySelectorAll('.pizza-item');
        
        // Function to set the background image
        function setPizzaBackground(imageUrl) {
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
            img.src = imageUrl;
        }
        
        // Add click event to each pizza item
        pizzaItems.forEach(item => {
            item.addEventListener('click', function() {
                // Remove selected class from all items
                pizzaItems.forEach(p => p.classList.remove('selected'));
                
                // Add selected class to clicked item
                this.classList.add('selected');
                
                // Get the image URL from the data attribute
                const imageUrl = this.getAttribute('data-image');
                
                // Set the background image
                setPizzaBackground(imageUrl);
            });
        });
        
        // Set initial background to the first pizza
        if (pizzaItems.length > 0) {
            pizzaItems[0].classList.add('selected');
            const initialImage = pizzaItems[0].getAttribute('data-image');
            setPizzaBackground(initialImage);
        }
        
        // Handle order buttons
        const orderButtons = document.querySelectorAll('.order-btn');
        orderButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const pizzaName = this.getAttribute('data-pizza');
                
                // Find the pizza item that contains this button
                const pizzaItem = this.closest('.pizza-item');
                
                // Trigger the click event on the pizza item to select it
                pizzaItem.click();
                
                // You can add additional logic here to handle the order
                // For example, scroll to an order form or open a modal
                alert(`You selected ${pizzaName}. Redirecting to order page...`);
                
                // Redirect to the front page with the selected pizza
                const index = pizzaItem.getAttribute('data-index');
                window.location.href = '/?pizza=' + index + '#product';
            });
        });
    });
    </script>
</x-app-layout>
