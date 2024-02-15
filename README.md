This projects integrades both software as well as hardware componets to create an e-shop using Wordpress that communicates with a NodeMCU ESP8266 module to simulate the automated order picking process.
For the creation of the website custom files inside the Wordpress theme were created, languages such as JavaScript, Html and Css, as well as the WordPress plugin ELEMENTOR, were used to create the front-end of the platform and PHP and SQL to create the back-end.
Finally Cpp and Arduino IDE were used to program the ESP module.
The website works as a typical e-shop, any user can place an order through the system and upon submission the order info get stored in the DB. Because the ESP can't communicate directly withe DB, a custom plugin was created, fetching the data from the DB and displaying them 
as JSON format in a custom endpoint URL using WordPress API. The ESP regularly polls the endpoint and fetches the data coresponding to the most recent order placed through the platform that hasn't been executed yet. Having access to that data, the ESP controls a servo motor, 
to simulate the order picking movements required to retreive the selected products from the shelves.
After each product in the list is retreived, the ESP sends confirmation messages back to the website via a second endpoint so that the user can witness in real-time the execution of their order!
