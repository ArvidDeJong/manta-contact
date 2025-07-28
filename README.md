# Manta Contact Form Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/darvis/manta-contact.svg?style=flat-square)](https://packagist.org/packages/darvis/manta-contact)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

A Laravel package for managing contact forms and submissions. This module integrates seamlessly with the **darvis/manta-laravel-flux-cms** system and provides a complete solution for contact form management.

## Features

- 📝 **Contact Form Management**: Full CRUD functionality for contact forms
- 📨 **Submissions**: Comprehensive system for managing contact form submissions
- 🌍 **Multilingual**: Support for multiple languages via Manta CMS
- 📁 **File Management**: Integrated upload functionality for attachments
- 🔒 **Security**: Staff middleware for access control
- ⚡ **Livewire v3**: Modern, reactive user interface
- 🎨 **FluxUI**: Beautiful, consistent UI components
- 🗄️ **Database**: Soft deletes and audit trails
- 📧 **Email Integration**: Automatic email notifications

## Requirements

- PHP ^8.2
- Laravel ^12.0
- darvis/manta-laravel-flux-cms

## Installation

### 1. Install Package

```bash
composer require darvis/manta-contact
```

### 2. Automatic Installation (Recommended)

The easiest way to install the module is via the built-in install command:

```bash
php artisan manta-contact:install
```

This command does the following:

- Publishes the configuration files
- Publishes the database migrations
- Asks if migrations should be run immediately
- Shows installation instructions and next steps

### 3. Manual Installation (Alternative)

If you want to perform the installation step by step:

```bash
# Publish configuration file
php artisan vendor:publish --tag=manta-contact-config

# Publish database migrations
php artisan vendor:publish --tag=manta-contact-migrations
```

### 4. Run Database Migrations

```bash
php artisan migrate
```

## Configuration

After publishing the configuration, you'll find the file at `config/manta-contact.php`:

```php
return [
    // Route prefix for the contact module
    'route_prefix' => 'cms/contact',

    // Database settings
    'database' => [
        'table_name' => 'manta_contacts',
    ],

    // Email settings
    'email' => [
        'from' => [
            'address' => env('MAIL_FROM_ADDRESS', 'noreply@example.com'),
            'name' => env('MAIL_FROM_NAME', 'Manta Contact'),
        ],
        'enabled' => true,
        'default_subject' => 'New contact form message',
        'default_receivers' => env('MAIL_TO_ADDRESS', 'admin@example.com'),
    ],

    // UI settings
    'ui' => [
        'items_per_page' => 25,
        'show_breadcrumbs' => true,
    ],
];
```

## Usage

### Managing Contact Forms

The module provides full CRUD functionality for contact forms via the Manta CMS:

- **List**: Overview of all contact forms
- **Create**: Add new contact form
- **Edit**: Modify existing contact form
- **View**: View contact form details
- **Files**: Upload and manage attachments
- **Settings**: Module-specific configuration

### Managing Submissions

The same applies to contact form submissions:

- Complete contact details from visitors
- Form-specific information
- File management for attachments
- IP tracking for security
- Automatic email notifications

### Programmatic Usage

```php
use Darvis\Mantacontact\Models\contact;
use Darvis\Mantacontact\Models\contactSubmission;

// Create new contact form
$contactForm = contact::create([
    'title' => 'General Contact Form',
    'subtitle' => 'Get in touch with us',
    'content' => 'Please fill out the form below...',
    'data' => ['required_fields' => ['name', 'email', 'message']]
]);

// Add submission
$submission = contactSubmission::create([
    'firstname' => 'John',
    'lastname' => 'Doe',
    'email' => 'john@example.com',
    'subject' => 'General Inquiry',
    'comment' => 'I would like more information about...'
]);
```

### Frontend Integration

For frontend contact forms, you can use the submission model directly:

```php
// In your controller
use Darvis\Mantacontact\Models\contactSubmission;

public function store(Request $request)
{
    $validated = $request->validate([
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'email' => 'required|email',
        'subject' => 'required|string|max:255',
        'comment' => 'required|string',
    ]);

    contactSubmission::create($validated);

    return response()->json(['message' => 'Message sent successfully']);
}
```

## Database Schema

### contacts Table

| Field        | Type      | Description        |
| ------------ | --------- | ------------------ |
| `id`         | bigint    | Primary key        |
| `title`      | string    | Contact form title |
| `subtitle`   | string    | Subtitle           |
| `content`    | text      | Form description   |
| `year`       | integer   | Year (optional)    |
| `data`       | json      | Form configuration |
| `created_at` | timestamp | Creation date      |
| `updated_at` | timestamp | Last modification  |
| `deleted_at` | timestamp | Soft delete        |

### contactsubmissions Table

| Field        | Type      | Description          |
| ------------ | --------- | -------------------- |
| `id`         | bigint    | Primary key          |
| `firstname`  | string    | First name           |
| `lastname`   | string    | Last name            |
| `email`      | string    | Email address        |
| `phone`      | string    | Phone number         |
| `company`    | string    | Company/organization |
| `subject`    | string    | Message subject      |
| `comment`    | text      | Message content      |
| `data`       | json      | Extra data           |
| `created_at` | timestamp | Submission date      |

## Routes

The module automatically registers the following routes (with staff middleware):

### Contact Form Management Routes

- `GET /contact` - Contact forms overview
- `GET /contact/create` - Create new contact form
- `GET /contact/{id}` - View contact form details
- `GET /contact/{id}/edit` - Edit contact form
- `GET /contact/{id}/files` - File management
- `GET /contact/settings` - Module settings

### Submission Management Routes

- `GET /contactsubmission` - Submissions overview
- `GET /contactsubmission/create` - Create new submission
- `GET /contactsubmission/{id}` - View submission details
- `GET /contactsubmission/{id}/edit` - Edit submission
- `GET /contactsubmission/{id}/files` - File management
- `GET /contactsubmission/settings` - Submission settings

## Integration with Manta CMS

This module is specifically designed for integration with the Manta Laravel Flux CMS:

- **Livewire v3**: All UI components are Livewire components
- **FluxUI**: Consistent design with the CMS
- **Manta Traits**: Reuse of CMS functionality
- **Multi-tenancy**: Support for multiple companies
- **Audit Trail**: Complete logging of changes
- **Soft Deletes**: Safe data deletion

## Development

### Testing

```bash
composer test
```

### Code Style

```bash
composer format
```

## Troubleshooting

### Common Issues

#### Package Not Found

If you get a "Package not found" error:

```bash
composer clear-cache
composer install
```

#### Migrations Not Running

If migrations fail to run:

```bash
php artisan migrate:status
php artisan migrate --force
```

#### Routes Not Working

If routes are not accessible:

1. Check if you're logged in as staff user
2. Verify middleware configuration
3. Clear route cache: `php artisan route:clear`

#### Configuration Not Loading

If configuration changes aren't applied:

```bash
php artisan config:clear
php artisan config:cache
```

### Debug Mode

Enable debug mode in your `.env` file for detailed error messages:

```env
APP_DEBUG=true
LOG_LEVEL=debug
```

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for an overview of changes.

## Contributing

Contributions are welcome! See [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

## Security

If you discover a security issue, please send an email to info@arvid.nl.

## Credits

- [Darvis](https://github.com/darvis)
- [All contributors](../../contributors)

## License

The MIT License (MIT). See [License File](LICENSE.md) for more information.

## Support

For support and questions:

- 📧 Email: info@arvid.nl
- 🌐 Website: [arvid.nl](https://arvid.nl)
- 📖 Documentation: See `project.md` for comprehensive technical documentation
