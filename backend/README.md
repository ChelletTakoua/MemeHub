# MemeHub Back-end

This is the backend for the MEMEHUB project. It is a PHP RESTful API that provides the necessary endpoints for the frontend to interact with the database.




## Project Structure


### index.php:
index.php is the entry point of the application. It handles all incoming requests and routes them to the appropriate controller based on the request method and URL.

### Router:
The [Router](src/Router.php) class is responsible for managing the routes of the application. It allows to add routes with different methods (GET, POST, PUT, DELETE, OPTIONS) and matches the current url with the routes and execute the callable function of the matched route.
You can find the routes in the [routes.php](src/routes.php) file. Each route is defined with a method, a path, and a callable function (a method of a controller).

### Controllers:
Controllers are responsible for handling requests and returning responses. Each controller is associated with a specific endpoint and is responsible for processing requests to that endpoint.

### Models:
Models represent entities in the database. Each model corresponds to a table in the database and contains methods for interacting with that table.
Models don't have a logic on their own. They are structures that represent entities from the database. Any logic or treatment on these objects is implemented in other classes like Controllers. 

### TableManagers:
TableManagers are responsible for managing the interaction between the backend and the database. They contain methods for performing CRUD operations on the database.

### HttpExceptions:
HttpExceptions are exceptions that are thrown when an error occurs during the processing of an HTTP request. They contain an HTTP status code and a message that is returned to the client.

### Utils:
Utils contains utility classes that are used throughout the application.

### Config:
The [Config](src/Config)  folder contains configuration files for the application.

### Other Classes and Files:

- **[Proxy](src/Utils/Proxy.php):**  
    A proxy class that is used to fetch foreign objects from the database. It is used to avoid fetching foreign objects multiple times. 
- **[DatabaseConnection.php](src/Database/DatabaseConnection.php):**  
    Responsible for establishing a connection to the database.
- **[autoload.php](src/autoload.php):**   
    Autoloads all classes in the project.
- **[headers.php](src/Utils/headers.php):**  
    Sets the headers for the response.
- **[jwt.php](src/Utils/jwt.php):**  
    Handles JWT token generation and validation.
- **[RequestHandler.php](src/Utils/RequestHandler.php):**  
    Is user to get the request data and handle it. (query parameters & body)
- **[ApiResponseBuilder.php](src/Utils/ApiResponseBuilder.php):**  
    Builds the response of the API.
- **[errorHandler.php](src/Exceptions/errorHandler.php):**  
    Handles errors and exceptions that occur during the processing of a request. Any uncaught exception is caught by this handler and an appropriate response is sent to the client. The error is also logged in the terminal for debugging purposes.
- **[Proxy.php](src/Utils/Proxy.php):**  
    A proxy class that is used to fetch foreign objects from the database. It is used to avoid fetching foreign objects multiple times.

### Project Workflow

The MemeHub backend follows a specific workflow to handle incoming requests and generate responses. Here's an overview of how the project works:

### 1.  Router:  
The [Router](src/Router.php) class is responsible for managing the routes of the application. It matches the current URL with the defined routes and executes the corresponding callable function of the matched route. The router takes the incoming request and redirects it to the appropriate controller based on the request method and URL.

### 2. Controllers:  
Controllers are responsible for handling requests and returning responses. Each controller is associated with a specific endpoint and is responsible for processing requests to that endpoint. The controller interacts with the models and table managers to perform CRUD operations on the database.

### 3. Models:    
Models represent entities in the database. Each model corresponds to a table in the database and contains methods for interacting with that table. Models don't have their own logic; they are structures that represent entities from the database. Any logic or treatment on these objects is implemented in other classes like controllers.

### 4. TableManagers:   
TableManagers are responsible for managing the interaction between the backend and the database. They contain methods for performing CRUD operations on the database.

### 5. Response Builder:  
The [ApiResponseBuilder](src/Utils/ApiResponseBuilder.php) class is used to build the response of the API. It takes the data returned by the controller and constructs a standardized response format, including the appropriate HTTP status code and headers.

### 6. HttpExceptions**:   
HttpExceptions are exceptions that are thrown when an error occurs during the processing of an HTTP request. They contain an HTTP status code and a message that is returned to the client. These exceptions are used to handle specific error scenarios and provide meaningful error messages to the user.

7. **Error Handler**:   
The [errorHandler.php](src/Exceptions/errorHandler.php) file handles errors and exceptions that occur during the processing of a request. Any uncaught exception is caught by this handler, and an appropriate response is sent to the client. If the error is an HttpException, the error handler returns the error response with the corresponding error message. If the error is not an HttpException, it returns an internal server error to avoid exposing server errors to the clients.

This workflow ensures that the backend of MemeHub operates smoothly, handles errors gracefully, and provides a consistent API response format to the frontend.

 





features

mailing