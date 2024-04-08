# MemeHub Back-end

This is the backend for the MEMEHUB project. It is a PHP RESTful API that provides the necessary endpoints for the frontend to interact with the database.


## How to run the project:

### Requirements:

- PHP 8.0 or higher
- Nothing else you are good to go
- I said nothing else, you can continue now
- No seriously, you don't need anything else
- Why are you still reading this? Just run the project already
- Ok, I give up. You can keep reading if you want
- But I'm not going to tell you anything else
- Fine, I'll tell you one more thing. You need to have a MySQL database running
- That's it. Now go run the project


Run the following command in the backend directory to start the PHP server:

```bash
    php start-server.php 
```

if you want to run it in development mode, you can change it manually in the [`app.php`](src/config/app.php) file or you can pass the `--dev=true` or `--dev=false` flag to the command.

```bash
    php start-server.php --dev=true  # or false
```

more information about the development mode can be found in the [Development Mode](#development-mode) section.

This will start the PHP server on port 8000. You can access the API at `http://localhost:8000`.
if you want to change the port, you can do so by modifying the [`app.php`](src/config/app.php) file in the Config folder.

```php
    'port' => 8000,
```


### Database Configuration:

The project uses a MySQL database to store data. You can configure the database connection by modifying the [`database.php`](src/config/database.php) file in the [`Config`](src/config) folder.
Update the database host, username, password, and database name to match your database configuration.

```php
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'memehub',
```
### 


# Project Workflow

The MemeHub backend follows a specific workflow to handle incoming requests and generate responses. Here's an overview of how the project works:

### 1.  Router:
The [`Router`](src/Router.php) class is responsible for managing the routes of the application. It matches the current URL with the defined routes and executes the corresponding callable function of the matched route. The router takes the incoming request and redirects it to the appropriate controller based on the request method and URL.

### 2. Controllers:
Controllers are responsible for handling requests and returning responses. Each controller is associated with a specific endpoint and is responsible for processing requests to that endpoint. The controller interacts with the models and table managers to perform CRUD operations on the database.

### 3. Models:
Models represent entities in the database. Each model corresponds to a table in the database and contains methods for interacting with that table. Models don't have their own logic; they are structures that represent entities from the database. Any logic or treatment on these objects is implemented in other classes like controllers.

### 4. TableManagers:
TableManagers are responsible for managing the interaction between the backend and the database. They contain methods for performing CRUD operations on the database.

### 5. Response Builder:
The [`ApiResponseBuilder`](src/Utils/ApiResponseBuilder.php) class is used to build the response of the API. It takes the data returned by the controller and constructs a standardized response format, including the appropriate HTTP status code and headers.

### 6. HttpExceptions:
HttpExceptions are exceptions that are thrown when an error occurs during the processing of an HTTP request. They contain an HTTP status code and a message that is returned to the client. These exceptions are used to handle specific error scenarios and provide meaningful error messages to the user.

### 7. Error Handler:
The [`errorHandler.php`](src/Exceptions/errorHandler.php) file handles errors and exceptions that occur during the processing of a request. Any uncaught exception is caught by this handler, and an appropriate response is sent to the client. If the error is an HttpException, the error handler returns the error response with the corresponding error message. If the error is not an HttpException, it returns an internal server error to avoid exposing server errors to the clients.

This workflow ensures that the backend of MemeHub operates smoothly, handles errors gracefully, and provides a consistent API response format to the frontend.




### Other Classes and Files:

- **[index.php](public/index.php):**  
    The entry point of the application. It handles all incoming requests and routes them to the appropriate controller based on the request method and URL.
- **[autoload.php](src/autoload.php):**   
    Autoloads all classes in the project.
- **[headers.php](src/Utils/headers.php):**  
    Sets the headers for the response.
- **[errorHandler.php](src/Exceptions/errorHandler.php):**  
    Handles errors and exceptions that occur during the processing of a request. Any uncaught exception is caught by this handler and an appropriate response is sent to the client. The error is also logged in the terminal for debugging purposes.
- **[RequestHandler.php](src/Utils/RequestHandler.php):**  
    Is user to get the request data and handle it. (query parameters & body)
- **[ApiResponseBuilder.php](src/Utils/ApiResponseBuilder.php):**  
    Builds the response of the API.
- **[Auth.php](src/Authentication/Auth.php):**  
    Handles user authentication and authorization.
- **[DatabaseConnection.php](src/Database/DatabaseConnection.php):**  
    Responsible for establishing a connection to the database.
- **[routes.php](src/routes.php):**  
    Contains all the routes of the application.
- **[Proxy](src/Utils/Proxy.php):**  
    A proxy class that is used to fetch foreign objects from the database. It is used to avoid fetching foreign objects multiple times. 
- **[jwt.php](src/Utils/jwt.php):**  
    Handles JWT token generation and validation. It uses the secret key defined in the [`keys.php`](src/config/keys.php) file. 
- **[Mail.php](src/Utils/Mail.php):**  
    Handles sending emails.

   
You can configure the application by modifying the configuration files in the [Config](src/config) folder.

You can ignore the .txt files, we just used them to communicate with each other. We left them there just for fun.
    

# Development Mode:
This project has a development mode that can be enabled by passing the `--dev=true` flag to the start-server.php command. 


```bash
    php start-server.php --dev=true  # or false
```

You can also enable it manually by changing the `dev` key in the [`app.php`](src/config/app.php) file.

```php
    'dev' => true,
```


In development mode, new endpoints are added to the API that will help you debug and test the application. These endpoints are not available in production mode.

## Session History:
Can be accessed at `admin/sessionHistory`. 

Returns a html page that shows all of the available endpoints of the API and the history of all the requests that were with the current session.

### Resquest Details:

You can access the details of a specific request by clicking on the request in the session history page. This will show you the details of the request including the request method, URL, request and response headers and body, body and routing information.


## JWT Token Validation:

In our application, the JWT (JSON Web Token) is used for secure transmission of information between parties as a JSON object. This information can be verified and trusted because it is digitally signed.

The JWT token is used in two scenarios: email verification and password reset.


1. **Email Verification:** When a new user registers, a JWT token is generated and sent to the user's email. This token contains the user's ID and email. The user is required to click on the verification link, which includes the JWT token, to verify their email address. The server then decodes the JWT token to retrieve the user's information and verifies the email address.

2. **Password Reset:** When a user requests a password reset, a JWT token is generated and sent to the user's email. This token contains the user's ID and email. The user is required to click on the reset link, which includes the JWT token, to reset their password. The server then decodes the JWT token to retrieve the user's information and allows the user to reset their password.

The [`AuthKeyGenerator`](src/Authentication/AuthKeyGenerator.php) class is responsible for encoding and decoding the JWT token. 

The JWT token also contains an expiration time. If the current time is greater than the expiration time in the token, an `ExpiredTokenException` is thrown. This ensures that the token is only valid for a certain period of time.

This process ensures that the user is who they claim to be and prevents unauthorized access to protected resources.
