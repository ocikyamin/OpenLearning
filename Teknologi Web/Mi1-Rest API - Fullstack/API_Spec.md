# API Specification Document — TaskFlow System

## 1. Overview

| Attribute | Value |
|---|---|
| **Base URL** | `http://localhost:8000/api` |
| **Format** | JSON (CamelCase) |
| **Auth** | Laravel Sanctum (Bearer Token) |
| **Protocol** | HTTP/HTTPS |

### Headers

```
Accept: application/json
Content-Type: application/json
Authorization: Bearer <token>
```

---

## 2. Authentication Endpoints

### 2.1 Register

Mendaftarkan user baru.

**Request**

```
POST /api/register
```

```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response** `201 Created`

```json
{
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "token": "1|abc123..."
}
```

### 2.2 Login

Mendapatkan token akses.

**Request**

```
POST /api/login
```

```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response** `200 OK`

```json
{
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "token": "1|abc123..."
}
```

### 2.3 Logout

Mencabut (revoke) token akses.

**Request**

```
POST /api/logout
Authorization: Bearer <token>
```

**Response** `200 OK`

```json
{
  "message": "Logged out successfully"
}
```

### 2.4 Get Authenticated User

Menampilkan profil user yang sedang login.

**Request**

```
GET /api/user
Authorization: Bearer <token>
```

**Response** `200 OK`

```json
{
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  }
}
```

---

## 3. Project Endpoints

### 3.1 List Projects

Menampilkan semua proyek milik user.

**Request**

```
GET /api/projects
Authorization: Bearer <token>
```

**Response** `200 OK`

```json
{
  "data": [
    {
      "id": 1,
      "userId": 1,
      "name": "Work Tasks",
      "description": "Office related tasks",
      "color": "#4A90D9",
      "createdAt": "2026-07-01T08:00:00.000000Z",
      "updatedAt": "2026-07-01T08:00:00.000000Z"
    }
  ]
}
```

### 3.2 Create Project

**Request**

```
POST /api/projects
Authorization: Bearer <token>
```

```json
{
  "name": "Work Tasks",
  "description": "Office related tasks",
  "color": "#4A90D9"
}
```

**Response** `201 Created`

```json
{
  "data": {
    "id": 2,
    "userId": 1,
    "name": "Work Tasks",
    "description": "Office related tasks",
    "color": "#4A90D9",
    "createdAt": "2026-07-02T10:00:00.000000Z",
    "updatedAt": "2026-07-02T10:00:00.000000Z"
  },
  "message": "Project created successfully"
}
```

### 3.3 Show Project

**Request**

```
GET /api/projects/{id}
Authorization: Bearer <token>
```

**Response** `200 OK`

```json
{
  "data": {
    "id": 1,
    "userId": 1,
    "name": "Work Tasks",
    "description": "Office related tasks",
    "color": "#4A90D9",
    "tasks": [
      {
        "id": 1,
        "title": "Finish report"
      }
    ],
    "createdAt": "2026-07-01T08:00:00.000000Z",
    "updatedAt": "2026-07-02T10:00:00.000000Z"
  }
}
```

### 3.4 Update Project

**Request**

```
PUT /api/projects/{id}
Authorization: Bearer <token>
```

```json
{
  "name": "Personal Tasks",
  "description": "Updated description",
  "color": "#E74C3C"
}
```

**Response** `200 OK`

```json
{
  "data": {
    "id": 1,
    "userId": 1,
    "name": "Personal Tasks",
    "description": "Updated description",
    "color": "#E74C3C",
    "createdAt": "2026-07-01T08:00:00.000000Z",
    "updatedAt": "2026-07-02T11:00:00.000000Z"
  },
  "message": "Project updated successfully"
}
```

### 3.5 Delete Project

Menghapus proyek beserta semua tugas di dalamnya (cascading delete).

**Request**

```
DELETE /api/projects/{id}
Authorization: Bearer <token>
```

**Response** `200 OK`

```json
{
  "message": "Project deleted successfully"
}
```

---

## 4. Task Endpoints

### 4.1 List Tasks (by Project)

Menampilkan semua tugas dalam satu proyek. Mendukung filtering.

**Request**

```
GET /api/projects/{id}/tasks?status=in_progress&priority=high
Authorization: Bearer <token>
```

| Parameter | Type | Description |
|---|---|---|
| `status` | string | Filter: `todo`, `in_progress`, `completed` |
| `priority` | string | Filter: `low`, `medium`, `high` |

**Response** `200 OK`

```json
{
  "data": [
    {
      "id": 1,
      "projectId": 1,
      "userId": 1,
      "title": "Finish API documentation",
      "description": "Write complete API spec",
      "dueDate": "2026-07-10",
      "priority": "high",
      "status": "in_progress",
      "tags": [
        {
          "id": 1,
          "name": "Urgent",
          "color": "#E74C3C"
        }
      ],
      "createdAt": "2026-07-01T08:00:00.000000Z",
      "updatedAt": "2026-07-02T09:00:00.000000Z"
    }
  ]
}
```

### 4.2 Create Task

**Request**

```
POST /api/projects/{id}/tasks
Authorization: Bearer <token>
```

```json
{
  "title": "Finish API documentation",
  "description": "Write complete API spec",
  "dueDate": "2026-07-10",
  "priority": "high"
}
```

**Response** `201 Created`

```json
{
  "data": {
    "id": 1,
    "projectId": 1,
    "userId": 1,
    "title": "Finish API documentation",
    "description": "Write complete API spec",
    "dueDate": "2026-07-10",
    "priority": "high",
    "status": "todo",
    "tags": [],
    "createdAt": "2026-07-02T10:00:00.000000Z",
    "updatedAt": "2026-07-02T10:00:00.000000Z"
  },
  "message": "Task created successfully"
}
```

### 4.3 Show Task

**Request**

```
GET /api/tasks/{id}
Authorization: Bearer <token>
```

**Response** `200 OK`

```json
{
  "data": {
    "id": 1,
    "projectId": 1,
    "userId": 1,
    "title": "Finish API documentation",
    "description": "Write complete API spec",
    "dueDate": "2026-07-10",
    "priority": "high",
    "status": "in_progress",
    "project": {
      "id": 1,
      "name": "Work Tasks"
    },
    "tags": [
      {
        "id": 1,
        "name": "Urgent",
        "color": "#E74C3C"
      }
    ],
    "createdAt": "2026-07-01T08:00:00.000000Z",
    "updatedAt": "2026-07-02T09:00:00.000000Z"
  }
}
```

### 4.4 Update Task

**Request**

```
PUT /api/tasks/{id}
Authorization: Bearer <token>
```

```json
{
  "title": "Finish API documentation v2",
  "description": "Updated description",
  "dueDate": "2026-07-12",
  "priority": "medium"
}
```

**Response** `200 OK`

```json
{
  "data": {
    "id": 1,
    "projectId": 1,
    "userId": 1,
    "title": "Finish API documentation v2",
    "description": "Updated description",
    "dueDate": "2026-07-12",
    "priority": "medium",
    "status": "in_progress",
    "tags": [
      {
        "id": 1,
        "name": "Urgent",
        "color": "#E74C3C"
      }
    ],
    "createdAt": "2026-07-01T08:00:00.000000Z",
    "updatedAt": "2026-07-02T11:00:00.000000Z"
  },
  "message": "Task updated successfully"
}
```

### 4.5 Update Task Status

**Request**

```
PATCH /api/tasks/{id}/status
Authorization: Bearer <token>
```

```json
{
  "status": "completed"
}
```

| Value | Description |
|---|---|
| `todo` | Belum dikerjakan |
| `in_progress` | Sedang dikerjakan |
| `completed` | Selesai |

**Response** `200 OK`

```json
{
  "data": {
    "id": 1,
    "projectId": 1,
    "userId": 1,
    "title": "Finish API documentation",
    "status": "completed",
    "updatedAt": "2026-07-02T12:00:00.000000Z"
  },
  "message": "Task status updated successfully"
}
```

### 4.6 Delete Task

**Request**

```
DELETE /api/tasks/{id}
Authorization: Bearer <token>
```

**Response** `200 OK`

```json
{
  "message": "Task deleted successfully"
}
```

---

## 5. Tag Endpoints

### 5.1 List Tags

**Request**

```
GET /api/tags
Authorization: Bearer <token>
```

**Response** `200 OK`

```json
{
  "data": [
    {
      "id": 1,
      "name": "Urgent",
      "color": "#E74C3C"
    },
    {
      "id": 2,
      "name": "Work",
      "color": "#3498DB"
    }
  ]
}
```

### 5.2 Create Tag

**Request**

```
POST /api/tags
Authorization: Bearer <token>
```

```json
{
  "name": "Personal",
  "color": "#2ECC71"
}
```

**Response** `201 Created`

```json
{
  "data": {
    "id": 3,
    "name": "Personal",
    "color": "#2ECC71"
  },
  "message": "Tag created successfully"
}
```

### 5.3 Update Tag

**Request**

```
PUT /api/tags/{id}
Authorization: Bearer <token>
```

```json
{
  "name": "Very Urgent",
  "color": "#C0392B"
}
```

**Response** `200 OK`

```json
{
  "data": {
    "id": 1,
    "name": "Very Urgent",
    "color": "#C0392B"
  },
  "message": "Tag updated successfully"
}
```

### 5.4 Delete Tag

**Request**

```
DELETE /api/tags/{id}
Authorization: Bearer <token>
```

**Response** `200 OK`

```json
{
  "message": "Tag deleted successfully"
}
```

### 5.5 Attach Tags to Task

**Request**

```
POST /api/tasks/{id}/tags
Authorization: Bearer <token>
```

```json
{
  "tags": [1, 2]
}
```

**Response** `200 OK`

```json
{
  "data": {
    "id": 1,
    "title": "Finish API documentation",
    "tags": [
      {
        "id": 1,
        "name": "Urgent",
        "color": "#E74C3C"
      },
      {
        "id": 2,
        "name": "Work",
        "color": "#3498DB"
      }
    ]
  },
  "message": "Tags attached successfully"
}
```

### 5.6 Detach Tag from Task

**Request**

```
DELETE /api/tasks/{id}/tags/{tagId}
Authorization: Bearer <token>
```

**Response** `200 OK`

```json
{
  "message": "Tag detached successfully"
}
```

---

## 6. Error Responses

### 6.1 Validation Error (422)

```json
{
  "message": "Validation failed",
  "errors": {
    "title": ["The title must be at least 5 characters."],
    "dueDate": ["The due date must not be in the past."]
  }
}
```

### 6.2 Unauthenticated (401)

```json
{
  "message": "Unauthenticated"
}
```

### 6.3 Forbidden (403)

```json
{
  "message": "Forbidden"
}
```

### 6.4 Not Found (404)

```json
{
  "message": "Resource not found"
}
```

---

## 7. Business Rules & Constraints

| Rule | Description |
|---|---|
| **Data Isolation** | User hanya bisa mengakses proyek/tugas/tag miliknya sendiri. |
| **Title Validation** | Wajib diisi, minimal 5 karakter. |
| **Due Date** | Tidak boleh di masa lalu. |
| **CamelCase** | Semua response JSON menggunakan format camelCase (e.g. `dueDate`, `userId`, `createdAt`). |
| **Cascade Delete** | Menghapus proyek akan menghapus semua tugas di dalamnya. |

---

## 8. Entity Relationship Summary

| Entity | Table | Attributes | Relations |
|---|---|---|---|
| **User** | `users` | `id`, `name`, `email`, `password` | HasMany Projects, HasMany Tasks |
| **Project** | `projects` | `id`, `user_id`, `name`, `description`, `color` | BelongsTo User, HasMany Tasks |
| **Task** | `tasks` | `id`, `project_id`, `user_id`, `title`, `description`, `due_date`, `priority`, `status` | BelongsTo Project, BelongsToMany Tags |
| **Tag** | `tags` | `id`, `name`, `color` | BelongsToMany Tasks |
| **Task_Tag** | `task_tag` | `task_id`, `tag_id` | Pivot table |

---

## 9. Endpoint Summary Table

| Method | Endpoint | Auth | Description |
|---|---|---|---|
| POST | `/api/register` | No | Register user |
| POST | `/api/login` | No | Login & get token |
| POST | `/api/logout` | Yes | Revoke token |
| GET | `/api/user` | Yes | Get profile |
| GET | `/api/projects` | Yes | List projects |
| POST | `/api/projects` | Yes | Create project |
| GET | `/api/projects/{id}` | Yes | Show project |
| PUT | `/api/projects/{id}` | Yes | Update project |
| DELETE | `/api/projects/{id}` | Yes | Delete project |
| GET | `/api/projects/{id}/tasks` | Yes | List tasks (with filters) |
| POST | `/api/projects/{id}/tasks` | Yes | Create task |
| GET | `/api/tasks/{id}` | Yes | Show task |
| PUT | `/api/tasks/{id}` | Yes | Update task |
| PATCH | `/api/tasks/{id}/status` | Yes | Update task status |
| DELETE | `/api/tasks/{id}` | Yes | Delete task |
| GET | `/api/tags` | Yes | List tags |
| POST | `/api/tags` | Yes | Create tag |
| PUT | `/api/tags/{id}` | Yes | Update tag |
| DELETE | `/api/tags/{id}` | Yes | Delete tag |
| POST | `/api/tasks/{id}/tags` | Yes | Attach tags to task |
| DELETE | `/api/tasks/{id}/tags/{tagId}` | Yes | Detach tag from task |
