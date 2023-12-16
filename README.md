<p align="center">
  <a href="" rel="noopener">
 <img width=200px height=200px src="https://mir-s3-cdn-cf.behance.net/project_modules/fs/f64696125858885.612205eaaf144.jpg" alt="Project logo"></a>
</p>

<h3 align="center">Budget</h3>

<div align="center">

[![Status](https://img.shields.io/badge/status-active-success.svg)]()
[![GitHub Issues](https://img.shields.io/github/issues/kylelobo/The-Documentation-Compendium.svg)](https://github.com/Timadey/budget/issues)
[![GitHub Pull Requests](https://img.shields.io/github/issues-pr/kylelobo/The-Documentation-Compendium.svg)](https://github.com/Timadey/budget/pulls)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](/LICENSE)

</div>

---

<p align="center"> <b>Budget</b> is a simple web app that provides a means for users to record their income and expenses. It helps you to keep track of your spending.
    <br> 
</p>

## 📝 Table of Contents

- [📝 Table of Contents](#-table-of-contents)
- [🧐 About ](#-about-)
- [🏁 Getting Started ](#-getting-started-)
  - [Prerequisites](#prerequisites)
  - [Installing](#installing)
- [🎈 Live Usage ](#-live-usage-)
- [🚀 Deployment ](#-deployment-)
- [⛏️ Built Using ](#️-built-using-)
- [Todo](#todo)
- [Contributions](#contributions)
- [✍️ Authors ](#️-authors-)
- [🎉 Acknowledgements ](#-acknowledgements-)

## 🧐 About <a name = "about"></a>
Budget was built with the aim of keeping track of your expenses and income in order to have an overview of your cash inflow. It is a simple web app with functionalities including a basic authentication module, book creation and deletion, income and expenses logging.

![a budget screen](budgetscreen.png)

## 🏁 Getting Started <a name = "getting_started"></a>

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See [deployment](#deployment) for notes on how to deploy the project on a live system.

### Prerequisites

Make sure that you have the following installed on your system before running the project or deploying.

```
Docker
PHP
MySql
Composer
```

### Installing

Clone the repo
```
git clone git@github.com:Timadey/budget.git budget
```
In order to get the project up and running, you can either use the PHP local develpment server or run the project directly using Docker container.

Using PHP local development server, 
Ensure to create a mysql database and import the `budget.sql` file at the root directory into the database.
Add environment variable containing the credentials of your mysql database. Replace `*` with the correct details
```
MYSQL_DB_HOST=****
MYSQL_PASSWORD=****
MYSQL_USER=****
MYSQL_DATABASE=****

```
Run the following commands in your terminal. Assuming you are in the project root directory
```
cd public
php -S localhost:8000
```

Your result should be like this

```
timothy@Timadey:~/projects/Income-and-Expenditure/public$ php -S localhost:5002
[Sat Dec 16 00:20:42 2023] PHP 7.4.3 Development Server (http://localhost:5002) started

```

Using Docker container, you can run the following commands, assuming you are in the project directory.
```
docker-compose build & docker-compose up
```

## 🎈 Live Usage <a name="usage"></a>

Budget is availabe live @[https://budgetim.onrender.com/](https://budgetim.onrender.com/). You can use this login details for test purposes only.
```
Email Address: admin@budget.com
Password: admin
```

## 🚀 Deployment <a name = "deployment"></a>

In production, it is advisable to use Docker, ensure you set the proper mysql database credentials under `php service environment section` section in docker compose.
Then follow the steps taken in dvelopment.

## ⛏️ Built Using <a name = "built_using"></a>

- [PHP](https://www.php.net/) - Database
- [Bootstrap](https://www.getboostrap.com/) - Web Framework
- [MYSQL](https://www.mysql.com/) - Database

## Todo
- Include data analytics
- Allow users to add additional categories
- Include trends and data visulization
- Allow users to set budgets

## Contributions
Contributions are highly encouraged, please fork and make pull requests. Thank you.

## ✍️ Authors <a name = "authors"></a>

- [@Timadey](https://github.com/Timadey) - Software Engineer
Feel free to reach out to me on [Linkedin](https://www.linkedin.com/in/timadey)


## 🎉 Acknowledgements <a name = "acknowledgement"></a>

Special thanks to [@Don Jo](https://github.com/emmadonjo/) for the inspiration given for this project.
