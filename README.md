# Notes App - Laravel

A modern personal note-taking application built with Laravel 13, featuring pinned notes, categorization, tagging, archive workflows, and soft-delete trash recovery.

Repository: https://github.com/0xyz-exe/notes-app-laravel

## Screenshots

### Notes Grid & Pinned Notes
![Notes grid](docs/screenshots/01_notes_grid.png)

### Create & Edit Note
![Note editor](docs/screenshots/02_note_editor.png)

### Archived Notes View
![Archived notes](docs/screenshots/03_archived_notes.png)

### Trash & Recovery Management
![Trash recovery](docs/screenshots/04_trash_recovery.png)

### Authentication
![Authentication](docs/screenshots/05_login.png)

## Features

- **Full Note CRUD:** Create, read, update, and manage rich notes with titles, markdown content, and categories.
- **Pin to Top:** Keep critical notes highlighted and pinned above the standard note stream.
- **Categorization & Tags:** Organize thoughts by flexible categories and searchable tag arrays.
- **Archive System:** Archive completed notes to declutter the active workspace without deleting them.
- **Soft Delete & Trash Bin:** Accidentally deleted notes move to the trash with instant restoration or permanent deletion.
- **User Scoped Security:** Policy-enforced boundaries ensuring users only access their personal notes.
- **Authentication:** Built with Laravel Breeze, complete with password management and session security.

## Tech Stack

- **Framework:** Laravel 13.38.0
- **Auth:** Laravel Breeze 2.4
- **Database:** SQLite (default) / MySQL / PostgreSQL
- **Frontend:** Blade, Tailwind CSS

## Installation

```bash
git clone https://github.com/0xyz-exe/notes-app-laravel.git
cd notes-app-laravel
composer install
npm install
npm run build
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
```

## Database Schema

**notes table:**
- `id` (bigint, primary key)
- `user_id` (foreign key to users)
- `title` (string)
- `content` (text)
- `category` (string, nullable)
- `tags` (json array, nullable)
- `is_pinned` (boolean, default false)
- `is_archived` (boolean, default false)
- `deleted_at` (soft delete timestamp)
- `created_at`, `updated_at` (timestamps)

## License

MIT License.
