# Rasindu Nawod — Complete Personal Portfolio & Client Management System

A complete, modern, premium, secure, and fully functional personal portfolio website and direct client portal for **Rasindu Nawod**, Web Developer & Graphic Designer from Matara, Sri Lanka.

---

## 👨‍💻 Developer Profile
- **Name**: Rasindu Nawod
- **Title**: Web Developer | Graphic Designer
- **Location**: Sri Lanka | Matara | Akuressa
- **Education**:
  - **Rahula College** — Completed 2024
  - **IMS Campus** — Graphic Design Course
  - **ICBT Campus** — Diploma in Computer and Software Engineering (Currently studying)
- **Skills**: HTML, CSS, JavaScript, PHP, Java, Tailwind CSS, Adobe Illustrator, Adobe Photoshop
- **Contact & Socials**:
  - **Phone / WhatsApp**: +94 74 386 9265
  - **Email**: razindunawod@gmail.com
  - **GitHub**: https://github.com/roky2k05
  - **LinkedIn**: https://www.linkedin.com/in/rasindu-nawod-148901374
  - **Facebook**: https://www.facebook.com/share/1F6N9ALqmG/
  - **Instagram**: https://www.instagram.com/lex_frost2k5
  - **TikTok**: https://www.tiktok.com/@rokiya2k

---

## 🛠 Technology & Architecture
- **Backend**: PHP 8+ (Modular architecture, Object-Oriented patterns, PDO prepared statements, password hashing, session regeneration)
- **Database**: MySQL (InnoDB, utf8mb4_unicode_ci, relational foreign keys with ON DELETE CASCADE)
- **Frontend**: HTML5, CSS3, JavaScript (ES6+), Tailwind CSS
- **Typography**: Outfit, Plus Jakarta Sans, JetBrains Mono
- **Security**: 
  - CSRF Token verification across all mutating forms
  - Strict IDOR mitigation (scoping queries strictly to `$_SESSION['user_id']`)
  - Session hijacking protection (`session_regenerate_id(true)`)
  - XSS mitigation with strict `htmlspecialchars()` escaping
  - SQL injection prevention via 100% PDO parameterized queries

---

## 📁 Project Structure
```
rasindu-portfolio/
│
├── index.php                 # Premium Hero section, stats, services, featured work
├── about.php                 # Full biography, design vision & background
├── education.php             # ICBT, IMS Campus, and Rahula College qualifications
├── skills.php                # Technical & design skill matrix with proficiency levels
├── services.php              # Service offerings, deliverables & project tiers
├── how-i-work.php            # 5-stage discovery-to-deployment workflow
├── projects.php              # Categorized portfolio filter (All, Web, Design)
├── project-details.php       # In-depth case study view with metrics & tech stack
├── graphic-design.php        # Vector marks, branding identities, and collateral
├── design-gallery.php        # Dedicated graphic design visual gallery
├── blog.php                  # Technical engineering & design articles
├── blog-post.php             # Full article reading interface
├── article.php               # Article view alias
├── faq.php                   # Interactive accordion FAQ
├── contact.php               # Direct inquiry form with CSRF protection
├── download-cv.php           # Secure CV download delivery endpoint
│
├── register.php              # User registration with password hashing
├── login.php                 # User login with role determination & rate protection
├── logout.php                # Session termination & cookie invalidation
├── dashboard.php             # User client portal (messages, status, notifications)
├── profile.php               # User profile management
├── messages.php              # User message & inquiry history
├── conversation.php          # 2-way real-time threaded chat between user & admin
├── notifications.php         # User alerts & reply notifications
├── account-settings.php      # Password update & profile configuration
│
├── database.sql              # Complete MySQL database schema & initial seed data
├── README.md                 # System documentation & deployment guide
│
├── config/
│   └── database.php          # PDO database connection & system constants
│
├── includes/
│   ├── header.php            # Head tags, Google Fonts, theme configurations
│   ├── navbar.php            # Responsive navbar with dark/light mode & auth state
│   ├── footer.php            # Footer, contact details & back-to-top
│   ├── functions.php         # PDO sanitization & query helpers
│   ├── auth.php              # User authentication verification guard
│   ├── admin_auth.php        # Admin role authorization guard
│   └── csrf.php              # Cryptographic CSRF token manager
│
├── admin/
│   ├── index.php             # Redirects to admin dashboard
│   ├── login.php             # Dedicated admin login screen
│   ├── logout.php            # Admin session termination
│   ├── dashboard.php         # Admin statistics & quick action console
│   ├── users.php             # User management & account control
│   ├── messages.php          # Inquiries and conversations manager
│   ├── message-view.php      # Admin reply interface & message history
│   ├── projects.php          # Project portfolio manager (Add/Edit/Delete)
│   ├── blog.php              # Blog post manager
│   ├── testimonials.php      # Client reviews manager
│   └── settings.php          # Site configurations & social links editor
│
├── assets/
│   ├── css/
│   │   └── style.css         # Custom animations & glassmorphism utilities
│   ├── js/
│   │   └── main.js           # Theme toggle, mobile drawer & dynamic interactions
│   └── cv/
│       └── Rasindu-Nawod-CV.pdf # Professional CV file
│
└── uploads/                  # Storage directory for user/project attachments
```

---

## 🚀 Setup & Local Installation (XAMPP / WAMP / LEMP)

1. **Deploy to Web Server**:
   - Copy the `/rasindu-portfolio` directory into your web server root:
     - **XAMPP Windows**: `C:\xampp\htdocs\rasindu-portfolio`
     - **XAMPP macOS**: `/Applications/XAMPP/xamppfiles/htdocs/rasindu-portfolio`
     - **Linux/Ubuntu**: `/var/www/html/rasindu-portfolio`

2. **Start Services**:
   - Start Apache and MySQL from your server control panel.

3. **Import Database Schema**:
   - Open phpMyAdmin (`http://localhost/phpmyadmin`) or your MySQL client.
   - Create a database: `rasindu_portfolio` (Collation: `utf8mb4_unicode_ci`).
   - Import `database.sql`.

4. **Verify Database Configuration**:
   - Check `config/database.php` for database settings:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_NAME', 'rasindu_portfolio');
     define('DB_USER', 'root');
     define('DB_PASS', ''); // Set your password if applicable
     ```

5. **Access Application**:
   - **Public Website**: `http://localhost/rasindu-portfolio`
   - **Initial Admin Credentials**:
     - **Username**: `rasindu`
     - **Password**: `RokyN2k0_5`
     - *Note: Please update the administrator password upon first login via Admin Settings.*

---

## 🔒 Security Verification Checklist

- **Test 1 (RBAC)**: Non-admin users attempting to navigate to `/admin/dashboard.php` are redirected with access denied.
- **Test 2 (IDOR Protection)**: Logged-in users attempting to access another user's conversation via `conversation.php?id=X` receive 403 Forbidden.
- **Test 3 (Authentication Guard)**: Logged-out visitors navigating to `dashboard.php` are redirected to `login.php`.
- **Test 4 (SQL Injection)**: All database queries utilize PDO parameterized statements with disabled emulation mode.
- **Test 5 (CSRF Mitigation)**: All post submissions require valid, session-tied CSRF tokens.
- **Test 6 (Password Hashing)**: User passwords are encrypted with `PASSWORD_BCRYPT`. Plain text is never stored.
- **Test 7 (Session Cleanliness)**: Logging out invalidates the server session, destroys the session cookie, and regenerates the session ID.
