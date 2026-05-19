# Deploy Kamali on Hostinger (shared hosting)

Repo: https://github.com/sammyniyo/kamali.git

## Before you start

On your **Mac** before deploy (`public/build` is in Git for Hostinger):

```bash
cd /Users/user/Documents/kamali
npm run build
git add public/build && git commit -m "Build assets" && git push
```

**500 “Vite manifest not found”** → `public/build/` missing. Run `git pull` on the server, or `bash scripts/pack-build.sh` and unzip `kamali-build.zip` into `public/`.

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

## Fix 403 Forbidden

Hostinger’s web root is `public_html`. Laravel must serve from the **`public`** folder.

### Check your layout

**A) Git deployed into `public_html` (whole project)**

```
public_html/
  app/
  public/          ← web requests must end up here
  vendor/
  ...
```

Copy `scripts/hostinger/public_html-laravel-in-root.htaccess` → `public_html/.htaccess`

**B) Project in `public_html/kamali/`**

Copy `scripts/hostinger/public_html-kamali-subfolder.htaccess` → `public_html/.htaccess`

**C) Best: change document root in hPanel**

Set document root to:

```
/home/u123456789/kamali/public
```

(or `.../public_html/public` if the app lives in `public_html`)

### Permissions (SSH)

```bash
find storage bootstrap/cache -type d -exec chmod 775 {} \;
find storage bootstrap/cache -type f -exec chmod 664 {} \;
chmod 755 public
```

### Quick test

Upload `scripts/hostinger/diagnostic.php` to `public_html/diagnostic.php`, open  
`https://yourdomain.com/diagnostic.php` — then **delete the file**.

---

## Uploads (images) from your Mac

Uploads live in `storage/app/public/` — **not in Git**. Local admin uploads are not on the server until you copy them.

**On your Mac:**

```bash
cd /Users/user/Documents/kamali
bash scripts/pack-uploads.sh
```

Check the script prints **file count > 0** and zip size ~several MB. If you only see `.gitignore`, you ran it before uploading anything in admin.

Upload `kamali-uploads.zip` to the same folder as `artisan` on Hostinger, then **SSH**:

```bash
cd ~/domains/YOUR_DOMAIN/public_html   # your app root
mkdir -p public/storage
unzip -o kamali-uploads.zip -d public/storage/
```

**Recommended `.env` on Hostinger** (new uploads go straight to the web folder — no symlinks):

```env
FILESYSTEM_PUBLIC_ROOT=/home/u736264619/domains/YOUR_DOMAIN/public_html/public/storage
```

Use your real path from `pwd` + `/public/storage`.

Optional sync from `storage/app/public` if you used that path:

```bash
php scripts/hostinger/link-storage.php
```

Do **not** use `php artisan storage:link` — Hostinger disables `exec()` and it will error.

Verify: `https://yourdomain.com/storage/projects/covers/SOME_FILE.jpg`

---

## Troubleshooting

| Problem | Fix |
|--------|-----|
| **500 Internal Server Error** | SSH: `bash scripts/hostinger/repair.sh` then `bash scripts/hostinger/show-log.sh`. Usually: missing `APP_KEY`, wrong MySQL in `.env`, or `php artisan migrate` not run. Use `.env.hostinger.example` as a template |
| **403 Forbidden** | See [Fix 403 Forbidden](#fix-403-forbidden) above |
| Images 404 on server | Run `bash scripts/hostinger/link-storage.sh`; upload `storage/app/public` from Mac |
| Composer “requires php >=8.4” | Pull latest `main`; run `composer install --no-dev` only |
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
