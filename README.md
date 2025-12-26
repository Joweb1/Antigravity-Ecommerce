# Antigravity E-Commerce

This is a futuristic, high-end e-commerce application built with Laravel, Livewire, Tailwind CSS, Alpine.js, and Filament PHP. It features a unique "Antigravity" design aesthetic with dark mode, thin borders, glassmorphism, and custom animations.

## Table of Contents

- [Features](#features)
- [Stack](#stack)
- [Setup & Installation](#setup--installation)
- [Admin Panel](#admin-panel)
- [Frontend Usage](#frontend-usage)
- [Database Schema](#database-schema)
- [Backend Logic & Jobs](#backend-logic--jobs)

## Features

- **Futuristic "Antigravity" Design:** Dark mode only with 1px thin borders, glassmorphism effects (backdrop-blur), fixed grain overlay, ambient glow, and a custom cursor.
- **Floating HUD Navigation:** "Shop", "Cart [Count]", and "Account" links with Alpine.js and GSAP animations.
- **Product Browsing:** Vertical list of products with a unique hover effect that displays the product image floating near the cursor.
- **Database-driven Cart System:** Off-canvas slide-over cart panel with real-time updates, increment/decrement/remove item functionality, and persistence in the database (associated with authenticated users).
- **Simple Checkout Process:** Creates an order, moves items from cart to order items, and decrements product stock.
- **Low Stock Notifications:** Dispatches email alerts to the admin if a product's stock falls below a predefined threshold after a purchase.
- **Daily Sales Reports:** Sends a daily email report to the admin summarizing the total sales for the day.
- **Filament Admin Panel:**
    - **Product Management:** CRUD operations for managing products, including name, slug, description, price, stock quantity, and image uploads.
    - **User Management:** View and manage registered users.
    - **Cart Management:** Read-only view of active user shopping carts and their contents.
    - **Site Settings:** A dedicated page to configure the admin email for notifications and SMTP settings for email delivery.

## Stack

-   **Laravel**: PHP Framework for web artisans.
-   **Livewire**: A full-stack framework for Laravel that makes building dynamic interfaces simple.
-   **Tailwind CSS**: A utility-first CSS framework.
-   **Alpine.js**: A rugged, minimal JavaScript framework for composing behavior directly in your markup.
-   **Filament PHP**: A collection of tools for rapidly building beautiful TALL stack apps, including an admin panel builder.
-   **SQLite**: Lightweight, file-based database.
-   **GSAP**: Professional-grade JavaScript animation library.
-   **Lenis**: A smooth scroll utility.

## Setup & Installation

Follow these steps to get the Antigravity E-Commerce application up and running on your local machine.

1.  **Clone the Repository:**
    ```bash
    git clone <repository-url>
    cd antigravity-ecommerce
    ```

2.  **Install Composer Dependencies:**
    ```bash
    composer install
    ```

3.  **Install Node Dependencies:**
    ```bash
    npm install
    ```

4.  **Copy Environment File:**
    ```bash
    cp .env.example .env
    ```
    (Note: The `.env` file is pre-configured for SQLite as per project requirements.)

5.  **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```

6.  **Create SQLite Database File:**
    ```bash
    touch database/database.sqlite
    ```

7.  **Run Migrations and Seed the Database:**
    ```bash
    php artisan migrate --seed
    ```
    This will create all necessary tables and populate the `products` table with sample data.

8.  **Create Storage Link:**
    ```bash
    php artisan storage:link
    ```
    This command creates a symbolic link from `public/storage` to `storage/app/public`, necessary for image uploads.

9.  **Create a Filament Admin User:**
    ```bash
    php artisan make:filament-user
    ```
    Follow the prompts to create your admin login credentials. You will use these to access the Filament admin panel.

10. **Start Development Servers:**
    ```bash
    php artisan serve
    npm run dev
    ```
    Access the application at `http://localhost:8000`.

## Admin Panel

The admin panel is built using Filament PHP.

-   **Access:** Navigate to `/admin` (e.g., `http://localhost:8000/admin`).
-   **Login:** Use the credentials created with `php artisan make:filament-user`.

**Available Resources:**

-   **Products:** CRUD operations for managing products, including name, slug, description, price, stock quantity, and image uploads.
-   **Users:** View and manage registered users.
-   **Carts:** Read-only view of active user shopping carts and their contents.
-   **Site Settings:** A dedicated page (`/admin/settings`) to configure the admin email for notifications and SMTP settings for email delivery.

## Frontend Usage

-   **Shop (`/shop`):** Browse the list of available products. Hover over products to see their images.
-   **Cart:** Add products to your cart from the shop page. Click the "Cart [Count]" button in the navigation to open the slide-over cart panel. Manage quantities, remove items, and proceed to checkout.
-   **Account:** Login, register, and manage your profile (powered by Laravel Breeze).

## Database Schema

The application uses an SQLite database with the following tables:

-   `products`: Stores product information (id, name, slug, description, price, stock_quantity, image_path).
-   `carts`: Stores user's shopping carts (id, user_id).
-   `cart_items`: Stores items within each cart (id, cart_id, product_id, quantity).
-   `orders`: Stores order details (id, user_id, total, status).
-   `order_items`: Stores individual items within each order (id, order_id, product_id, quantity, price).
-   `settings`: A key-value store for application settings (id, key, value).

## Backend Logic & Jobs

-   **Low Stock Notification:**
    -   `CheckLowStock` Job: Dispatched after a product's stock is decremented during checkout.
    -   `LowStockAlert` Mailable: Sent to the admin email (configured in Site Settings) if a product's stock falls below 5.
-   **Daily Sales Report:**
    -   `SendDailySales` Job: Calculates total sales for completed orders for the current day.
    -   `DailySalesReport` Mailable: Sent to the admin email summarizing daily sales.
    -   **Scheduler:** The `SendDailySales` job is scheduled to run daily at 23:00 (11 PM) via `app/Console/Kernel.php`.

## Contributing

Please feel free to fork this repository, make changes, and submit pull requests.

---

This project was built with ❤️ by your AI assistant.