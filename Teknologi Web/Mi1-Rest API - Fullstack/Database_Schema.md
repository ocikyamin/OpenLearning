# Database Schema — TaskFlow System

## 1. Entity Relationship Diagram

```
┌───────────┐       ┌──────────────┐
│   users   │       │    tags      │
├───────────┤       ├──────────────┤
│ id (PK)   │       │ id (PK)      │
│ name      │       │ name         │
│ email     │──┐    │ color        │
│ password  │  │    └──────┬───────┘
└───────────┘  │           │
       │       │           │
       │1      │1          │ N
       │       │           │
       │  ┌────┴───────────┴────────┐
       │  │        task_tag         │
       │  │        (pivot)          │
       │  ├─────────────────────────┤
       │  │ task_id (PK,FK)         │
       │  │ tag_id  (PK,FK)         │
       │  └────────────┬────────────┘
       │               │
       │1              │ N
       │               │
       │      ┌────────┴──────────┐
       │      │      tasks        │
       │      ├───────────────────┤
       └──────┤ user_id (FK)      │
              │ id (PK)           │
              │ project_id (FK)   │
              │ title             │
              │ description       │
              │ due_date          │
              │ priority          │
              │ status            │
              └────────┬──────────┘
                       │
                       │ N
                       │
              ┌────────┴──────────┐
              │     projects      │
              ├───────────────────┤
              │ id (PK)           │
              │ user_id (FK)      │
              │ name              │
              │ description       │
              │ color             │
              └───────────────────┘
```

**Relationships:**

| Relation | Type | Notes |
|---|---|---|
| users → projects | One-to-Many | Satu user punya banyak project |
| users → tasks | One-to-Many | Satu user punya banyak task |
| projects → tasks | One-to-Many | Satu project punya banyak task (cascade delete) |
| tasks → tags | Many-to-Many | via pivot table `task_tag` |

---

## 2. Table: `users`

| Column | Type | Constraints | Default | Notes |
|---|---|---|---|---|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | | |
| name | VARCHAR(255) | NOT NULL | | |
| email | VARCHAR(255) | NOT NULL, UNIQUE | | |
| email_verified_at | TIMESTAMP | NULLABLE | NULL | |
| password | VARCHAR(255) | NOT NULL | | Hashed bcrypt |
| remember_token | VARCHAR(100) | NULLABLE | NULL | Sanctum token |
| created_at | TIMESTAMP | NULLABLE | NULL | |
| updated_at | TIMESTAMP | NULLABLE | NULL | |

**Index:** UNIQUE on `email`

---

## 3. Table: `projects`

| Column | Type | Constraints | Default | Notes |
|---|---|---|---|---|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | | |
| user_id | BIGINT UNSIGNED | NOT NULL, FOREIGN KEY → users(id) | | ON DELETE CASCADE |
| name | VARCHAR(255) | NOT NULL | | |
| description | TEXT | NULLABLE | NULL | |
| color | VARCHAR(7) | NULLABLE | NULL | Hex color, e.g. `#4A90D9` |
| created_at | TIMESTAMP | NULLABLE | NULL | |
| updated_at | TIMESTAMP | NULLABLE | NULL | |

**Index:** INDEX on `user_id`

**Foreign Key:** `user_id` REFERENCES `users(id)` ON DELETE CASCADE

---

## 4. Table: `tasks`

| Column | Type | Constraints | Default | Notes |
|---|---|---|---|---|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | | |
| project_id | BIGINT UNSIGNED | NOT NULL, FOREIGN KEY → projects(id) | | ON DELETE CASCADE |
| user_id | BIGINT UNSIGNED | NOT NULL, FOREIGN KEY → users(id) | | ON DELETE CASCADE |
| title | VARCHAR(255) | NOT NULL | | Min 5 karakter |
| description | TEXT | NULLABLE | NULL | |
| due_date | DATE | NULLABLE | NULL | Tidak boleh di masa lalu |
| priority | ENUM('low','medium','high') | NOT NULL | 'medium' | |
| status | ENUM('todo','in_progress','completed') | NOT NULL | 'todo' | |
| created_at | TIMESTAMP | NULLABLE | NULL | |
| updated_at | TIMESTAMP | NULLABLE | NULL | |

**Indexes:**
- INDEX on `project_id`
- INDEX on `user_id`
- INDEX on `status`
- INDEX on `priority`

**Foreign Keys:**
- `project_id` REFERENCES `projects(id)` ON DELETE CASCADE
- `user_id` REFERENCES `users(id)` ON DELETE CASCADE

---

## 5. Table: `tags`

| Column | Type | Constraints | Default | Notes |
|---|---|---|---|---|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | | |
| name | VARCHAR(255) | NOT NULL, UNIQUE | | e.g. "Urgent", "Work" |
| color | VARCHAR(7) | NULLABLE | NULL | Hex color, e.g. `#E74C3C` |
| created_at | TIMESTAMP | NULLABLE | NULL | |
| updated_at | TIMESTAMP | NULLABLE | NULL | |

**Index:** UNIQUE on `name`

---

## 6. Table: `task_tag` (Pivot)

| Column | Type | Constraints | Default | Notes |
|---|---|---|---|---|
| task_id | BIGINT UNSIGNED | PRIMARY KEY, FOREIGN KEY → tasks(id) | | ON DELETE CASCADE |
| tag_id | BIGINT UNSIGNED | PRIMARY KEY, FOREIGN KEY → tags(id) | | ON DELETE CASCADE |

**Primary Key:** Composite (`task_id`, `tag_id`)

**Foreign Keys:**
- `task_id` REFERENCES `tasks(id)` ON DELETE CASCADE
- `tag_id` REFERENCES `tags(id)` ON DELETE CASCADE

---

## 7. Index Summary

| Table | Index Type | Column(s) | Purpose |
|---|---|---|---|
| users | UNIQUE | email | Cegah duplikasi email |
| projects | INDEX | user_id | Optimasi query per-user |
| tasks | INDEX | project_id | Filter task per project |
| tasks | INDEX | user_id | Optimasi query per-user |
| tasks | INDEX | status | Filter by status |
| tasks | INDEX | priority | Filter by priority |
| tags | UNIQUE | name | Cegah duplikasi nama tag |
| task_tag | PRIMARY | (task_id, tag_id) | Relasi many-to-many |

---

## 8. Laravel Migration Blueprint

```php
// create_users_table
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});

// create_projects_table
Schema::create('projects', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('name');
    $table->text('description')->nullable();
    $table->string('color', 7)->nullable();
    $table->timestamps();
});

// create_tasks_table
Schema::create('tasks', function (Blueprint $table) {
    $table->id();
    $table->foreignId('project_id')->constrained()->cascadeOnDelete();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('title');
    $table->text('description')->nullable();
    $table->date('due_date')->nullable();
    $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
    $table->enum('status', ['todo', 'in_progress', 'completed'])->default('todo');
    $table->timestamps();

    $table->index('status');
    $table->index('priority');
});

// create_tags_table
Schema::create('tags', function (Blueprint $table) {
    $table->id();
    $table->string('name')->unique();
    $table->string('color', 7)->nullable();
    $table->timestamps();
});

// create_task_tag_table
Schema::create('task_tag', function (Blueprint $table) {
    $table->foreignId('task_id')->constrained()->cascadeOnDelete();
    $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
    $table->primary(['task_id', 'tag_id']);
});
```

---

## 9. Field Mapping: Database → API (CamelCase)

| Database (snake_case) | API JSON (camelCase) |
|---|---|
| `user_id` | `userId` |
| `project_id` | `projectId` |
| `due_date` | `dueDate` |
| `created_at` | `createdAt` |
| `updated_at` | `updatedAt` |
| `email_verified_at` | `emailVerifiedAt` |
| `remember_token` | `rememberToken` |
