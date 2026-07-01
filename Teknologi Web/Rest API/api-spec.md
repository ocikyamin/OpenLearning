# REST API — Users & Kontak

## Database Tables

### users (existing)
| Column | Type | Notes |
|---|---|---|
| id | bigint unsigned | PK, auto increment |
| name | varchar(255) | |
| email | varchar(255) | unique |
| email_verified_at | timestamp | nullable |
| password | varchar(255) | |
| remember_token | varchar(100) | nullable |
| created_at | timestamp | |
| updated_at | timestamp | |

### kontaks (new)
| Column | Type | Constraints |
|---|---|---|
| id | bigint unsigned | PK, auto increment |
| user_id | bigint unsigned | FK → users.id, cascade on delete |
| nama_kontak | varchar(255) | |
| nomor_hp | varchar(255) | |
| created_at | timestamp | |
| updated_at | timestamp | |

## Files to Create / Modify

| # | Action | File |
|---|---|---|
| 1 | **New** | `database/migrations/xxxx_create_kontaks_table.php` |
| 2 | **New** | `app/Models/Kontak.php` |
| 3 | **Edit** | `app/Models/User.php` — add `hasMany(Kontak)` |
| 4 | **New** | `routes/api.php` |
| 5 | **Edit** | `bootstrap/app.php` — register `api` routes |
| 6 | **New** | `app/Http/Controllers/Api/UserController.php` |
| 7 | **New** | `app/Http/Controllers/Api/KontakController.php` |
| 8 | **New** | `app/Http/Requests/StoreUserRequest.php` |
| 9 | **New** | `app/Http/Requests/UpdateUserRequest.php` |
| 10 | **New** | `app/Http/Requests/StoreKontakRequest.php` |
| 11 | **New** | `app/Http/Requests/UpdateKontakRequest.php` |
| 12 | **New** | `app/Http/Resources/UserResource.php` |
| 13 | **New** | `app/Http/Resources/KontakResource.php` |

## API Endpoints

### Users
```
POST   /api/users               Body: name, email, password
GET    /api/users
GET    /api/users/{user}
PUT    /api/users/{user}        Body: name, email, password (partial)
DELETE /api/users/{user}
```

### Kontaks
```
POST   /api/kontaks             Body: user_id, nama_kontak, nomor_hp
GET    /api/kontaks
GET    /api/kontaks/{kontak}
PUT    /api/kontaks/{kontak}    Body: user_id, nama_kontak, nomor_hp (partial)
DELETE /api/kontaks/{kontak}
```

No auth middleware — open endpoints for direct Postman testing.

## Validation Rules

### Users
- `name`: required, string, max:255
- `email`: required, email, unique:users
- `password`: required (store) / sometimes (update), string, min:8

### Kontaks
- `user_id`: required, exists:users,id
- `nama_kontak`: required, string, max:255
- `nomor_hp`: required, string, max:255

## Response Format

All responses wrapped in `data` key via API Resources:
```json
{
    "data": {
        "id": 1,
        "name": "...",
        "email": "...",
        "created_at": "..."
    }
}
```

Collection responses:
```json
{
    "data": [ ... ]
}
```

Error responses follow Laravel convention:
```json
{
    "message": "...",
    "errors": { "field": ["..."] }
}
```
