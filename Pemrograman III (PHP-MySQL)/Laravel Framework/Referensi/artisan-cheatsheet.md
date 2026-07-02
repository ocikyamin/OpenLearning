# Artisan CLI — Cheatsheet

---

## Perintah Dasar

```bash
php artisan list                    # Semua perintah
php artisan help <perintah>         # Bantuan perintah tertentu
php artisan --version               # Versi Laravel
```

---

## Membuat File (Make)

```bash
php artisan make:controller PostController
php artisan make:controller PostController --resource    # + CRUD method
php artisan make:controller PostController --api         # API only
php artisan make:model Post
php artisan make:model Post -m                           # + migration
php artisan make:model Post -mc                          # + migration + controller
php artisan make:model Post -mcf                         # + migration + controller + factory
php artisan make:migration create_posts_table
php artisan make:seeder PostSeeder
php artisan make:factory PostFactory
php artisan make:request StorePostRequest                # Form request
php artisan make:middleware CheckRole
php artisan make:mail OrderShipped                       # Mail class
php artisan make:notification InvoicePaid                # Notification
php artisan make:event UserRegistered
php artisan make:listener SendWelcomeEmail
php artisan make:job ProcessPodcast
php artisan make:rule Uppercase                          # Validation rule
php artisan make:scope TrendingScope                     # Global scope
php artisan make:cast JsonCast                           # Custom cast
php artisan make:channel ChatChannel                     # Broadcasting channel
php artisan make:command SendEmails                      # Custom artisan command
```

---

## Database & Migration

```bash
php artisan migrate                          # Jalankan migration
php artisan migrate:fresh                    # Hapus semua tabel + migrate ulang
php artisan migrate:refresh                  # Rollback + migrate ulang
php artisan migrate:rollback                 # Rollback batch terakhir
php artisan migrate:status                   # Status migration
php artisan migrate:reset                    # Rollback semua
php artisan db:seed                          # Jalankan seeder
php artisan db:seed --class=PostSeeder       # Seeder spesifik
php artisan migrate:fresh --seed             # Fresh + seed
php artisan make:migration add_phone_to_users_table
```

---

## Route

```bash
php artisan route:list                       # Semua route
php artisan route:list --path=api            # Route API saja
php artisan route:list --except-path=api     # Route non-API
php artisan route:cache                      # Cache route (production)
php artisan route:clear                      # Hapus cache route
```

---

## Cache & Optimize

```bash
php artisan cache:clear                      # Hapus cache aplikasi
php artisan config:cache                     # Cache konfigurasi (production)
php artisan config:clear                     # Hapus cache konfigurasi
php artisan view:cache                       # Cache Blade views
php artisan view:clear                       # Hapus cache views
php artisan event:cache                      # Cache event
php artisan event:clear                      # Hapus cache event
php artisan optimize                         # Optimasi (production)
php artisan optimize:clear                   # Hapus semua cache
```

---

## Auth

```bash
# Laravel Breeze (jika diinstall)
php artisan breeze:install                   # Install Breeze (Blade)
php artisan breeze:install --api             # Breeze API only
php artisan breeze:install --dark            # Breeze + dark mode
```

---

## Storage & Link

```bash
php artisan storage:link                     # Buat symlink public/storage → storage/app/public
```

---

## Queue & Job

```bash
php artisan queue:table                      # Buat migration queue table
php artisan queue:work                        # Jalankan queue worker
php artisan queue:listen                     # Listen queue
php artisan queue:restart                    # Restart worker setelah selesai
php artisan queue:failed                     # Lihat failed jobs
php artisan queue:retry all                  # Retry semua failed jobs
php artisan queue:flush                      # Hapus failed jobs
```

---

## Tinker

```bash
php artisan tinker                           # Interactive shell

# Contoh di tinker
> Post::all();
> User::find(1)->posts;
> App\Models\User::factory()->create();
> exit;                                      # Keluar
```

---

## Testing

```bash
php artisan make:test PostTest               # Feature test
php artisan make:test PostTest --unit        # Unit test
```

---

## Vendor & Package

```bash
php artisan vendor:publish                   # Publish provider/config
php artisan vendor:publish --tag=config      # Publish konfigurasi
php artisan vendor:publish --tag=views       # Publish views
php artisan storage:link                     # Link storage
```

---

## Notifikasi

```bash
php artisan notifications:table              # Buat migration notifications table
```

---

## Debug & Log

```bash
php artisan down                             # Maintenance mode
php artisan up                               # Keluar maintenance
php artisan down --retry=60                  # Maintenance, retry after 60 detik
php artisan down --render="errors::503"      # Maintenance dengan view custom
tail -f storage/logs/laravel.log             # Lihat log (bukan artisan)
```
