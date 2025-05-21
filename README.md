# Student Portal

A comprehensive learning management system built with PHP and MySQL, featuring a modern UI with light/dark theme support.

## Features

### Student Features
- **Dashboard Overview**
  - View enrolled courses
  - Track learning progress
  - Monitor learning streak
  - See upcoming courses
  - View recent activity

- **Course Management**
  - Browse available courses
  - Enroll in new courses
  - Track course progress
  - Continue learning from where you left off
  - View course details and descriptions

- **User Experience**
  - Light/Dark theme toggle
  - Responsive design
  - Progress tracking
  - Student statistics

### Admin Features
- **Course Management**
  - Create new courses
  - Edit existing courses
  - Delete courses
  - Manage course content

- **Student Management**
  - View all students
  - Monitor student progress
  - Manage enrollments
  - View student statistics

- **Dashboard Analytics**
  - Total students count
  - Total courses count
  - Recent enrollments
  - System statistics

## Installation

### Prerequisites
- XAMPP (PHP 8.0 or higher)
- MySQL 5.7 or higher
- Web browser (Chrome, Firefox, Safari, or Edge)

### Setup Instructions

1. **Install XAMPP**
   - Download XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
   - Install XAMPP on your system
   - Start Apache and MySQL services from XAMPP Control Panel

2. **Clone the Repository**
   ```bash
   git clone https://github.com/yourusername/student-portal.git
   ```
   - Place the cloned repository in your XAMPP's htdocs directory
   - Default path: `C:\xampp\htdocs\student-portal` (Windows) or `/Applications/XAMPP/htdocs/student-portal` (Mac)

3. **Database Setup**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create a new database named `student_portal`
   - Import the database schema from `sql/portal.sql`

4. **Configuration**
   - Open `db.php` in the root directory
   - Update database credentials if needed:
     ```php
      $host = 'localhost';
      $db = 'student_portal';
      $user = 'root';
      $pass = 'root';
      $port = 8889;   // Default MAMP MySQL port
     ```

5. **Access the Portal**
   - Student Portal: `http://localhost/student-portal`
   - Admin Portal: `http://localhost/student-portal/admin`

## Default Login Credentials

### Student Account
Register a new account like:
- Email: student@example.com
- Password: password123

### Admin Account
Register a new account like:
- Email: admin@example.com
- Password: admin123

## Usage Guide

### For Students

1. **Login**
   - Access the portal at `http://localhost/student-portal`
   - Enter your credentials
   - Click "Login"

2. **Dashboard**
   - View your enrolled courses
   - Check your learning progress
   - See your learning streak
   - View recent activity

3. **Courses**
   - Browse available courses
   - Click "Enroll" to join a course
   - Track your progress
   - Continue learning from your last position

4. **Theme Toggle**
   - Click the theme toggle button in the header
   - Switch between light and dark themes
   - Your preference is saved automatically

### For Administrators

1. **Login**
   - Access the admin portal at `http://localhost/student-portal/admin`
   - Enter admin credentials
   - Click "Login"

2. **Dashboard**
   - View system statistics
   - Monitor recent enrollments
   - Check student progress

3. **Course Management**
   - Create new courses
   - Edit existing courses
   - Delete courses
   - Manage course content

4. **Student Management**
   - View all students
   - Monitor student progress
   - Manage enrollments
   - View student statistics

## Theme Customization

The portal supports both light and dark themes. Colors can be customized in `css/themes.css`:

1. **Light Theme Colors**
   ```css
   :root {
       --text-primary: #212529;
       --text-muted: #6c757d;
       --card-bg: #ffffff;
       /* ... other variables ... */
   }
   ```

2. **Dark Theme Colors**
   ```css
   [data-theme="dark"] {
       --text-primary: #e9ecef;
       --text-muted: #adb5bd;
       --card-bg: #2c3034;
       /* ... other variables ... */
   }
   ```

## Security Features

- Password hashing
- SQL injection prevention
- XSS protection
- Session management
- Input validation
- CSRF protection

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, create an issue in the repository. 