# Simple Inventory Manager

A lightweight Inventory Management System built using the **LAMP Stack** (Linux, Apache, MySQL, PHP). This project demonstrates core backend competencies including CRUD operations, database design, and server-side rendering.

## 🛠 Tech Stack

- **Backend:** PHP 8.1 (Native, no frameworks)
- **Database:** MySQL / MariaDB
- **Frontend:** HTML5, CSS3 (Tailwind via CDN)
- **Server:** Apache Web Server on Ubuntu Linux

## 🚀 Features

- **Add Products:** Secure input handling using Prepared Statements (preventing SQL Injection).
- **Real-time Display:** Fetches and displays database records instantly.
- **Delete Functionality:** Remove items from the database via ID.
- **Responsive Design:** Clean UI/UX adapted for mobile and desktop.

## ⚙️ Installation & Setup

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/kabakadev/inventory-manager.git
    ```

2.  **Configure Database:**

    - Import the schema via MySQL CLI or phpMyAdmin.
    - Update `db_connect.php` with your database credentials.

3.  **Deploy:**
    - Move files to your web root (e.g., `/var/www/html/`).
    - Ensure Apache service is running:
      ```bash
      sudo service apache2 start
      ```

## 🛡 Security Note

This project uses **mysqli prepared statements** to handle user input, ensuring security against common SQL injection attacks.
