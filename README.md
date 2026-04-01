# 🏫 School Digital Administration & Analytics Platform

[![Laravel Version](https://img.shields.io/badge/Laravel-9.x-red.svg)](https://laravel.com)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.0-blue.svg)](https://tailwindcss.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-777bb4.svg)](https://php.net)

A sophisticated, cloud-based management system designed specifically for **Kenyan secondary schools**. This platform digitizes the entire student lifecycle—from initial admission to academic graduation.

[Explore Features](#-key-features) • [Installation](#-quick-start-guide) • [User Roles](#-user-roles) • [Support](#-common-troubleshooting)

---

## 📌 Project Overview

Manual record-keeping in schools leads to data loss, slow reporting, and high administrative overhead. This platform centralizes operations into a single source of truth.

> **The Goal:** To provide real-time visibility for administrators and parents while reducing the workload for teaching staff through automated workflows.

---

## ✨ Key Features

| Category | Feature | Description |
| :--- | :--- | :--- |
| 🔐 **Security** | Role-Based Access | Multi-level access for Admin, Teacher, Parent, and Student. |
| 🎓 **Academic** | Performance Tracking | Record marks, calculate grades, and generate termly reports. |
| 🛏️ **Logistics** | Dormitory Logic | Auto-generation of rooms/beds with smart gender-based allocation. |
| ✅ **Daily Ops** | Attendance & Meals | Real-time tracking of student presence and meal check-ins. |
| 📊 **Insights** | Analytics Dashboard | Visual data on enrollment trends, staff counts, and admissions. |

---

## 🛠 Tech Stack

* **Core:** [Laravel 9](https://laravel.com/) (PHP)
* **Frontend:** Tailwind CSS, Alpine.js, Blade Templates
* **Auth:** Laravel Breeze & [Spatie Roles/Permissions](https://spatie.be/docs/laravel-permission/v5/introduction)
* **Database:** MySQL 8.0
* **Environment:** XAMPP / PHP Artisan

---

## 🚀 Quick Start Guide

### 1. Prerequisites
Ensure you have **XAMPP** (PHP 8.0+), **Composer**, and **Node.js** installed.

### 2. Installation Steps
```bash
# Clone the repository
git clone [https://github.com/your-username/school-platform.git](https://github.com/your-username/school-platform.git)
cd school-platform

# Install dependencies
composer install
npm install

# Setup Environment
cp .env.example .env
php artisan key:generate