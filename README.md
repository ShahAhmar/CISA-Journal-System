# EMANP - Excellence in Management & Academic Network Publishing

A complete multi-journal publishing system built with Laravel, similar to OJS (Open Journal Systems) but built from scratch. This system allows you to manage multiple journals, each with its own editorial team, submission workflow, and publishing capabilities.

## Features

### Core Features

- **Multi-Journal System**: Create and manage unlimited journals, each with its own:
  - Homepage
  - Editorial board
  - Aims & scope
  - Current & archived issues
  - Submission guidelines
  - Contact page

- **Complete Roles & Permissions System**:
  - Journal Manager - Full control over a journal
  - Editor - Manage articles & reviewers
  - Section Editor - Handle specific sections
  - Reviewer - Review submissions
  - Author - Submit articles
  - Copyeditor - Handle copyediting stage
  - Proofreader - Handle proofreading
  - Sub-Editor - Limited editorial roles
  - Admin - Global access to all journals

- **Full Editorial Workflow**:
  - Submission
  - Initial Screening (Editor)
  - Reviewer Assignment
  - Review Feedback
  - Revisions (Author uploads new files)
  - Copyediting Stage
  - Typesetting / Proofreading
  - Issue Publishing

- **Article & Issue Publishing**:
  - Issues (Volume / Issue Number / Year)
  - Articles with metadata (Title, abstract, PDF, keywords, DOI, Authors info, References)

- **DOI & ISSN Management**:
  - ISSN per journal
  - DOI Prefix per journal
  - Metadata structure ready for indexing platforms

- **Payment Integration** (Optional):
  - APC (Article Processing Charges)
  - Submission fees
  - PayPal & Stripe support

- **Fully Customizable Frontend**:
  - Modern, responsive design with Tailwind CSS
  - Journal-specific layouts
  - Drag-and-drop editable UI (future enhancement)

## Requirements

- PHP >= 8.1
- MySQL >= 5.7 or MariaDB >= 10.3
- Composer
- Node.js & NPM

## Installation

1. **Clone or navigate to the project directory**

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install Node dependencies:**
   ```bash
   npm install
   ```

4. **Copy environment file:**
   ```bash
   cp .env.example .env
   ```

5. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

6. **Configure your database in `.env`:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=journal_system
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

7. **Run migrations:**
   ```bash
   php artisan migrate
   ```

8. **Seed database (creates admin user):**
   ```bash
   php artisan db:seed
   ```

9. **Create storage link:**
   ```bash
   php artisan storage:link
   ```

10. **Build assets:**
    ```bash
    npm run build
    ```

11. **Start development server:**
    ```bash
    php artisan serve
    ```

## Default Admin Credentials

- Email: `admin@journal.com`
- Password: `password`

**Important:** Change these credentials immediately after first login!

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Admin controllers
│   │   ├── Author/         # Author controllers
│   │   ├── Editor/         # Editor controllers
│   │   └── Reviewer/      # Reviewer controllers
│   └── Middleware/         # Custom middleware
├── Models/                  # Eloquent models
database/
├── migrations/             # Database migrations
└── seeders/                # Database seeders
resources/
├── views/                  # Blade templates
│   ├── admin/             # Admin views
│   ├── author/             # Author views
│   ├── editor/             # Editor views
│   └── journals/           # Journal frontend views
├── css/                    # Tailwind CSS
└── js/                     # JavaScript files
routes/
└── web.php                 # Web routes
```

## Usage

### Creating a Journal

1. Login as admin
2. Navigate to Admin Dashboard
3. Click "Create New Journal"
4. Fill in journal details
5. Save

### Assigning Roles

1. Go to journal management
2. Edit the journal
3. Assign users to roles (Journal Manager, Editor, etc.)

### Submitting an Article

1. Browse journals
2. Select a journal
3. Click "Submit Article"
4. Fill in article details
5. Upload manuscript
6. Submit

### Editorial Workflow

1. Editor reviews submission
2. Assigns reviewers
3. Reviewers submit feedback
4. Editor makes decision
5. Author revises if needed
6. Copyediting & proofreading
7. Publish to issue

## Development

### Running in Development Mode

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server (for hot reloading)
npm run dev
```

### Building for Production

```bash
npm run build
```

## Technologies Used

- **Backend**: Laravel 10
- **Frontend**: Blade Templates with Tailwind CSS
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **File Storage**: Local filesystem (configurable for S3)

## License

This project is open-sourced software licensed under the MIT license.

## Support

For issues and questions, please create an issue in the repository.

