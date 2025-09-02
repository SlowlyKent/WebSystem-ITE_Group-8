# Hospital Management System (HMS)

A comprehensive, role-based Hospital Management System built with CodeIgniter 4, featuring modern UI design and secure authentication.

## Features

### 🔐 Role-Based Access Control
- **Admin**: Full system access, can create IT staff accounts
- **IT Staff**: Can create and manage employee accounts (doctors, nurses, pharmacists, etc.)
- **Medical Staff**: Role-specific access to relevant modules

### 🏥 Core Modules
- User Authentication & Management
- Patient Registration & EHR (Electronic Health Records)
- Billing & Payment Processing
- Reports & Analytics
- Laboratory Management
- Pharmacy & Inventory Control
- Centralized Database Status
- Doctor/Nurse Scheduling

### 🎨 Modern UI/UX
- Responsive design with Bootstrap 5
- Beautiful gradient themes
- Interactive dashboard widgets
- Mobile-friendly interface

## System Requirements

- PHP 8.0 or higher
- MySQL 5.7 or higher / MariaDB 10.2 or higher
- Apache/Nginx web server
- Composer (for dependency management)

## Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd WebSystem-ITE_Group-8
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Database Setup
1. Create a new MySQL database named `hms_database`
2. Update database configuration in `app/Config/Database.php` if needed
3. Run migrations to create tables:
```bash
php spark migrate
```

### 4. Seed Initial Data
```bash
php spark db:seed AdminSeeder
```

### 5. Configure Web Server
Point your web server's document root to the `public` folder.

### 6. Set Permissions
Ensure the `writable` folder has write permissions:
```bash
chmod -R 755 writable/
```

## Default Login Credentials

- **Username**: `admin`
- **Password**: `admin123`
- **Role**: System Administrator

⚠️ **Important**: Change the default password after first login!

## Usage

### Admin Role
- Full access to all system modules
- Can create IT staff accounts
- System configuration and management
- User role assignment

### IT Staff Role
- Create and manage employee accounts
- Assign roles (doctor, nurse, pharmacist, receptionist)
- User status management
- Cannot create admin accounts

### Medical Staff Roles
- **Doctor**: Patient management, appointments, medical records
- **Nurse**: Patient care, scheduling, basic records
- **Pharmacist**: Medication management, inventory
- **Receptionist**: Patient registration, appointments

## File Structure

```
app/
├── Config/           # Configuration files
├── Controllers/      # Application controllers
├── Database/         # Migrations and seeders
├── Filters/          # Request filters
├── Models/           # Data models
└── Views/            # View templates
    ├── auth/         # Authentication views
    ├── dashboard/    # Dashboard views
    └── user_management/ # User management views
```

## Security Features

- Password hashing with PHP's built-in `password_hash()`
- Session-based authentication
- Role-based access control
- Input validation and sanitization
- CSRF protection
- SQL injection prevention

## Customization

### Adding New Roles
1. Update the `role` enum in the users table migration
2. Modify role hierarchy in `UserModel::hasPermission()`
3. Update role assignment logic in `UserManagementController`

### Adding New Modules
1. Create new controllers in `app/Controllers/`
2. Add routes in `app/Config/Routes.php`
3. Create corresponding views in `app/Views/`
4. Update navigation in dashboard

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Verify database credentials in `app/Config/Database.php`
   - Ensure MySQL service is running
   - Check database name exists

2. **Permission Denied Errors**
   - Verify user role assignments
   - Check role hierarchy in models
   - Ensure proper session data

3. **Migration Errors**
   - Check PHP version compatibility
   - Verify database user permissions
   - Clear any existing tables if needed

### Debug Mode
Enable debug mode in `app/Config/Boot/development.php` for detailed error messages.

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support and questions:
- Create an issue in the repository
- Contact the development team
- Check the documentation

## Changelog

### Version 1.0.0
- Initial release
- Basic authentication system
- Role-based access control
- User management
- Dashboard interface
- Patient management foundation

---

**Note**: This is a development version. For production use, ensure proper security measures, SSL certificates, and regular security updates.
