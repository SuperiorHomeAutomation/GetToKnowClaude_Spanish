# GetToKnowClaude.com — AWS Deployment Guide
**Server:** AWS EC2 · Nginx already installed
**Target date:** Monday April 14, 2026

---

## STEP 1 — SSH into your server

```bash
ssh -i your-key.pem ubuntu@YOUR_SERVER_IP
```

---

## STEP 2 — Install PHP, MySQL, and WordPress dependencies

```bash
sudo apt update && sudo apt upgrade -y

# PHP 8.2
sudo apt install -y php8.2 php8.2-fpm php8.2-mysql php8.2-curl \
  php8.2-gd php8.2-mbstring php8.2-xml php8.2-zip php8.2-intl

# MySQL
sudo apt install -y mysql-server
sudo mysql_secure_installation

# Other tools
sudo apt install -y unzip curl
```

---

## STEP 3 — Create the MySQL database

```bash
sudo mysql -u root -p
```

Then inside MySQL:

```sql
CREATE DATABASE gtkc_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'gtkc_user'@'localhost' IDENTIFIED BY 'CHOOSE_A_STRONG_PASSWORD';
GRANT ALL PRIVILEGES ON gtkc_db.* TO 'gtkc_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

**Save these:** database name: `gtkc_db`, user: `gtkc_user`, password: what you chose.

---

## STEP 4 — Install WordPress

```bash
cd /var/www
sudo wget https://wordpress.org/latest.tar.gz
sudo tar -xzf latest.tar.gz
sudo mv wordpress gettoknowclaude
sudo rm latest.tar.gz

# Set permissions
sudo chown -R www-data:www-data /var/www/gettoknowclaude
sudo chmod -R 755 /var/www/gettoknowclaude

# Create wp-config.php
cd /var/www/gettoknowclaude
sudo cp wp-config-sample.php wp-config.php
sudo nano wp-config.php
```

In wp-config.php, update these lines:
```php
define( 'DB_NAME',     'gtkc_db' );
define( 'DB_USER',     'gtkc_user' );
define( 'DB_PASSWORD', 'YOUR_PASSWORD' );
define( 'DB_HOST',     'localhost' );
```

Also replace the salts section using: https://api.wordpress.org/secret-key/1.1/salt/

---

## STEP 5 — Configure Nginx

```bash
sudo nano /etc/nginx/sites-available/gettoknowclaude
```

Paste this configuration:

```nginx
server {
    listen 80;
    server_name gettoknowclaude.com www.gettoknowclaude.com;
    root /var/www/gettoknowclaude;
    index index.php index.html;

    # WordPress permalinks
    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    # PHP processing
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Security: block sensitive files
    location ~ /\.ht { deny all; }
    location = /wp-config.php { deny all; }

    # Static asset caching
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|woff2)$ {
        expires 30d;
        add_header Cache-Control "public, no-transform";
    }

    client_max_body_size 64M;
}
```

Enable it:
```bash
sudo ln -s /etc/nginx/sites-available/gettoknowclaude /etc/nginx/sites-enabled/
sudo rm /etc/nginx/sites-enabled/default
sudo nginx -t
sudo systemctl reload nginx
sudo systemctl restart php8.2-fpm
```

---

## STEP 6 — Install SSL (Let's Encrypt)

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d gettoknowclaude.com -d www.gettoknowclaude.com
```

Follow the prompts. Certbot updates Nginx config automatically.
SSL auto-renews every 90 days.

---

## STEP 7 — Complete WordPress installation

Visit **http://gettoknowclaude.com** in your browser.
The WordPress installation wizard will appear. Fill in:
- Site title: `Get To Know Claude`
- Username: (choose your admin username)
- Password: (strong password — save it!)
- Email: your email address

Click **Install WordPress**.

---

## STEP 8 — Upload and activate the theme

**Option A — WordPress Admin (easiest)**
1. Log in to `https://gettoknowclaude.com/wp-admin`
2. Go to **Appearance → Themes → Add New → Upload Theme**
3. Upload `gtkc-theme.zip`
4. Click **Activate**

**Option B — SCP (from your local machine)**
```bash
scp -i your-key.pem gtkc-theme.zip ubuntu@YOUR_SERVER_IP:/tmp/
ssh -i your-key.pem ubuntu@YOUR_SERVER_IP
sudo unzip /tmp/gtkc-theme.zip -d /var/www/gettoknowclaude/wp-content/themes/
sudo chown -R www-data:www-data /var/www/gettoknowclaude/wp-content/themes/gtkc
```
Then activate in WordPress Admin → Appearance → Themes.

---

## STEP 9 — Create WordPress pages

In WP Admin → Pages → Add New, create these pages:

| Page Title       | Template to select      | Slug            |
|------------------|------------------------|-----------------|
| Home             | (set as front page)     | (home)          |
| About            | About                  | about           |
| Privacy Policy   | Privacy Policy         | privacy-policy  |
| Coming Soon      | Coming Soon            | coming-soon     |

**Set the front page:**
Settings → Reading → "A static page" → Front page: Home

**Set permalinks:**
Settings → Permalinks → Post name → Save

---

## STEP 10 — Install recommended plugins

Go to **Plugins → Add New** and install:

| Plugin | Purpose |
|--------|---------|
| **WP Mail SMTP** | Reliable email delivery (use Gmail or SendGrid) |
| **WP 2FA** | Two-factor authentication for admin |
| **Wordfence Security** | Firewall and malware scan |
| **WP Super Cache** | Caching for traffic spikes |

---

## STEP 11 — Configure email (important before launch)

WordPress uses PHP mail by default, which often goes to spam.
Install **WP Mail SMTP** and connect it to:
- Gmail (free, reliable for low volume)
- SendGrid (free tier: 100 emails/day — good for subscriber notifications)

---

## STEP 12 — Upload book cover images

Upload these images to `/var/www/gettoknowclaude/wp-content/themes/gtkc/images/`:
- `book-cover.jpg` — Get To Know Claude cover (for hero section)
- `done-with-windows-cover.jpg` — when available
- `lets-make-a-gadget-cover.jpg` — when available

```bash
scp -i your-key.pem book-cover.jpg ubuntu@YOUR_SERVER_IP:/tmp/
ssh -i your-key.pem ubuntu@YOUR_SERVER_IP
sudo mv /tmp/book-cover.jpg /var/www/gettoknowclaude/wp-content/themes/gtkc/images/
sudo chown www-data:www-data /var/www/gettoknowclaude/wp-content/themes/gtkc/images/book-cover.jpg
```

---

## STEP 13 — Update the Kindle link

Once your Amazon listing is live, update the buy link in two places:
1. `header.php` — the "Buy on Kindle" button in the nav
2. `front-page.php` — the hero "Buy on Kindle" button
3. `footer.php` — the footer link

Search for `https://www.amazon.com` and replace with your actual Amazon listing URL.

Or easier: use WP Admin → Appearance → Theme Editor (or just SCP the files).

---

## Adding Errata (after launch)

1. WP Admin → Errata → Add New
2. Title: describe the error briefly
3. Custom fields to fill in:
   - `chapter` — e.g. "Chapter 3 — How to Ask Claude Well"
   - `page_number` — e.g. "47"
   - `original_text` — the incorrect text
   - `corrected_text` — the corrected text
4. Publish → subscribers with errata preference are notified automatically

---

## Adding Articles (after launch)

1. WP Admin → Articles → Add New
2. Write your article in the editor
3. Assign an Article Category (create categories as needed)
4. Publish → subscribers with articles preference are notified automatically

---

## Traffic spike preparation

Before Monday's launch:
```bash
# Enable WP Super Cache (do this in WP Admin after installing the plugin)
# Also confirm Nginx has enough worker processes:
sudo nano /etc/nginx/nginx.conf
# Set: worker_processes auto;
# Set: worker_connections 1024;
sudo systemctl reload nginx
```

---

## Summary checklist

- [ ] PHP 8.2 installed
- [ ] MySQL installed + database created
- [ ] WordPress installed
- [ ] Nginx configured
- [ ] SSL active (https working)
- [ ] Theme uploaded and activated
- [ ] Pages created with correct templates
- [ ] Front page set to Home
- [ ] Permalinks set to Post name
- [ ] WP Mail SMTP configured
- [ ] WP 2FA enabled for admin
- [ ] Book cover image uploaded
- [ ] Kindle link updated (once listing is live)
- [ ] WP Super Cache enabled

---

*Generated April 11, 2026 for GetToKnowClaude.com*
*Superior Home Automation Corp. · Port Colborne, Ontario, Canada*
