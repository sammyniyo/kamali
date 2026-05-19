# Deploy Kamali on Hostinger (shared hosting)

Repo: https://github.com/sammyniyo/kamali.git

## Before you start

On your **Mac** (build assets once — shared hosting often has no Node):

```bash
cd /Users/user/Documents/kamali
npm run build
```

You will upload `public/build/` to the server if npm is not available there.

In **hPanel**:

1. **Websites → Manage → PHP Configuration** → PHP **8.2** or **8.3**
2. **Databases → MySQL** → create database + user → note host, name, user, password
3. **Advanced → SSH Access** → enable (Premium/Business) — strongly recommended

---

## Recommended layout (SSH)

```
/home/YOUR_USER/
  kamali/              ← git clone here (NOT inside public_html)
    public/            ← Laravel web root
  domains/yourdomain.com/public_html/
```

### A) Change document root (best, if your plan allows)

**hPanel → Websites → Manage → Domains** (or **Advanced → Website settings**)

Set document root to:

```
/home/YOUR_USER/kamali/public
```

Then:

```bash
ssh YOUR_USER@YOUR_HOST
cd ~/kamali
git clone https://github.com/sammyniyo/kamali.git .
cp .env.example .env
nano .env          # see below
bash scripts/hostinger-deploy.sh
```

### B) Cannot change document root (classic shared)

1. Clone to `~/kamali` (sibling of `public_html`)
2. Copy `scripts/hostinger/public_html.index.php` → `public_html/index.php`
3. Copy `scripts/hostinger/public_html.htaccess` → `public_html/.htaccess`
4. Edit paths in both files if the folder is not named `kamali`

---

## Git deploy in hPanel (no SSH)

1. **Websites → Manage → Git**
2. Create repository → URL: `https://github.com/sammyniyo/kamali.git`, branch `main`
3. Deploy into `kamali` folder (create empty folder first via File Manager)
4. Use **File Manager** to add `.env` (copy from `.env.example`)
5. Run deploy via SSH if possible; otherwise use steps in “Manual / FTP” below

---

## `.env` on Hostinger (MySQL)

```env
APP_NAME="Kamali Architects"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://www.kamaliarchitects.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456789_kamali
DB_USERNAME=u123456789_kamali
DB_PASSWORD=your_db_password

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

Generate key (SSH):

```bash
php artisan key:generate
```

---

## SSH commands (after clone)

```bash
cd ~/kamali
bash scripts/hostinger-deploy.sh
```

If `php` is wrong version:

```bash
PHP_BIN=/opt/alt/php82/usr/bin/php bash scripts/hostinger-deploy.sh
```

Create admin user:

```bash
php artisan tinker
```

```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'you@example.com',
    'password' => bcrypt('choose-a-strong-password'),
    'is_admin' => true,
]);
```

---

## Manual / FTP only (no SSH)

1. On Mac: `composer install --no-dev`, `npm run build`
2. Zip the project **excluding** `.env`, `node_modules`, `.git`
3. Upload to `kamali/` via File Manager or FTP
4. Upload `vendor/` from your Mac OR use Hostinger’s **PHP Composer** in hPanel if available
5. Copy `.env.example` → `.env` on server and fill MySQL + `APP_URL`
6. Upload `public/build/` from your Mac
7. In hPanel **Cron Jobs**, run once (adjust paths):

   ```
   cd /home/YOUR_USER/kamali && php artisan migrate --force
   ```

8. Set folder permissions: `storage` and `bootstrap/cache` → **775**

Storage link (SSH): `php artisan storage:link`  
Without SSH, some hosts allow symlinks in File Manager; otherwise uploaded files go under `storage/app/public/`.

---

## Upload limits (admin images)

`public/.user.ini` is already in the repo. In hPanel **PHP Configuration**, set:

- `upload_max_filesize` = 32M  
- `post_max_size` = 64M  

---

## Troubleshooting

| Problem | Fix |
|--------|-----|
| 500 error | Check `storage/logs/laravel.log`; set `storage` + `bootstrap/cache` writable |
| CSS/JS missing | Run `npm run build` locally; upload `public/build/` |
| `/admin` 404 | Enable `mod_rewrite`; ensure `.htaccess` exists in `public/` |
| Database error | Use `localhost` as `DB_HOST`; exact names from hPanel MySQL |
| `vendor` missing | Run `composer install` via SSH or upload `vendor/` |

---

## Updates

**Mac:**

```bash
git push origin main
```

**Server (SSH):**

```bash
cd ~/kamali && git pull && bash scripts/hostinger-deploy.sh
```
