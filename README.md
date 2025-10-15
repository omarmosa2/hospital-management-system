# Hospital Management System

A comprehensive Hospital Management System built with Laravel 11, featuring role-based access control, appointment management, medical records, billing, and more.

## Features

### 🔐 Authentication & Authorization
- Laravel Fortify for authentication
- Role-based access control with Spatie Laravel Permission
- 5 user roles: Admin, Doctor, Nurse, Receptionist, Patient
- Email verification and password reset

### 👥 User Management
- **Admin**: Full system control
- **Doctor**: Manage patients, appointments, medical records, prescriptions
- **Nurse**: View patient information and assist with vital data
- **Receptionist**: Manage appointments and billing
- **Patient**: View personal information, appointments, and prescriptions

### 🏥 Core Modules
- **Doctors Management**: CRUD operations with specialties and working hours
- **Patients Management**: Complete patient profiles with medical history
- **Appointments**: Scheduling, confirmation, and status tracking
- **Medical Records**: Diagnosis, symptoms, treatment plans, vital signs
- **Prescriptions**: Medicine management with dosage and instructions
- **Billing System**: Invoice generation with service tracking
- **Services Management**: Hospital services and pricing

### 📊 Dashboard & Analytics
- Role-specific dashboards
- Statistics and charts using Chart.js
- Recent appointments and bills overview
- Revenue tracking

### 📄 Additional Features
- PDF generation for invoices and reports
- Responsive design with TailwindCSS
- Modern UI/UX
- Database notifications
- Comprehensive validation

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd hospital-management-system
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database configuration**
   - Update `.env` with your database credentials
   - Run migrations and seeders:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Start the application**
   ```bash
   php artisan serve
   ```

## Default Login Credentials

The seeder creates demo users with the following credentials:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@hospital.com | password |
| Doctor | john.smith@hospital.com | password |
| Doctor | sarah.johnson@hospital.com | password |
| Nurse | mary.wilson@hospital.com | password |
| Receptionist | tom.brown@hospital.com | password |
| Patient | alice.johnson@email.com | password |
| Patient | bob.smith@email.com | password |

## Technology Stack

- **Backend**: Laravel 11
- **Frontend**: Blade templates with TailwindCSS
- **Database**: MySQL
- **Authentication**: Laravel Fortify
- **Authorization**: Spatie Laravel Permission
- **Charts**: Chart.js
- **PDF Generation**: DomPDF
- **Icons**: Heroicons

## Project Structure

```
app/
├── Http/Controllers/     # Controllers for different modules
├── Models/              # Eloquent models with relationships
├── Services/            # Business logic services
└── Repositories/        # Data access layer

database/
├── migrations/          # Database schema
└── seeders/            # Demo data and roles

resources/
├── views/
│   ├── layouts/        # Main layout templates
│   ├── dashboard/      # Dashboard views by role
│   ├── doctors/        # Doctor management views
│   ├── patients/       # Patient management views
│   └── ...
└── css/               # TailwindCSS styles

routes/
├── web.php            # Web routes
└── api.php            # API routes
```

## Key Features by Role

### Admin Dashboard
- System overview statistics
- User management
- Revenue tracking
- Appointment management
- Full CRUD access to all modules

### Doctor Dashboard
- Personal appointment schedule
- Patient management
- Medical record creation
- Prescription management
- Patient history view

### Nurse Dashboard
- Patient information access
- Appointment viewing
- Medical record viewing
- Vital signs assistance

### Receptionist Dashboard
- Appointment scheduling
- Patient registration
- Billing management
- Service management

### Patient Dashboard
- Personal appointments
- Medical records view
- Prescription history
- Bill tracking

## API Endpoints

The system provides RESTful API endpoints for all major operations:

- `GET /doctors` - List all doctors
- `POST /doctors` - Create new doctor
- `GET /doctors/{id}` - Show doctor details
- `PUT /doctors/{id}` - Update doctor
- `DELETE /doctors/{id}` - Delete doctor

Similar patterns for patients, appointments, medical records, prescriptions, and bills.

## Security Features

- CSRF protection
- SQL injection prevention
- XSS protection
- Role-based access control
- Input validation and sanitization
- Secure password hashing

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support and questions, please open an issue in the repository or contact the development team.

---

**Note**: This is a demo application for educational purposes. For production use, additional security measures and testing should be implemented.