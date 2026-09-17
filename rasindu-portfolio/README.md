# Rasindu Nawod — Personal Portfolio Website

A complete, modern, creative and responsive personal portfolio website for **Rasindu Nawod**, Web Developer & Graphic Designer based in Matara, Sri Lanka.

---

## 🛠 Technology Stack
- **Frontend**: HTML5, CSS3, JavaScript (ES6+), Tailwind CSS
- **Backend**: PHP 8+ (PDO, Prepared Statements, Sanitization, CSRF/XSS protection)
- **Database**: MySQL (utf8mb4_unicode_ci, InnoDB)
- **Design & Typography**: Plus Jakarta Sans, Outfit, JetBrains Mono, Lucide Icons

---

## 📁 Directory Structure
```
rasindu-portfolio/
│
├── index.php                 # Main website entry point
├── database.sql              # MySQL database schema and seed records
├── contact.php               # Contact form API endpoint
├── README.md                 # Setup and architecture documentation
│
├── config/
│   └── database.php          # Database credentials & PDO connection helper
│
├── includes/
│   ├── header.php            # HTML head, Google Fonts, meta tags
│   ├── navbar.php            # Responsive navigation & theme toggler
│   ├── footer.php            # Footer, social links, final CTA
│   └── functions.php         # Sanitization and database query helpers
│
├── admin/
│   ├── index.php             # Secure inquiries dashboard
│   ├── login.php             # Admin sign-in (admin / rasindu@2026)
│   ├── logout.php            # Session termination
│   └── messages.php          # Inquiry manager
│
└── assets/
    ├── css/
    │   └── style.css         # Custom animations & glassmorphism utilities
    ├── js/
    │   └── main.js           # Dark mode persistence & AJAX submission
    └── cv/
        └── Rasindu-Nawod-CV.pdf  # Resume document
```

---

## 🚀 Local Deployment with XAMPP / WampServer

1. **Copy Files to Web Root**:
   - Copy the `rasindu-portfolio` folder into your Apache `htdocs` directory:
     - **Windows**: `C:\xampp\htdocs\rasindu-portfolio`
     - **macOS**: `/Applications/XAMPP/xamppfiles/htdocs/rasindu-portfolio`
     - **Linux**: `/var/www/html/rasindu-portfolio`

2. **Start Apache & MySQL**:
   - Open the XAMPP Control Panel and start **Apache** and **MySQL**.

3. **Import Database Schema**:
   - Navigate to `http://localhost/phpmyadmin` in your browser.
   - Click **New** to create a new database named `rasindu_portfolio`.
   - Ensure the collation is set to `utf8mb4_unicode_ci`.
   - Select the newly created database and click the **Import** tab.
   - Choose the file `database.sql` located in this directory and click **Import**.

4. **Verify Database Configuration**:
   - Open `config/database.php` and verify your credentials:
     - Host: `localhost`
     - Database: `rasindu_portfolio`
     - User: `root`
     - Password: `""` (default empty password in XAMPP)

5. **Visit the Website**:
   - Public Website: `http://localhost/rasindu-portfolio`
   - Admin Panel: `http://localhost/rasindu-portfolio/admin`
     - **Username**: `admin`
     - **Password**: `rasindu@2026`

---

## 📄 Contact Details
- **Developer**: Rasindu Nawod
- **Roles**: Web Developer | Graphic Designer
- **Location**: Sri Lanka | Matara | Akuressa
- **Phone / WhatsApp**: +94 74 386 9265
- **Email**: razindunawod@gmail.com
- **GitHub**: https://github.com/roky2k05
- **LinkedIn**: https://www.linkedin.com/in/rasindu-nawod-148901374
- **Facebook**: https://www.facebook.com/share/1F6N9ALqmG/
- **Instagram**: https://www.instagram.com/lex_frost2k5?stkn=dmloMGtkc2RmZWIz
- **TikTok**: https://www.tiktok.com/@rokiya2k
