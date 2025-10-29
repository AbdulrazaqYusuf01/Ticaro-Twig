# Ticaro - Ticket Management App - Twig Version

A modern ticket management web application built with PHP and Twig templating engine, featuring authentication, dashboard analytics, and full CRUD operations for tickets.

## 🚀 Technologies Used

- **PHP** (v8.1+)
- **Twig** - Templating engine
- **CSS3** - Styling with responsive design
- **PHP Sessions** - Session management
- **JSON File Storage** - Data persistence

## 📋 Features

- **Landing Page** with wavy hero section and decorative elements
- **Authentication** (Login/Signup) with form validation
- **Dashboard** with ticket statistics (Total, Open, Resolved)
- **Ticket Management** (Create, Read, Update, Delete)
- **Protected Routes** with session-based authorization
- **Responsive Design** (Mobile, Tablet, Desktop)
- **Flash Messages** for user feedback

## 🛠️ Setup & Installation

### Prerequisites
- PHP 7.4 or higher
- Composer
- Web server (Apache/Nginx) or PHP built-in server

### Installation Steps

1. Clone the repository
```bash
git clone <your-repo-url>
cd ticket-app-twig
```

2. Install dependencies
```bash
composer install
```

3. Set up file permissions (for data storage)
```bash
chmod -R 755 storage/
```

4. Start the PHP development server
```bash
php -S localhost:8000 -t public
```

5. Open your browser and navigate to
```
http://localhost:8000
```

## 👤 Test Credentials

Use these credentials to log in:

- **Email:** `demo@feMentor.com`
- **Password:** `!abdul.tsx`

## 📁 Project Structure

```
├── public/              # Public web root
│   ├── index.php       # Entry point
│   ├── css/            # Stylesheets
│   └── js/             # JavaScript files
├── src/
│   ├── Controllers/    # Page controllers
│   ├── Models/         # Data models
│   └── Utils/          # Helper functions
├── templates/          # Twig template files
│   ├── layouts/        # Base layouts
│   ├── pages/          # Page templates
│   └── components/     # Reusable components
├── storage/            # Data storage (JSON files)
└── composer.json       # Dependencies
```

## 🎨 UI Components

### Layout Components
- **Hero Section** - Wavy SVG background with decorative circles
- **Navigation** - Responsive header with authentication state
- **Footer** - Consistent across all pages
- **Cards** - Box-styled components with shadows and rounded corners

### State Management
- Authentication state managed via PHP Sessions
- Tickets stored in JSON files (`storage/tickets.json`)
- User data stored in JSON files (`storage/users.json`)

## ✅ Validation Rules

- **Title:** Required field
- **Status:** Must be one of: `open`, `in_progress`, `closed`
- **Description:** Optional, max 500 characters
- All forms include server-side validation with flash messages

## 🎨 Status Color Coding

- **Open** - Green (#10B981)
- **In Progress** - Amber (#F59E0B)
- **Closed** - Gray (#6B7280)

## ♿ Accessibility

- Semantic HTML elements
- ARIA labels for interactive elements
- Keyboard navigation support
- Sufficient color contrast ratios
- Focus states on all interactive elements

## 🔒 Security Features

- Protected routes require valid PHP session
- Automatic redirect to login for unauthorized access
- Session cleared on logout
- CSRF token protection on forms
- Password hashing with `password_hash()`
- Input sanitization and validation

## 📱 Responsive Breakpoints

- **Mobile:** < 768px (Stacked layout)
- **Tablet:** 768px - 1024px (2-column grid)
- **Desktop:** > 1024px (Multi-column grid, max-width 1440px)

## 🐛 Known Issues

- Data stored in JSON files (not suitable for production)
- No database integration
- Session management is basic

## 🌐 Web Server Configuration

### Apache (.htaccess)
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

### Nginx
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

## 📝 License

This project is for educational purposes.

---

Built with ❤️ using PHP & Twig by AbdulrazaqYM
