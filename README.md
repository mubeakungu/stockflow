# 🚀 StockFlow POS System

A smart, scalable Point of Sale (POS) and Inventory Management System built with Laravel, designed to streamline business operations, improve stock visibility, and enable data-driven decision-making.

---

## 🌍 Problem Statement

Many small and medium businesses rely on manual processes or disconnected tools to manage sales, inventory, and reporting. This leads to:

- Inaccurate stock tracking
- Delayed sales processing
- Poor financial visibility
- Inefficient decision-making

---

## 💡 Solution

StockFlow POS centralizes all business operations into a single platform, enabling:

- Real-time inventory tracking  
- Seamless sales and invoice management  
- Automated financial reporting  
- Improved operational efficiency  

This system serves as a **foundation for more advanced enterprise systems**, including a **Garage Management System** for vehicle servicing, repair tracking, and spare parts coordination.

---

## ✨ Key Features

### 🛍️ Product & Inventory Management
- Manage products, categories, and brands
- Track stock levels in real time
- Monitor supplier relationships

### 🧾 Sales & Invoice System
- Create invoices with multiple products
- Automatic total calculations
- Export invoices as PDF

### 👥 Customer Management
- Store customer data
- Track purchase history

### 📊 Reporting & Analytics
- Sales reports
- Profit and expense tracking
- Business performance insights

### 🔐 Authentication & Security
- Secure login system
- Role-based access control

### 📱 Responsive Design
- Works on desktop, tablet, and mobile

---

## 🛠️ Tech Stack

### Backend
- Laravel 10 (PHP Framework)
- MySQL (Database)
- Laravel Sanctum (Authentication)

### Frontend
- Blade Templates
- Vite
- JavaScript / Axios

### Tools
- DomPDF (Invoice generation)
- Faker (Test data)

---

## 🧠 System Architecture (Simplified)

- MVC Architecture (Laravel)
- RESTful APIs for data handling
- Relational database design (products, invoices, customers, suppliers)

---

## 📸 Screenshots


<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/65d41ba4-043d-4c62-847d-1f32bf2fe7bd" />
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/1cf8ab80-aac4-4b0f-972b-5306702e5b92" />
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/e5ee7ab3-23bb-4909-8585-63232a20d86b" />
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/be52e379-08f0-467c-8d44-2e4ee5ac9184" />
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/9195ffd6-0f77-450f-8d7b-068a4217aef3" />
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/62371e7d-ac81-414b-992f-d29ce373fcde" />
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/8dfd42fa-bba3-42e3-8f7f-ed20a4f6e777" />
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/dc8b8fce-f811-40b2-b459-942c0127935a" />

<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/25fcb30b-c30a-4de4-9b52-c06a8d4b0077" />
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/4af269e6-98f6-4df4-a583-022c3d00dc2b" />


---

## ⚙️ Installation Guide

### 1. Clone Repository
```bash
git clone https://github.com/yourusername/stockflow-pos.git
cd stockflow-pos
```

2. Install Dependencies
composer install
npm install

3. Setup Environment
cp .env.example .env
php artisan key:generate

4. Configure Database

Update .env:

DB_DATABASE=pos_system
DB_USERNAME=root
DB_PASSWORD=

5. Run Migrations & Seed Data
php artisan migrate --seed

6. Run Application
php artisan serve
npm run dev


🔑 Default Login
Email: admin@example.com
Password: password
