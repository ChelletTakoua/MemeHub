# MemeHub
A meme generator and sharing platform where users can create and share memes. Users can react to and comment on posts, making it a fun and interactive community for meme lovers.

## Requirements

Before running the MemeHub project, make sure you have the following software and tools installed on your machine:

1. [Node.js](https://nodejs.org/en/download/) and [npm](https://www.npmjs.com/get-npm) (Node Package Manager) - These are required to run the front end of the project.

2. [PHP](https://www.php.net/downloads.php) 8.0 or higher - This is required to run the back end of the project.

3. [MariaDB](https://mariadb.org/download/) or [XAMPP](https://www.apachefriends.org/download.html) - These are required to set up and run the database for the project.

4. A text editor or IDE (Integrated Development Environment) like [PhpStorm](https://www.jetbrains.com/phpstorm/download/) - This is required to view and edit the project files.

Once you have all these tools installed, you can proceed with running the project as described in the [How to run the project](#how-to-run-the-project) section.

## How to run the project:

To run the MemeHub project, follow these steps:

1. Clone the project repository to your local machine.



2. For the front end:
    - Navigate to the front end folder.
    - Run the following commands:
      ```bash
      npm install
      npm start
      ```
      This will install the necessary dependencies and start the React development server.

3. For the database:
    - Run your MariaDB server. If you don't have MariaDB installed, you can use XAMPP for an easy setup.
    - Execute the [`schema.sql`](database/schema.sql) file to create the necessary database schema.

4. For the back end:
   - Navigate to the back end folder.
   - Make sure you have PHP 8.0 or higher installed on your machine.
   - Run the following command to start the PHP server:
     ```bash
     php start-server.php
     ```
   - If you want to run the server in development mode, you can pass the `--dev=true` flag to the command:
     ```bash
     php start-server.php --dev=true # or false
     ```
   - The server will start on port 8000. You can access the API at `http://localhost:8000`.
   - You can configure the database connection by modifying the [`database.php`](back-end/Config/database.php) file in the [`Config`](backend/Config) folder. Update the database host, username, password, and database name to match your database configuration.
   - For more detailed instructions and information about the project workflow, refer to the [README.md](backend/README.md) file in the back end folder.
    

5. Once all the necessary components are running, you can access the MemeHub application in your web browser.

**Note:** Make sure to update any configuration files as needed for your specific setup.

