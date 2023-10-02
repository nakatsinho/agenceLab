# AGENCE LAB (System Overview) - 🇲🇿
![Project Logo](https://github.com/nakatsinho/agenceLab/blob/main/agence-client/src/assets/images/logo.gif)

This system is a comprehensive management platform designed to streamline various organizational processes. It provides a centralized interface for handling tasks related to clients, consultants, and financial data. Users can efficiently manage client interactions, track consultant performance, and analyze financial metrics for informed decision-making. The system offers a user-friendly dashboard and reporting tools, facilitating a holistic view of operations and aiding in business growth and efficiency.

## How to Use

1. **Dashboard:**

   - After successful open the frontend URL, you will be redirected to the dashboard.
   - The dashboard provides an overview of essential information and quick access to key features.

2. **Navigation:**

   - Use the navigation menu to explore various modules and features of the system.
   - Each menu item corresponds to a specific functionality or section.

3. **Reports and Analytics:**

   - Access reports and analytics sections to gain insights from the data available.
   - Customize and generate reports as needed.


![Project Overview](https://github.com/nakatsinho/agenceLab/blob/main/AgenceDashboard/public/image.png)

## Table of Contents

- [Project Overview](#project-overview)
  - [Features](#features)
  - [Technologies Used](#technologies-used)
- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
- [Usage](#usage)
- [Contact](#contact)

## Key Features

- **Client Management:** Efficiently handle client interactions, including contact information, project history, and communication records. Streamline client-related tasks and improve client relationships.

- **Consultant Tracking:** Monitor consultant performance, project involvement, and overall productivity. Track project assignments and optimize resource allocation.

- **Financial Analysis:** Analyze financial data, including revenue, costs, profits, and more. Gain insights into the financial health of the organization and make data-driven decisions.

- **Intuitive Dashboard:** Access a dynamic dashboard that provides a quick overview of key metrics, project statuses, financial summaries, and upcoming tasks. Stay informed and in control at all times.

- **Reporting Tools:** Utilize advanced reporting tools to generate custom reports, charts, and graphs. Tailor reports based on specific criteria to extract actionable insights and facilitate strategic planning.

### Technologies Used

The system is built using a variety of technologies and frameworks:

- **Frontend:**
  - Vue.js: A progressive JavaScript framework for building user interfaces.
  - HTML, CSS, JavaScript: Fundamental web technologies for structuring, styling, and adding interactivity to the frontend.

- **Backend:**
  - Laravel: A PHP web application framework known for its elegant syntax and tools for tasks such as routing, authentication, and caching.
  - Node.js: A runtime environment that executes JavaScript code outside the browser, commonly used for backend development.
  - Express.js: A minimal and flexible Node.js web application framework that simplifies backend development.

- **Database:**
  - MySQL: An open-source relational database management system used to store and manage structured data effectively.

- **Additional Tools:**
  - Git: A version control system to track changes in the source code during software development.
  - GitHub: A platform for hosting and collaborating on Git repositories.

## System Requirements

- Node.js
- Composer
- Vue
- npm or yarn
- Modern web browser
- Internet connection for certain features that require external APIs

## Getting Started
### Prerequisites

Before installing the project, make sure you have the following software installed on your system:

- **Node.js (>= 14.x):** The system requires Node.js, a JavaScript runtime, to run the frontend and manage dependencies.

- **npm or Yarn:** Ensure you have npm (Node Package Manager) or Yarn installed, as they are essential for installing dependencies and running scripts.

- **Laravel Setup (>= 8.0):** For backend development, the system utilizes Laravel. Familiarize yourself with Laravel and have it set up on your local machine.

- **Database:** You should have a MySQL database installed and configured, as the system utilizes MySQL for data storage.

- **Web Browser:** Ensure you have a modern web browser for accessing the system's frontend.

- **Internet Connection:** Some features within the system may require an internet connection to access external APIs.

...

### Installation

Follow these steps to get the project up and running on your local machine:

1. **Clone the repository:**

```bash
https://github.com/nakatsinho/agenceLab.git
```

```bash
cd agenceLab
```
2. **Dependecies:**

Navigate to the cloned repository and install the necessary dependencies for both the frontend and backend

#### 2.1. For Back-end:
```bash
cd AgenceDashboard
```
```bash
composer update or composer install
```
##### GOOD DJOB 🔥...

Now we have the basics to test! Note that the command above brought us the following file:
- **AgenceDashboard/.env.example** - The dummy file to clone and edit the name to .env;

##### Explanation and Configuration:

Be sure to run the following commands in the root directory:
```
cp .env.example to .env
```
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=XXX-XXX-XXX
DB_USERNAME=XXXXXXXX
DB_PASSWORD=XXXXXXXX
```
Replace the above XXXXX with you own data to connect to Database. 

```
php artisan key:generate
```

#### And Hozaaaa 🔥 🔥 🔥... "É fácil!"

Now, Just type this on you terminal from the root of backend project:
```
php -S localhost:8030 -t public/
```

This will run you backend in the following url: http://127.0.0.1:8030 

#### 2.2. For Front-end:
```bash
cd agence-client
```
```bash
npm install
```
But, this is not all! Let's call and update the line where the API's are called
- Navigate to the following folder: 
```bash
cd agence-client/src/services
```
- There you will find the file name: **http.js**
- Open it and update the baseUrl to **http://127.0.0.1:8030**

If you get success, then run the following command
```bash
npm run dev
```

Probably you will get the following url: **http://localhost:5173**, just open it in you browser and VOILAAA... ENJOY
### Dependence & Authors

**Powered by** <a href="https://github.com/nakatsinho">Kelton Mauro Cumbe 🇲🇿</a>, aka **The Problems Solver** ! WhatsApp me <a href="https://wa.me/+258842536927"> any time </a>.