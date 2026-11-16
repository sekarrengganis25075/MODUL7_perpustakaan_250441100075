| Key | Nilai | Keterangan |
|-----|-------|------------|
| `APP_NAME` | `Lunaria Library` | Nama aplikasi |
| `APP_ENV` | `production` | Mode production |
| `APP_KEY` | *(rahasia)* | Kunci enkripsi session/cookie |
| `APP_DEBUG` | `false` | Mencegah detail galat bocor ke pengguna |
| `APP_URL` | `https://<project>.vercel.app` | URL project Vercel |
| `DB_CONNECTION` | `pgsql` | Driver PostgreSQL |
| `DB_HOST` | `aws-0-<region>.pooler.supabase.com` | Host pooler Supabase |
| `DB_PORT` | `6543` | Transaction pooler (Vercel serverless) |
| `DB_DATABASE` | `postgres` | Nama database Supabase |
| `DB_USERNAME` | `postgres.<project-ref>` | Username pooler |
| `DB_PASSWORD` | *(rahasia)* | Password database |
| `DB_SSLMODE` | `require` | Koneksi terenkripsi SSL |
| `SESSION_DRIVER` | `database` | Filesystem Vercel read-only, session di tabel `sessions` |

Migrasi dan seeder dijalankan dari komputer lokal (Session pooler, port 5432):

```bash
php artisan config:clear
php artisan db:show
php artisan migrate
php artisan db:seed
```