# InsightStres - Student Stress Assessment System

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Python](https://img.shields.io/badge/Python-3.x-3776AB?style=for-the-badge&logo=python&logoColor=white)
![Flask](https://img.shields.io/badge/Flask-API-000000?style=for-the-badge&logo=flask&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)

**InsightStres** is a comprehensive web application designed to assess, classify, and monitor student stress levels using Machine Learning. It combines a robust **Laravel 11** backend with a **Python Flask** API powered by a **Random Forest Classifier** to provide real-time stress analysis and personalized feedback.

---

## Table of Contents
- [Core Features](#core-features)
  - [User Features](#user-features)
  - [Admin Features](#admin-features)
  - [Security Features](#security-features)
- [Tech Stack](#tech-stack)
- [System Requirements](#system-requirements)
- [Local Development Setup](#local-development-setup)
- [Deployment Guide](#deployment-guide)
  - [1. Deploying Laravel to Shared Hosting (cPanel)](#1-deploying-laravel-to-shared-hosting-cpanel)
  - [2. Deploying Flask API to PythonAnywhere](#2-deploying-flask-api-to-pythonanywhere)
- [API Documentation](#api-documentation)
- [Project Structure](#project-structure)
- [License](#license)

---

## Core Features

### User Features
- **Smart Stress Assessment:** A 23-item questionnaire based on standardized stress indicators.
- **AI Prediction:** Real-time classification into *No Stress*, *Eustress* (Positive Stress), or *Distress* (Negative Stress).
- **Interactive Dashboard:** Monitor stress history, visualize assessment trends, and track personal progress.
- **Breathing Exercises:** Integrated interactive guided breathing tool for immediate stress relief.
- **Personalized Tips:** Educational articles and tips tailored to the user's current stress category.
- **Notification System:** Stay updated with assessment reminders and system announcements.
- **Export & Reporting:** Download assessment results and stress analysis in PDF or CSV format.
- **Profile Management:** Securely manage personal data, password updates, and email notification preferences.

### Admin Features
- **Comprehensive Analytics:** Visual dashboard displaying user growth, stress distribution, and system activity.
- **User Management:** Full CRUD (Create, Read, Update, Delete) capabilities for managing student accounts.
- **Assessment Monitoring:** Review and analyze all student assessment data with advanced filtering.
- **Content Management:** Manage educational tips and articles to keep resources relevant.
- **Feedback Management:** Review and respond to user-submitted feedback.
- **System Settings:** Configure application parameters and perform database backups.
- **Advanced Export:** Export analytics and user data to professional PDF and Excel reports.

### Security Features
- **Secure Authentication:** Multi-role (Admin/User) authentication system.
- **Email Verification:** Required email confirmation to ensure valid user registration.
- **Password Recovery:** Automated secure password reset flow via email.

---

## Tech Stack

### Backend (Web)
- **Framework:** Laravel 11
- **Language:** PHP 8.2+
- **Database:** MySQL 8.0 / MariaDB
- **Frontend:** Blade Templates, TailwindCSS, Alpine.js

### Machine Learning (API)
- **Framework:** Flask (Python Microframework)
- **Language:** Python 3.9+
- **Libraries:** Scikit-learn, Pandas, NumPy, Joblib
- **Model:** Random Forest Classifier

---

## System Requirements
Before you begin, ensure you have the following installed:
- **PHP** >= 8.2 (with extensions: bcmath, ctype, fileinfo, json, mbstring, openssl, pdo, tokenizer, xml)
- **Composer** (PHP Dependency Manager)
- **Node.js** & **NPM** (for frontend assets)
- **Python** 3.x & **PIP**

---

## Local Development Setup

### 1. Clone Repository
```bash
git clone https://github.com/ravenyne/insightstres.git
cd insightstres
```

### 2. Setup Laravel (Web App)
```bash
# Install PHP dependencies
composer install

# Create environment file
cp .env.example .env

# Generate Application Key
php artisan key:generate

# Configure Database in .env
# DB_DATABASE=insightstres
# DB_USERNAME=root
# DB_PASSWORD=

# Run Migrations & Seeders
php artisan migrate --seed

# Install & Build Frontend Assets
npm install && npm run build

# Start Laravel Server
php artisan serve
```
*Laravel will run at: http://127.0.0.1:8000*

### 3. Setup Python API (Machine Learning)
Open a new terminal window:
```bash
cd machine_learning

# Create Virtual Environment
python -m venv venv

# Activate Virtual Environment
# Windows:
venv\Scripts\activate
# Mac/Linux:
source venv/bin/activate

# Install Dependencies
pip install -r requirements.txt

# Start Flask API
python api/app.py
```
*API will run at: http://127.0.0.1:5000*

### 4. Connect Them
Ensure your Laravel `.env` points to the local Flask API:
```env
ML_API_URL=http://127.0.0.1:5000
```

### 5. Default Credentials (After Seeding)
After running `php artisan migrate --seed`, you can log in using these accounts:

**Admin:**
- Email: `rachel@insightstres.lain.ch`
- Password: `marushy00`

**User:**
- Email: `demouser@insightstres.lain.ch`
- Password: `demouser123`

---

## Deployment Guide

### 1. Deploying Laravel to Shared Hosting (cPanel)

1.  **Prepare Files:**
    - Run `npm run build` locally to compile assets.
    - Zip the entire project content (excluding `node_modules`, `venv`, and `.git`).

2.  **Upload to Server:**
    - Upload the zip file to your hosting (e.g., inside a folder named `insightstres` *outside* the `public_html` directory for security).
    - Extract the files.

3.  **Setup Public Folder:**
    - Move the contents of `insightstres/public` to your domain's root folder (e.g., `public_html`).
    - Edit `public_html/index.php` to point to the correct paths:
      ```php
      require __DIR__.'/../insightstres/vendor/autoload.php';
      $app = require __DIR__.'/../insightstres/bootstrap/app.php';
      ```

4.  **Database Configuration:**
    - Create a MySQL database & user in cPanel.
    - Import your local database (`.sql` file) via phpMyAdmin.
    - Update the `.env` file in the `insightstres` folder with production DB credentials.

5.  **Storage Symlink:**
    - Create a symlink to ensure uploaded files are accessible:
      - If you have SSH: `ln -s /path/to/insightstres/storage/app/public /path/to/public_html/storage`
      - Or use a PHP script to create the link.

### 2. Deploying Flask API to PythonAnywhere

1.  **Code Upload:**
    - Go to the **Files** tab on PythonAnywhere.
    - Upload your `machine_learning` folder. (Tip: Zip it locally, upload, and use the Bash console to unzip).
    - Recommendation: Place it in `/home/yourusername/mysite/machine_learning`.

2.  **Environment Setup:**
    - Open a **Bash** console and navigate to the folder:
      ```bash
      cd mysite/machine_learning
      mkvirtualenv --python=/usr/bin/python3.10 myenv
      pip install -r requirements.txt
      ```

3.  **Web App Configuration:**
    - Go to the **Web** tab and "Add a new web app".
    - Choose "Manual Configuration" and select the Python version used in your virtualenv.
    - Set the **Source code** path: `/home/yourusername/mysite/machine_learning/api`.
    - Set the **Virtualenv** path: `/home/yourusername/.virtualenvs/myenv`.

4.  **WSGI Configuration File:**
    - Click the link to edit the WSGI configuration file. Replace its content with:
      ```python
      import sys
      import os

      project_home = '/home/yourusername/mysite/machine_learning/api'
      if project_home not in sys.path:
          sys.path = [project_home] + sys.path

      from app import app as application
      ```

5.  **Final Integration:**
    - Update your Laravel `.env` on the shared hosting to point to the new PythonAnywhere URL:
      ```env
      ML_API_URL=https://yourusername.pythonanywhere.com
      ```

---

## API Documentation

### Base URL
- Local: `http://127.0.0.1:5000`
- Production: `https://yourusername.pythonanywhere.com`

### Endpoints

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/health` | Check API status & model readiness |
| `POST` | `/predict` | Submit questionnaire answers for stress classification |

#### Predict Response Example
```json
{
  "label": 1,
  "category": "Eustress"
}
```

---

## Project Structure

```bash
insightstres/
├── app/                  # Core Laravel Logic (Models, Controllers, Services)
├── machine_learning/     # Python ML Components
│   ├── api/              # Flask API (app.py)
│   ├── dataset/          # Training Datasets (CSV)
│   ├── models/           # Trained ML Models (.joblib)
│   └── train/            # Model Training Scripts
├── public/               # Web Entry Point & Compiled Assets
├── resources/            # Views (Blade) & Source Assets (CSS/JS)
└── routes/               # Web & API Route Definitions
```

## License
This project is licensed under the [MIT license](https://opensource.org/licenses/MIT).