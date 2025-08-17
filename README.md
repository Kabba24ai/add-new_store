# Store Management System

A modern, responsive store management interface built with React, TypeScript, and Tailwind CSS for rental and e-commerce applications.

## Features

- **Complete Store Management**: Add and edit store locations with comprehensive form validation
- **Modern UI/UX**: Clean, professional interface with smooth animations and hover effects
- **Responsive Design**: Optimized for all devices from mobile to desktop
- **Form Validation**: Real-time validation with helpful error messages
- **State Management**: Pre-populated US states dropdown
- **Store Designation**: Primary/Alternate store classification
- **Status Toggle**: Active/Inactive store status management

## Tech Stack

- **React 18** - Modern React with hooks
- **TypeScript** - Type-safe development
- **Tailwind CSS** - Utility-first CSS framework
- **Vite** - Fast build tool and dev server
- **Lucide React** - Beautiful, customizable icons

## Getting Started

### Prerequisites

- Node.js (version 16 or higher)
- npm or yarn

### Installation

1. Clone the repository:
```bash
git clone <your-repo-url>
cd store-management
```

2. Install dependencies:
```bash
npm install
```

3. Start the development server:
```bash
npm run dev
```

4. Open your browser and navigate to `http://localhost:5173`

## Available Scripts

- `npm run dev` - Start development server
- `npm run build` - Build for production
- `npm run preview` - Preview production build
- `npm run lint` - Run ESLint

## Project Structure

```
src/
├── components/
│   └── StoreForm.tsx      # Main store form component
├── constants/
│   └── states.ts          # US states data
├── App.tsx                # Main application component
├── main.tsx              # Application entry point
└── index.css             # Global styles and Tailwind imports
```

## Form Fields

- **Store Name** - Required text field
- **Phone** - Formatted phone number (XXX) XXX-XXXX
- **Email** - Validated email address
- **Address** - Street address
- **City** - City name
- **State** - Dropdown with all US states
- **ZIP Code** - 5-digit or 5+4 format
- **Designation** - Primary or Alternate store
- **Status** - Active/Inactive toggle

## Validation

The form includes comprehensive validation:
- Required field validation
- Email format validation
- Phone number format validation
- ZIP code format validation
- Real-time error feedback

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.