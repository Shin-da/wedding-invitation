# Modern Wedding Invitation Website

A beautiful, responsive wedding invitation website created as a commissioned project. This elegant digital invitation features a countdown timer, photo gallery with lightbox, Google Maps integration, and a classy design perfect for modern couples.

## Overview
This wedding invitation website combines modern design with functionality to create a memorable online presence for wedding celebrations. It features smooth animations, responsive design, and an intuitive user interface that works seamlessly across all devices.

## Features

- 💌 Digital Wedding Invitation
- 📝 RSVP System
- 📸 Photo Gallery
- 📅 Wedding Timeline
- 📍 Event Details
- 🎯 Responsive Design

## Technologies Used

### Frontend
- HTML5
- CSS3
- JavaScript
- Bootstrap 5
- AOS (Animate On Scroll)
- LightGallery.js
- Font Awesome
- Google Fonts

### Backend (RSVP System)
- PHP 7.4+
- MySQL 5.7+
- Apache/Nginx

Note: The hosted version on GitHub Pages only includes the static frontend. The RSVP system is deactivated for public viewing.

## Requirements

For viewing:
- Modern web browser
- Internet connection for loading external resources

For full RSVP functionality:
- XAMPP/WAMP/LAMP server
- PHP 7.4 or higher
- MySQL 5.7 or higher

## Quick Start

### Static Website (GitHub Pages Version)
1. View the live demo at https://shin-da.github.io/wedding-invitation
2. Or clone and run locally:
```bash
git clone https://github.com/Shin-da/wedding-invitation.git
cd wedding-invitation
```
Then open `index.html` in your web browser.

### Full Version with RSVP System
1. Clone the repository
2. Set up your local server (XAMPP/WAMP/LAMP)
3. Import the database:
   ```sql
   mysql -u root -p wedding < database/wedding.sql
   ```
4. Configure database connection in `config/database.php`
5. Access through your local server (e.g., http://localhost/wedding-invitation)

### Customization
- Update wedding details in `index.html`
- Modify styles in `css/main.css`
- Adjust animations in `js/main.js`
- Configure RSVP system in PHP files
- Replace images in `assets/images/`

Note: This is a commissioned project. Please respect the license terms.

## Project Structure

```
wedding-invitation/
├── assets/                # Static assets
│   ├── audio/            # Background music
│   ├── images/           # Image assets
│   │   ├── dress-code/   # Dress code examples
│   │   ├── gallery/      # Gallery images
│   │   ├── hero/         # Hero section images
│   │   └── prenup/       # Pre-wedding photos
├── config/               # Configuration files
│   └── database.php      # Database configuration
├── css/                  # Stylesheets
│   └── main.css         # Main styles
├── database/            # Database files
│   └── wedding.sql      # Database schema and data
├── includes/           # PHP includes
│   ├── header.php
│   ├── footer.php
│   └── utils.php       # Utility functions
├── js/                 # JavaScript files
│   └── main.js        # Main functionality
├── pages/             # Additional pages
│   ├── rsvp.php      # RSVP form
│   └── details.html  # Event details
└── index.html        # Main entry point
```

Note: Some PHP files are deactivated in the hosted version.

## Features in Detail

### Digital Invitation
- Beautiful and responsive design
- Smooth animations and transitions
- Our Story section with timeline
- Photo gallery with carousel

### RSVP System
- Guest registration and response tracking
- Attendance confirmation
- Special requirements input
- Admin dashboard for managing responses

### Event Details
- Wedding ceremony details
- Reception information
- Location maps and directions
- Dress code information

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

Created by Jeffmathew D. Garcia
Copyright © 2023-2025 Jeffmathew D. Garcia
All rights reserved.

This work was created as a commissioned project.
Unauthorized copying, modification, or distribution of this work is prohibited.
See the [LICENSE](LICENSE) file for details.

## Acknowledgments

- Bootstrap team for the amazing framework
- AOS library for smooth animations
- All contributors who helped with the project

## Contact

For any questions or concerns, please open an issue or contact the maintainers.

---
Made with ❤️ for celebrations
