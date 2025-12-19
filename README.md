# Hospital Management System

A comprehensive Hospital Management System built with Laravel 10, featuring role-based access control, appointment management, medical records, billing, and more.

## 🚀 Quick Start

### Local Development
1. Clone the repository
2. Install dependencies: `composer install`
3. Copy `.env.example` to `.env` and configure
4. Generate app key: `php artisan key:generate`
5. Run migrations: `php artisan migrate`
6. Seed database: `php artisan db:seed`
7. Start server: `php artisan serve`

### Railway Deployment
See [DEPLOYMENT.md](DEPLOYMENT.md) for detailed deployment instructions or [RAILWAY_SETUP.md](RAILWAY_SETUP.md) for quick setup checklist.

## 📋 Features

- **Role-Based Access Control**: Admin, Doctor, Receptionist, Patient
- **Appointment Management**: Book, view, and manage appointments
- **Medical Records**: Create and manage patient medical records
- **Billing System**: Generate bills and track payments
- **Patient Management**: Complete patient registration and profiles
- **Doctor Management**: Manage doctors and departments
- **Modern UI**: Beautiful, responsive design with Bootstrap 5

## 🛠️ Technology Stack

- **Backend**: Laravel 10
- **Database**: MySQL
- **Frontend**: Blade Templates, Bootstrap 5, Bootstrap Icons
- **Architecture**: Clean Architecture with Repository Pattern

## 📚 Documentation

- [Setup Guide](SETUP.md)
- [Architecture Documentation](ARCHITECTURE.md)
- [Deployment Guide](DEPLOYMENT.md)
- [Railway Quick Setup](RAILWAY_SETUP.md)

## 👥 Default Accounts

After seeding, you can login with:
- **Admin**: admin@hospital.com / password
- **Doctor**: doctor1@hospital.com / password
- **Receptionist**: receptionist@hospital.com / password
- **Patient**: patient1@hospital.com / password

## 📝 License

MIT License

A comprehensive Hospital Management System built with Laravel 10/11, following Clean Architecture principles with layered architecture (Controllers → Services → Repositories).

## 🏥 System Overview

This is a production-ready hospital management system designed for college-level projects but built with real-world best practices. The system manages doctors, patients, appointments, medical records, prescriptions, and billing.

## 🎯 Features

### Authentication & Authorization
- Role-based access control (Admin, Doctor, Receptionist, Patient)
- Secure authentication with password hashing
- Middleware-based route protection

### Admin Module
- Manage doctors (CRUD operations)
- Manage patients (CRUD operations)
- Manage departments
- View hospital analytics and statistics
- Assign doctors to departments

### Doctor Module
- View assigned appointments
- Access patient medical history
- Create medical records and diagnoses
- Create prescriptions
- Mark appointments as completed

### Patient Module
- Patient registration
- View and update profile
- Book appointments
- View prescriptions
- View medical history
- View billing history

### Appointment Module
- Book, reschedule, and cancel appointments
- Doctor availability checking
- Appointment status tracking (pending, confirmed, completed, cancelled)

### Medical Records Module
- Diagnosis records
- Prescription records
- Test notes
- Secure patient history access

### Billing Module
- OPD & IPD billing
- Consultation charges
- Medicine charges
- Invoice generation
- Payment status tracking

## 🏗️ Architecture

### Clean Architecture Pattern
```
Controllers (Thin) → Services (Business Logic) → Repositories (Data Access) → Models (Eloquent)
```

### Project Structure
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   ├── Doctor/
│   │   ├── Patient/
│   │   └── Auth/
│   ├── Middleware/
│   └── Requests/
├── Models/
├── Repositories/
│   ├── Interfaces/
│   └── Implementations/
├── Services/
└── Providers/
```

## 📋 Requirements

- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Laravel >= 10.0

## 🚀 Installation

1. **Clone the repository**
   ```bash
   cd Hospital-management
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   Edit `.env` file and set your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=hospital_management
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Seed database**
   ```bash
   php artisan db:seed
   ```

7. **Start development server**
   ```bash
   php artisan serve
   ```

8. **Access the application**
   Open your browser and navigate to `http://localhost:8000`

## 👥 Default Login Credentials

After seeding the database, you can login with:

**Admin:**
- Email: `admin@hospital.com`
- Password: `password`

**Doctor:**
- Email: `doctor1@hospital.com`
- Password: `password`

**Patient:**
- Email: `patient1@hospital.com`
- Password: `password`

**Receptionist:**
- Email: `receptionist@hospital.com`
- Password: `password`

## 📊 Database Schema

### Core Tables
- `users` - User accounts with roles
- `departments` - Hospital departments
- `doctors` - Doctor profiles and specializations
- `patients` - Patient profiles and medical info
- `appointments` - Appointment scheduling
- `medical_records` - Patient medical history
- `prescriptions` - Prescription records
- `bills` - Billing information
- `bill_items` - Individual bill line items

## 🔐 Security Features

- Password hashing using bcrypt
- CSRF protection on all forms
- SQL injection prevention (Eloquent ORM)
- XSS protection (Blade templating)
- Role-based middleware protection
- Form request validation

## 🎨 UI/UX

- Bootstrap 5 for responsive design
- Bootstrap Icons for icons
- Clean and modern interface
- Role-based navigation
- Responsive tables and forms

## 📝 API Routes

The system includes RESTful API routes for:
- Authentication
- Appointments
- Medical Records
- Billing
- Patient Management

## 🧪 Testing

Run tests with:
```bash
php artisan test
```

## 📚 Code Quality

- SOLID principles
- Repository pattern for data access
- Service layer for business logic
- Form Request validation
- Proper error handling
- Code comments where needed

## 🔄 Future Enhancements

- Email notifications
- SMS integration
- PDF report generation
- Advanced analytics dashboard
- Inventory management
- Lab test management
- Insurance integration
- Multi-language support
- Mobile app API

## 📄 License

This project is open-source and available for educational purposes.

## 👨‍💻 Development

### Adding a New Module

1. Create migration: `php artisan make:migration create_module_table`
2. Create model: `php artisan make:model Module`
3. Create repository interface: `app/Repositories/Interfaces/ModuleRepositoryInterface.php`
4. Create repository implementation: `app/Repositories/Implementations/ModuleRepository.php`
5. Create service: `app/Services/ModuleService.php`
6. Create controller: `php artisan make:controller ModuleController`
7. Create form requests: `php artisan make:request StoreModuleRequest`
8. Add routes in `routes/web.php`
9. Create views in `resources/views/modules/`
10. Register repository in `RepositoryServiceProvider`

## 🤝 Contributing

This is a college project. Feel free to use it as a reference or starting point for your own projects.

## 📞 Support

For issues or questions, please refer to Laravel documentation or create an issue in the repository.

---

**Built with ❤️ using Laravel**

