# Modern Wedding Invitation Website

A beautiful, responsive wedding invitation website — built as a commissioned client project and shared here as a portfolio sample. It features a countdown timer, photo gallery with lightbox, event details with map integration, and an optional RSVP system.

> **Note:** This is a sanitized public version. Client photos, guest data, and private configuration have been removed. The demo uses placeholder content only.

## Features

- 💌 Digital wedding invitation with smooth animations
- 📸 Photo gallery with lightbox
- 📅 Wedding timeline / "Our Story" section
- 📍 Event details with map integration
- 📝 Optional RSVP system (PHP/MySQL)
- 🎯 Fully responsive design

## Tech Stack

**Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5, AOS, LightGallery.js, Font Awesome, Google Fonts

**Backend (optional RSVP):** PHP 7.4+, MySQL 5.7+, Apache/Nginx

## Quick Start

### Static site

```bash
git clone https://github.com/Shin-da/wedding-invitation.git
cd wedding-invitation
```

Open `index.html` in your browser.

### With the RSVP backend

1. Set up a local server (XAMPP/WAMP/LAMP).
2. Copy `config/database.example.php` to `config/database.php` and fill in your own credentials.
3. Create the database using your own schema (a sample structure is described in the docs; no real data is included).
4. Access via your local server, e.g. `http://localhost/wedding-invitation`.

## Project Structure

```
wedding-invitation/
├── assets/        # Images, fonts, media (placeholders only)
├── config/        # database.example.php (no real credentials)
├── css/           # Stylesheets
├── includes/      # PHP partials (header, footer, utils)
├── js/            # JavaScript
├── pages/         # Additional pages (RSVP, details)
└── index.html     # Entry point
```

## Credits

Designed and developed by **Shin** ([@Shin-da](https://github.com/Shin-da)).

## License

This work was created as a commissioned project and is shared for portfolio and educational purposes. Please don't redistribute or reuse it commercially without permission. See the [LICENSE](LICENSE) file.
