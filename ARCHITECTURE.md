# System Architecture Documentation

## Overview

This Hospital Management System follows **Clean Architecture** principles with a layered architecture pattern. The system is designed to be maintainable, scalable, and follows SOLID principles.

## Architecture Layers

### 1. Presentation Layer (Controllers)
**Location:** `app/Http/Controllers/`

**Responsibility:**
- Handle HTTP requests and responses
- Validate input using Form Requests
- Delegate business logic to Services
- Return views or JSON responses

**Key Controllers:**
- `AdminController` - Admin dashboard
- `DoctorController` - Doctor management
- `PatientController` - Patient management
- `AppointmentController` - Appointment handling
- `BillingController` - Billing operations
- `MedicalRecordController` - Medical records

**Principles:**
- Thin controllers (no business logic)
- Single Responsibility Principle
- Dependency Injection

### 2. Application Layer (Services)
**Location:** `app/Services/`

**Responsibility:**
- Implement business logic
- Coordinate between repositories
- Handle transactions
- Business rule validation

**Key Services:**
- `DoctorService` - Doctor business logic
- `PatientService` - Patient business logic
- `AppointmentService` - Appointment business logic
- `BillService` - Billing business logic
- `MedicalRecordService` - Medical record logic

**Principles:**
- Business logic encapsulation
- Transaction management
- Error handling

### 3. Domain Layer (Repositories)
**Location:** `app/Repositories/`

**Structure:**
```
Repositories/
├── Interfaces/          # Contract definitions
└── Implementations/     # Concrete implementations
```

**Responsibility:**
- Data access abstraction
- Database queries
- CRUD operations
- Query filtering and pagination

**Key Repositories:**
- `DoctorRepository` - Doctor data access
- `PatientRepository` - Patient data access
- `AppointmentRepository` - Appointment data access
- `BillRepository` - Billing data access

**Principles:**
- Repository Pattern
- Interface Segregation
- Dependency Inversion

### 4. Data Layer (Models)
**Location:** `app/Models/`

**Responsibility:**
- Eloquent ORM models
- Define relationships
- Model attributes and casts
- Soft deletes

**Key Models:**
- `User` - User accounts
- `Doctor` - Doctor profiles
- `Patient` - Patient profiles
- `Appointment` - Appointments
- `Bill` - Billing records
- `MedicalRecord` - Medical records

**Principles:**
- Active Record Pattern
- Relationship definitions
- Attribute casting

## Request Flow

```
HTTP Request
    ↓
Route (routes/web.php)
    ↓
Middleware (Authentication, Authorization)
    ↓
Controller (app/Http/Controllers/)
    ↓
Form Request Validation (app/Http/Requests/)
    ↓
Service (app/Services/)
    ↓
Repository Interface (app/Repositories/Interfaces/)
    ↓
Repository Implementation (app/Repositories/Implementations/)
    ↓
Model (app/Models/)
    ↓
Database
```

## Dependency Injection

### Service Provider
**Location:** `app/Providers/RepositoryServiceProvider.php`

Binds repository interfaces to implementations:
```php
$this->app->bind(DoctorRepositoryInterface::class, DoctorRepository::class);
```

### Controller Injection
```php
public function __construct(
    private DoctorService $doctorService
) {}
```

## Security Architecture

### Authentication
- Laravel's built-in authentication
- Password hashing with bcrypt
- Session-based authentication

### Authorization
- Role-based middleware (`RoleMiddleware`)
- Form Request authorization
- Route protection

### Middleware Stack
1. `auth` - Authentication check
2. `role:admin,doctor` - Role-based access

## Database Architecture

### Relationships

**User → Doctor** (One-to-One)
- One user can have one doctor profile

**User → Patient** (One-to-One)
- One user can have one patient profile

**Department → Doctor** (One-to-Many)
- One department has many doctors

**Doctor → Appointment** (One-to-Many)
- One doctor has many appointments

**Patient → Appointment** (One-to-Many)
- One patient has many appointments

**Patient → MedicalRecord** (One-to-Many)
- One patient has many medical records

**Patient → Bill** (One-to-Many)
- One patient has many bills

**Bill → BillItem** (One-to-Many)
- One bill has many items

## Design Patterns Used

1. **Repository Pattern**
   - Abstracts data access layer
   - Makes code testable
   - Allows easy database switching

2. **Service Pattern**
   - Encapsulates business logic
   - Coordinates multiple repositories
   - Handles transactions

3. **Dependency Injection**
   - Loose coupling
   - Testability
   - Maintainability

4. **Form Request Pattern**
   - Validation logic separation
   - Authorization rules
   - Reusable validation

5. **Middleware Pattern**
   - Cross-cutting concerns
   - Authentication/Authorization
   - Request filtering

## Code Organization

### Naming Conventions
- **Controllers:** PascalCase, singular (e.g., `DoctorController`)
- **Services:** PascalCase, singular (e.g., `DoctorService`)
- **Repositories:** PascalCase, singular (e.g., `DoctorRepository`)
- **Models:** PascalCase, singular (e.g., `Doctor`)
- **Routes:** kebab-case (e.g., `admin.doctors.index`)

### File Structure
```
app/
├── Http/
│   ├── Controllers/        # Request handlers
│   ├── Middleware/         # Custom middleware
│   └── Requests/           # Form validation
├── Models/                 # Eloquent models
├── Repositories/
│   ├── Interfaces/        # Contracts
│   └── Implementations/   # Concrete classes
├── Services/              # Business logic
└── Providers/             # Service providers
```

## Testing Strategy

### Unit Tests
- Test individual services
- Test repository methods
- Mock dependencies

### Feature Tests
- Test HTTP endpoints
- Test authentication
- Test authorization

### Integration Tests
- Test database operations
- Test relationships
- Test transactions

## Scalability Considerations

1. **Database Indexing**
   - Indexed foreign keys
   - Indexed search columns
   - Composite indexes for queries

2. **Caching**
   - Query result caching
   - Configuration caching
   - Route caching

3. **Pagination**
   - All list views paginated
   - Configurable page size
   - Efficient queries

4. **Eager Loading**
   - Prevents N+1 queries
   - Loads relationships efficiently
   - Reduces database queries

## Best Practices Implemented

1. ✅ SOLID Principles
2. ✅ DRY (Don't Repeat Yourself)
3. ✅ Separation of Concerns
4. ✅ Single Responsibility
5. ✅ Dependency Inversion
6. ✅ Interface Segregation
7. ✅ Open/Closed Principle
8. ✅ Clean Code
9. ✅ Proper Error Handling
10. ✅ Security Best Practices

## Future Improvements

1. **CQRS Pattern** - Separate read/write models
2. **Event Sourcing** - Track all changes
3. **API Versioning** - Version API endpoints
4. **GraphQL** - Flexible data fetching
5. **Microservices** - Split into services
6. **Message Queue** - Async processing
7. **Caching Layer** - Redis/Memcached
8. **Search Engine** - Elasticsearch integration

