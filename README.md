# Y-Track: Financial Management Application
![Y-Track Logo](./frontend/public/images/Y-TRACK_dark.svg)

## Project Overview
The main interface of Y-Track provides a clear overview through dynamic statistics and visualizations. It provides customized dashboards and improved financial management, ensuring tax compliance and efficiency of recurring tasks.

## Key Features

### Financial Tracking
- Comprehensive income tracking with source categorization
- Detailed expense management with frequency tracking
- Bill management with upcoming payments tracking
- Transaction history with pagination and filtering
- Status tracking for all financial activities

### User Interface
- Modern, responsive design with Tailwind CSS
- Interactive dashboards with dynamic statistics
- Advanced filtering and sorting capabilities
- Pagination with smart page number display
- Intuitive table components for data management

### Technical Architecture

#### Frontend
- **Framework**: Vue 3 with Composition API
- **Build Tool**: Vite
- **Styling**: Tailwind CSS
- **Icons**: Oh-Vue-Icons
- **Routing**: Vue Router
- **State Management**: pinia
- **Sweet alerts**: SweetAlert2 for modal alerts and Notyf for toast notifications


#### Backend
- **Framework**: Laravel 10
- RESTful API architecture
- Secure authentication system with sunctom
- Database integration with postgresql
- PDF generation for invoices
- Job queue for automatic transaction processing

## Development Setup

### Prerequisites
- Node.js (v14 or higher)
- npm or yarn

### Installation
1. Clone the repository
2. Install dependencies:
   ```bash
   npm install
   ```
3. Run development server:
   ```bash
   npm run dev
   ```

### Job Queue Setup
To enable automatic transaction creation, start the job queue listener:
```bash
php artisan queue:listen
```
This command will process all queued jobs, including automatic transaction creation based on scheduled payments and recurring transactions.


## Project Structure
```
Y-track/
├── backend/           # Backend API and server code
├── frontend/          # Frontend Vue application
├── UML/               # System architecture diagrams
├── cahier_de_charge/  # Project specifications
├── figma/            # Design files
└── presentation/     # Project presentation materials
```

## Contributing Guidelines
1. Follow Vue 3 best practices
2. Use meaningful commit messages
3. Maintain consistent code style
4. Write clear documentation for new features
5. Test thoroughly before committing changes

## Technical Features

### UI Components
- Responsive tables with pagination
- Advanced filtering and sorting
- Interactive forms with validation
- Custom icons and visual feedback
- Modern color scheme with orange accents

### Data Management
- Real-time updates
- Efficient data pagination
- Smart filtering system
- Status tracking
- Export capabilities
## Contact
[elbarry.anouar.contact@gmail.com]
