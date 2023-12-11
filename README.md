# Carpool Management System (CMS)

This is a carpool management system developed using Laravel, aimed at facilitating the organization and management of carpooling services.

## Features

- **User Authentication**: Secure user login and registration functionality.
- **Live Chat**: Real-time chat functionality between users.
- **Wallet Transfer**: Users can transfer funds between each other securely within the system.
- **Admin Announcements**: Admins can create and broadcast announcements to users.

## Installation

### Prerequisites

- PHP >= 7.4
- Composer
- Node.js & NPM
- MySQL or any other compatible database

## Installing Composer on Windows （if you haven)

### Using Composer Setup

1. **Download Composer**

   Download the Composer Setup executable from [Downlod the composer](https://getcomposer.org/download/).

2. **Run the Installation**

   Run the downloaded Composer Setup executable file.

   Follow the installation wizard's instructions.

### Verify the Installation

To verify if Composer is installed correctly:

1. Open a command prompt.

2. Type the following command:

   ```bash
   composer --version

### Steps

1. Clone the repository:

    ```bash
    git clone https://github.com/yiyang2001/cms.git
    ```

2. Navigate to the project directory:

    ```bash
    cd cms
    ```

3. Install PHP dependencies:

    ```bash
    composer install
    ```

4. Copy the `.env.example` file to `.env`:

    ```bash
    cp .env.example .env
    ```

5. Generate an application key:

    ```bash
    php artisan key:generate
    ```
6. Rename `env` file to `.env`

7. Create a database named `carpool_ms`

8. Run database migrations:

    ```bash
    php artisan migrate
    ```

8. Install NPM dependencies:

    ```bash
    npm install && npm run dev
    ```

9. Start the development server:

    ```bash
    php artisan serve
    ```

10. Access the application in your browser at `http://localhost:8000`.

## Usage

1. Using admin@gmail.com as the admin user account to login , password is Abcd@1234

