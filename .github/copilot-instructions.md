# CRM_L12 - AI Coding Instructions

This is a **Laravel 12** CRM system for managing client visits with role-based access control. The system tracks commercial users scheduling and managing client visits, with administrative oversight.

## Architecture Overview

### Core Domain Model
The CRM centers around **Visits** as the primary business entity:
- `User` (admin/commercial) → `Visit` → `Client`
- `Visit` can have multiple `Note` records
- `Client` can have multiple `Recommendation` records
- Role-based permissions control data access and operations

### Database Relationships
```
Role → User → Visit ← Client
              ↓        ↓
             Note  Recommendation
```

Key files: `app/Models/{User,Visit,Client,Role,Note,Recommendation}.php`

## Role-Based Authorization Pattern

**Two-tier system**: Admin users see/manage everything, Commercial users only their own visits.

### Implementation Pattern
1. **Role helpers in User model**: `isAdmin()`, `isCommercial()` methods using Role constants
2. **Controller authorization**: Mix of manual checks and Policy-based authorization
3. **Policy pattern**: `VisitPolicy` demonstrates the authorization approach for other resources

Example from `VisitController`:
```php
// Manual role check for data filtering
$visits = $user->isAdmin() 
    ? Visit::with('client', 'user')->get()
    : $user->visits()->with('client')->get();

// Policy-based authorization
$this->authorize('update', $visit);
```

### Role Constants
Defined in `Role::class`: `ADMIN = 'admin'`, `COMMERCIAL = 'commercial'`
Seeded with ID 1 (admin) and ID 2 (commercial) in `UserSeeder`

## Development Patterns

### Model Conventions
- **Relationships only** - no fillable arrays, business logic in controllers
- **Constants for role names** - use `Role::ADMIN` not magic strings
- **Scopes for common queries** - e.g., `Role::scopeByName()`

### Controller Patterns
- **Resource controllers** with standard Laravel patterns
- **Explicit validation** in each method, no Form Requests used
- **Manual authorization** combined with Policy methods
- **Eager loading** with relationships: `->with('client', 'user')`

### Migration Timestamps
All business entities use standard Laravel timestamps. Key fields:
- `visits.scheduled_at` (required) and `completed_at` (nullable)
- Foreign key constraints with cascade deletes

## Tech Stack

- **Backend**: Laravel 12, PHP 8.2+, MySQL
- **Frontend**: Laravel Breeze + Alpine.js + Tailwind CSS
- **Build**: Vite for asset compilation
- **Development**: Docker via Laravel Sail (`compose.yaml`)

## Development Workflow

### Setup Commands
```bash
# Using Laravel Sail (Docker)
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate:fresh --seed
./vendor/bin/sail npm run dev

# Or traditional LAMP stack
php artisan migrate:fresh --seed
npm run dev
```

### Test Users (from seeders)
- Admin: `admin@example.com` / `password`
- Commercial: `commercial@example.com` / `password`

### Key Artisan Commands
- Database: `php artisan migrate:fresh --seed` (resets with sample data)
- Assets: `npm run dev` (watch mode) or `npm run build` (production)
- Testing: `php artisan test`

## Project-Specific Conventions

### Model Patterns
- Role checking via methods (`isAdmin()`) not direct property access
- Relationships defined but no mass assignment protection implemented
- Business logic in controllers, models keep relationships only

### Frontend Integration
- Views follow Laravel Breeze component patterns (`resources/views/components/`)
- Alpine.js for interactive elements, Tailwind for styling
- Standard Blade templating with component-based UI

### Authorization Flow
1. Authentication via Laravel Breeze
2. Role-based filtering in controller index methods
3. Policy authorization for modify operations (create/update/delete)
4. Manual `$user->isAdmin()` checks for admin-only features

When extending this system, follow the established patterns: create Policies for new resources, use role helper methods for access control, and maintain the controller-heavy approach for business logic.