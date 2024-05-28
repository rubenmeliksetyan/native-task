# Laravel Stock Data Application

This project is a Laravel application that demonstrates how to fetch and display real-time stock market data using Vue.js on the frontend. The application interacts with an external API to retrieve stock data and displays it in a responsive table.

## Prerequisites

- Docker
- Docker Compose

## Setup

### Step 1: Clone the Repository

```bash
git clone https://github.com/rubenmeliksetyan/native-task.git
cd native-task
```

### Step 2: Configure Environment Variables

Copy the .env.example file to .env and add your API key and host.

```bash
cp .env.example .env
```
Open the .env file and add the following lines. Replace your_api_key_here with your actual API key from RapidAPI and ensure the host is set correctly.

### Step 3: Start Laravel Sail

Laravel Sail is a Docker development environment for Laravel. Ensure you have Docker installed and running on your system. Then, start Laravel Sail:

```bash
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
sail up -d

sail artisan key:generate
```

### Step 4: Install Dependencies
After starting Sail, you need to install the PHP dependencies using Composer:
```bash
sail composer install
```
Install the JavaScript dependencies using npm:
```bash
sail npm install
```

### Step 5: Compile Assets
Compile the frontend assets using Laravel Mix:

```bash
sail npm run dev
```


### Testing
To run the unit tests for the application, use the following command:

```bash
sail artisan test
```