#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266HTTPClient.h>
#include <ArduinoJson.h>
#include <Servo.h>
#include <limits.h>

//setting up WiFi and URLs
const char* ssid = "********";
const char* password = "************";
const char* url = "http://e-shopaholic.atwebpages.com/wp-json/my-plugin/v1/form-submissions";
const char* postEndpoint = "http://e-shopaholic.atwebpages.com/wp-content/themes/astra/handle_request.php"; 

//Initialization
WiFiClient client;
Servo myservo;
int previousId = 0;

//Positions
const int POSITION_SportsDrinkCoasters = 10;
const int POSITION_GreyDrinkCoasters = 20;
const int POSITION_BluePlasticContainers = 30;
const int POSITION_OrangePlasticContainers = 40;
const int POSITION_LampCover = 50;
const int POSITION_GreyCandles = 60;
const int POSITION_MushroomLamp = 70;
const int POSITION_PinkTableLamp = 80;
const int POSITION_SharpDigitalClock = 90;
const int POSITION_BlackDigitalClock = 100;
const int POSITION_TexetWebCam = 110;
const int POSITION_LogitechWebCam = 120;
const int POSITION_SonyUsbStick = 130;
const int POSITION_CruzerUsbStick = 140;
const int POSITION_IdeusHandsfree = 150;
const int POSITION_BlackHandsfree = 160;

//delays
const int DELAY_SportsDrinkCoasters = 5000;
const int DELAY_GreyDrinkCoasters = 10000;
const int DELAY_BluePlasticContainers = 15000;
const int DELAY_OrangePlasticContainers = 20000;
const int DELAY_LampCover = 25000;
const int DELAY_GreyCandles = 30000;
const int DELAY_MushroomLamp = 35000;
const int DELAY_PinkTableLamp = 40000;
const int DELAY_SharpDigitalClock = 45000;
const int DELAY_BlackDigitalClock = 50000;
const int DELAY_TexetWebCam = 55000;
const int DELAY_LogitechWebCam = 60000;
const int DELAY_SonyUsbStick = 65000;
const int DELAY_CruzerUsbStick = 70000;
const int DELAY_IdeusHandsfree = 75000;
const int DELAY_BlackHandsfree = 80000;




//Split into array function
// Function to split a string into an array based on a delimiter
int splitString(String input, char delimiter, String output[], int maxOutput) {
  int count = 0;
  int lastDelimiterIndex = 0;
  int length = input.length();

  for (int i = 0; i < length; i++) {
    if (input.charAt(i) == delimiter) {
      // Found a delimiter, extract the substring
      output[count] = input.substring(lastDelimiterIndex, i);
      count++;

      // Check if we have reached the maximum number of values
      if (count >= maxOutput) {
        break;
      }

      // Update the last delimiter index
      lastDelimiterIndex = i + 1;
    }
  }

  // Add the last substring after the last delimiter
  if (lastDelimiterIndex < length) {
    output[count] = input.substring(lastDelimiterIndex);
    count++;
  }

  return count;
}



//Connecting to WiFi
void setup() {
  Serial.begin(9600);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");
  
  myservo.attach(5); //attaching servo to D5
  myservo.write(0); //setting servo's initial position
}

//esp IP: 192.168.1.5



void loop() {

  //Geting every form submission
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(client, url);
    int httpCode = http.GET();
    if (httpCode == 200) {
      String payload = http.getString();
      
      DynamicJsonDocument doc(4096);
      DeserializationError error = deserializeJson(doc, payload);

    int maxId0 = 0;
    JsonObject maxObject;
    JsonArray array = doc.as<JsonArray>();
    for (JsonObject object : array) {
    int id0 = object["id0"].as<int>();
    String executed = object["executed"].as<String>();
    
    // Check if 'executed' is 'no' and if id0 is greater than the current maximum
    if (id0 > maxId0 && executed == "no") {
        maxId0 = id0;
        maxObject = object;
        break;  // Exit the loop once the first eligible object is found
    }
}
      
      int currentId = maxObject["id0"].as<int>();
      
      if (currentId != previousId && currentId !=0) {
        
        //storing max id's data
        String firstName = maxObject["first"];
        firstName[0] = toupper(firstName[0]);
        String lastName = maxObject["last"];
        lastName[0] = toupper(lastName[0]);
        String address = maxObject["address"];
        address[0] = toupper(address[0]);
        String email = maxObject["email"];
        String phone = maxObject["phone"];
        String productName = maxObject["product_name"];
        String quantities = maxObject["quantity"];

        //Printing data in the monitor
        Serial.println("First name: " + firstName);
        Serial.println("Last name: " + lastName);
        Serial.println("Address: " + address);
        Serial.println("E-mail: " + email);
        Serial.println("Phone number: " + phone);
        Serial.println("Product name: " + productName);
        Serial.println("Quantity: " + quantities);

        const int maxProducts = 10;  
        String productNames[maxProducts];
        int numProducts = splitString(productName, ',', productNames, maxProducts);

        String quantitiesArray[maxProducts];
        int numQuantities = splitString(quantities, ',', quantitiesArray, maxProducts);
        
        sendStatusUpdate("Order id " + String(currentId) + " is being processed");

      for (int i = 0; i < numProducts; i++) {
        String productName = productNames[i];
         int quantity = quantitiesArray[i].toInt();

         for (int j = 0; j < quantity; j++) {
        //moving servo based on product
        if (productName == "Sports-drink-coasters") {
            moveServo(POSITION_SportsDrinkCoasters, productName, DELAY_SportsDrinkCoasters);
          
        } else if (productName == "Grey-drink-coasters") {
          moveServo(POSITION_GreyDrinkCoasters, productName, DELAY_GreyDrinkCoasters);
          
        } else if (productName == "Blue-plastic-containers") {
          moveServo(POSITION_BluePlasticContainers, productName, DELAY_BluePlasticContainers);
          
        } else if (productName == "Orange-plastic-containers") {
          moveServo(POSITION_OrangePlasticContainers, productName, DELAY_OrangePlasticContainers);
          
        } else if (productName == "Lamp-cover") {
          moveServo(POSITION_LampCover, productName,DELAY_LampCover);
          
        } else if (productName == "Grey-candles") {
          moveServo(POSITION_GreyCandles, productName, DELAY_GreyCandles);
          
        }else if (productName == "Mushroom-lamp") {
          moveServo(POSITION_MushroomLamp, productName, DELAY_MushroomLamp);
          
        }else if (productName == "Pink-table-lamp") {
          moveServo(POSITION_PinkTableLamp, productName, DELAY_PinkTableLamp);
          
        }else if (productName == "Sharp-digital-clock") {
          moveServo(POSITION_SharpDigitalClock, productName, DELAY_SharpDigitalClock);
          
        }else if (productName == "Black-digital-clock") {
          moveServo(POSITION_BlackDigitalClock, productName, DELAY_BlackDigitalClock);
          
        }else if (productName == "TEXET-web-cam") {
          moveServo(POSITION_TexetWebCam, productName, DELAY_TexetWebCam);
          
        }else if (productName == "Logitech-web-cam") {
          moveServo(POSITION_LogitechWebCam, productName, DELAY_LogitechWebCam);
          
        }else if (productName == "SONY-USB-stick") {
          moveServo(POSITION_SonyUsbStick, productName, DELAY_SonyUsbStick);
          
        }else if (productName == "Cruzer-USB-stick") {
          moveServo(POSITION_CruzerUsbStick, productName, DELAY_CruzerUsbStick);
          
        }else if (productName == "Ideus-handsfree") {
          moveServo(POSITION_IdeusHandsfree, productName, DELAY_IdeusHandsfree);
          
        }else if (productName == "Black-handsfree") {
          moveServo(POSITION_BlackHandsfree, productName, DELAY_BlackHandsfree);
          
        }
         }
         }
        
        previousId = currentId;
        
      }else {
        Serial.println("No New Orders");
      }
       
    } else {
      Serial.println("Error on HTTP request");
    }
    http.end();
  } else {
    Serial.println("WiFi Disconnected");
  }
  delay(5000);
  
}

void moveServo(int position, String productName, int extraDelay) {
    myservo.write(position);
    delay(extraDelay);
    myservo.write(0);
    delay(extraDelay);
    sendStatusUpdate("Item '" + productName + "' retrieved");
}

void sendStatusUpdate(String message) {
  HTTPClient http2;

  http2.begin(client,postEndpoint);
  http2.addHeader("Content-Type", "application/x-www-form-urlencoded");

  // Send the status message
  int httpResponseCode = http2.POST("message=" + message);

  if (httpResponseCode > 0) {
    Serial.println("Status update sent successfully");
  } else {
    Serial.print("Error sending status update. HTTP response code: ");
    Serial.println(httpResponseCode);
  }

  http2.end();
}
