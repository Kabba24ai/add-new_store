# Laravel Store Management System

A comprehensive store management system built with Laravel, following modern design principles and best practices for rental and e-commerce applications.

## Features

### Core Functionality
- **Complete Store Management**: Add, edit, view, and delete store locations
- **Advanced Form Validation**: Real-time validation with comprehensive error handling
- **Store Classification**: Primary/Alternate store designation system
- **Status Management**: Active/Inactive store status with toggle functionality
- **Search & Filtering**: Advanced filtering by name, location, status, and designation

### Technical Features
- **Modern Laravel Architecture**: Following MVC pattern with proper separation of concerns
- **Service Layer**: Business logic abstracted into dedicated service classes
- **Form Requests**: Comprehensive validation with custom error messages
- **Database Migrations**: Proper schema design with indexes for performance
- **Factory & Seeders**: Sample data generation for testing and development
- **Responsive Design**: Mobile-first approach with Tailwind CSS

### UI/UX Features
- **Professional Design**: Clean, modern interface with consistent styling
- **Interactive Elements**: Smooth animations, hover effects, and micro-interactions
- **Real-time Feedback**: Instant validation feedback and success/error notifications
- **Accessibility**: Proper ARIA labels, keyboard navigation, and screen reader support
- **Progressive Enhancement**: Works without JavaScript, enhanced with it

## Tech Stack

- **Backend**: Laravel 10.x (PHP 8.1+)
- **Frontend**: Blade Templates with Alpine.js
- **Styling**: Tailwind CSS 3.x
- **Database**: MySQL/PostgreSQL/SQLite
- **Build Tools**: Vite
- **Icons**: Heroicons (SVG)

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js 16+ and npm
- MySQL/PostgreSQL/SQLite

### Setup Instructions

1. **Clone the repository**
```bash
git clone <repository-url>
cd store-management
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install Node.js dependencies**
```bash
npm install
```

4. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Database configuration**
Update your `.env` file with database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=store_management
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. **Run migrations and seeders**
```bash
php artisan migrate --seed
```

7. **Build assets**
```bash
npm run build
# or for development
npm run dev
```

8. **Start the development server**
```bash
php artisan serve
```

Visit `http://localhost:8000` to access the application.

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── StoreController.php      # Main store controller
│   └── Requests/
│       └── StoreRequest.php         # Form validation
├── Models/
│   └── Store.php                    # Store model with relationships
└── Services/
    └── StoreService.php             # Business logic layer

database/
├── factories/
│   └── StoreFactory.php             # Test data generation
├── migrations/
│   └── create_stores_table.php      # Database schema
└── seeders/
    └── StoreSeeder.php              # Sample data

resources/
├── css/
│   └── app.css                      # Tailwind CSS with custom styles
├── js/
│   ├── app.js                       # Main JavaScript functionality
│   └── bootstrap.js                 # Axios and CSRF setup
└── views/
    ├── layouts/
    │   └── app.blade.php            # Main layout template
    └── stores/
        ├── index.blade.php          # Store listing page
        ├── create.blade.php         # Add new store form
        ├── edit.blade.php           # Edit store form
        └── show.blade.php           # Store details page
```

## Database Schema

### Stores Table
- `id` - Primary key
- `store_name` - Store name (required)
- `phone` - Phone number (unique, formatted)
- `email` - Email address (unique)
- `address` - Street address
- `city` - City name
- `state` - 2-letter state code
- `zip` - ZIP code (5 or 5+4 format)
- `designation` - 'primary' or 'alternate'
- `is_active` - Boolean status
- `created_at` / `updated_at` - Timestamps
- `deleted_at` - Soft delete timestamp

## API Endpoints

| Method | URI | Action | Description |
|--------|-----|--------|-------------|
| GET | `/stores` | index | List all stores with filtering |
| GET | `/stores/create` | create | Show create form |
| POST | `/stores` | store | Create new store |
| GET | `/stores/{store}` | show | Show store details |
| GET | `/stores/{store}/edit` | edit | Show edit form |
| PUT/PATCH | `/stores/{store}` | update | Update store |
| DELETE | `/stores/{store}` | destroy | Delete store |
| PATCH | `/stores/{store}/toggle-status` | toggleStatus | Toggle active status |

## Form Validation Rules

### Store Creation/Update
- **Store Name**: Required, max 255 characters
- **Phone**: Required, format (555) 123-4567, unique
- **Email**: Required, valid email format, unique
- **Address**: Required, max 500 characters
- **City**: Required, max 100 characters
- **State**: Required, valid 2-letter US state code
- **ZIP**: Required, format 12345 or 12345-6789
- **Designation**: Required, 'primary' or 'alternate'
- **Status**: Boolean, defaults to active

## Features in Detail

### Search & Filtering
- **Text Search**: Search by store name, city, or state
- **Status Filter**: Filter by active/inactive status
- **Designation Filter**: Filter by primary/alternate designation
- **Pagination**: 10 stores per page with navigation

### Form Enhancements
- **Real-time Validation**: Instant feedback on field blur
- **Phone Formatting**: Auto-formats phone numbers as user types
- **Error Handling**: Comprehensive error messages with icons
- **Success Notifications**: Auto-dismissing success messages

### Responsive Design
- **Mobile-First**: Optimized for mobile devices
- **Tablet Support**: Proper layout for tablet screens
- **Desktop Enhancement**: Full-featured desktop experience
- **Touch-Friendly**: Large touch targets for mobile users

## Customization

### Styling
The application uses Tailwind CSS with custom components defined in `resources/css/app.css`. Key customizable elements:

- **Colors**: Modify the color palette in `tailwind.config.js`
- **Typography**: Update font families and sizes
- **Components**: Custom button, card, and badge styles
- **Animations**: Fade-in and slide-in animations

### Validation
Extend validation rules in `app/Http/Requests/StoreRequest.php`:

```php
public function rules(): array
{
    return [
        'custom_field' => ['required', 'string', 'max:255'],
        // Add more validation rules
    ];
}
```

### Business Logic
Add custom business logic in `app/Services/StoreService.php`:

```php
public function customMethod(): Collection
{
    // Custom business logic here
    return Store::where('custom_condition', true)->get();
}
```

## Testing

### Factory Usage
```php
// Create test stores
Store::factory()->count(10)->create();

// Create specific store types
Store::factory()->primary()->active()->create();
Store::factory()->alternate()->inactive()->create();
```

### Sample Data
Run the seeder to populate with sample data:
```bash
php artisan db:seed --class=StoreSeeder
```

## Performance Considerations

### Database Optimization
- Indexes on frequently queried columns
- Soft deletes for data integrity
- Proper foreign key relationships

### Frontend Optimization
- Vite for fast asset compilation
- Lazy loading for large datasets
- Optimized images and icons

### Caching
Consider implementing caching for:
- Store listings
- State dropdown data
- Search results

## Security Features

- **CSRF Protection**: All forms include CSRF tokens
- **Input Validation**: Comprehensive server-side validation
- **SQL Injection Prevention**: Eloquent ORM protection
- **XSS Prevention**: Blade template escaping

## Browser Support

- **Modern Browsers**: Chrome 90+, Firefox 88+, Safari 14+, Edge 90+
- **Mobile Browsers**: iOS Safari 14+, Chrome Mobile 90+
- **Progressive Enhancement**: Basic functionality without JavaScript

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support and questions:
- Create an issue in the repository
- Check the documentation
- Review the code comments for implementation details