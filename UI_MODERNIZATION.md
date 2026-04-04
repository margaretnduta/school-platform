# Modern UI System Documentation

## Overview
This document outlines the modern UI system implemented across the School Platform project, including design tokens, component library, and best practices for maintaining consistency and responsiveness.

## Design Tokens

### Colors
The project uses a custom color system with primary, secondary, success, warning, and danger colors:

- **Primary (Sky Blue)**: Used for main actions, links, and focus states
- **Secondary (Coral)**: Used for secondary actions and highlights
- **Success (Green)**: Used for success messages and positive indicators
- **Warning (Amber)**: Used for warnings and cautions
- **Danger (Red)**: Used for destructive actions and errors

Each color has 9 shades (50-900) for various UI contexts:
```css
primary-50/100/200/.../900
secondary-50/100/200/.../900
/* etc. */
```

### Typography
- **Font**: Figtree (modern, readable)
- **Font Sizes**: Use Tailwind's default scale (xs, sm, base, lg, xl, 2xl, etc.)
- **Font Weights**: Regular (400), Medium (500), Semibold (600), Bold (700)

### Spacing
Standard spacing scale: 4px, 8px, 12px, 16px, 20px, 24px, 32px, 40px, 48px, etc.

### Border Radius
- **Small**: `rounded-lg` (8px)
- **Medium**: `rounded-xl` (12px)
- **Large**: `rounded-2xl` (16px)

### Shadows
- **sm**: Subtle shadow for low elevation
- **base**: Standard shadow for cards and containers
- **md/lg/xl**: Increasing shadows for modals and overlays
- **xl-hover**: Enhanced shadow for hover states

### Animations
- **fade-in**: 200ms fade-in animation
- **slide-up**: 300ms slide-up with fade animation

## Component Library

### Buttons
Use the `.btn` utility classes for consistent button styling:

```blade
<x-primary-button>Save</x-primary-button>
<x-secondary-button>Cancel</x-secondary-button>
<x-danger-button>Delete</x-danger-button>
```

**Button Variants:**
- `btn-primary`: Gradient blue button for primary actions
- `btn-primary-outline`: Outlined primary button
- `btn-secondary`: Gradient coral button
- `btn-success`: Gradient green button
- `btn-danger`: Gradient red button
- `btn-warning`: Gradient amber button
- `btn-gray`: Gray background button
- `btn-white`: White button with border

**Button Sizes:**
- `btn-sm`: Small button (12px text, 6px-12px padding)
- `btn`: Default button (14px text, 10px-16px padding)
- `btn-lg`: Large button (16px text, 12px-24px padding)
- `btn-icon`: Icon button (square, centered content)

### Forms

**Text Input:**
```blade
<x-input-label for="name" value="Full Name" />
<x-text-input id="name" type="text" name="name" />
<x-input-error :messages="$errors->get('name')" class="mt-1" />
```

**Select/Dropdown:**
```blade
<select class="select">
    <option>Option 1</option>
</select>
```

**Textarea:**
```blade
<textarea class="textarea" placeholder="Enter text..."></textarea>
```

### Cards

**Basic Card:**
```blade
<x-card>
    <x-card-body>
        Content here
    </x-card-body>
</x-card>
```

**Card with Header and Footer:**
```blade
<x-card>
    <x-card-header>
        <h3>Title</h3>
        <a href="#">Action</a>
    </x-card-header>
    <x-card-body>
        Content here
    </x-card-body>
    <x-card-footer>
        <x-primary-button>Save</x-primary-button>
    </x-card-footer>
</x-card>
```

**Compact Card:**
```blade
<x-card compact>
    Content here
</x-card>
```

### Badges

```blade
<x-badge variant="primary">New</x-badge>
<x-badge variant="success">Complete</x-badge>
<x-badge variant="warning">Pending</x-badge>
<x-badge variant="danger">Error</x-badge>
<x-badge variant="gray">Inactive</x-badge>
```

### Alerts

```blade
<x-alert variant="success" dismissible>
    <strong>Success!</strong> Your changes have been saved.
</x-alert>

<x-alert variant="danger">
    <strong>Error!</strong> Something went wrong.
</x-alert>
```

### Modals

```blade
<x-modal name="confirm-deletion" :show="$errors->any()">
    <x-card>
        <x-card-header>Confirm Deletion</x-card-header>
        <x-card-body>
            Are you sure you want to delete this item?
        </x-card-body>
        <x-card-footer>
            <x-secondary-button @click="show = false">Cancel</x-secondary-button>
            <x-danger-button>Delete</x-danger-button>
        </x-card-footer>
    </x-card>
</x-modal>
```

## Layout System

### Container
Use `.container-fluid` for consistent max-width and horizontal padding:
```blade
<div class="container-fluid">
    <!-- Content with max-width-7xl and responsive padding -->
</div>
```

### Responsive Grid
Use Tailwind's grid system for layouts:
```blade
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Grid items -->
</div>
```

### App Layout
```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-heading">Page Title</h2>
    </x-slot>
    
    <div class="container-fluid">
        <!-- Page content -->
    </div>
</x-app-layout>
```

## Usage Examples

### Dashboard Stats Card
```blade
<x-card>
    <x-card-body>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Total Users</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">250</p>
            </div>
            <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor">...</svg>
            </div>
        </div>
    </x-card-body>
</x-card>
```

### Data Table
```blade
<x-card>
    <x-card-body>
        <table class="table">
            <thead class="table-head">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody class="table-body">
                <tr>
                    <td>John Doe</td>
                    <td>john@example.com</td>
                    <td><x-badge variant="success">Active</x-badge></td>
                </tr>
            </tbody>
        </table>
    </x-card-body>
</x-card>
```

### Form Card
```blade
<x-card>
    <x-card-header>
        <h3 class="text-lg font-semibold text-gray-900">Edit Profile</h3>
    </x-card-header>
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        <x-card-body class="space-y-6">
            <div>
                <x-input-label for="name" value="Full Name" />
                <x-text-input id="name" type="text" name="name" value="{{ old('name') }}" />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>
        </x-card-body>
        <x-card-footer>
            <x-primary-button>Save Changes</x-primary-button>
        </x-card-footer>
    </form>
</x-card>
```

## Responsive Design

### Breakpoints
The project uses Tailwind's standard breakpoints:
- `sm`: 640px
- `md`: 768px
- `lg`: 1024px
- `xl`: 1280px
- `2xl`: 1536px

### Mobile-First Approach
Always design for mobile first, then add responsive classes:
```blade
<!-- Mobile: 1 column, Tablet: 2 columns, Desktop: 3 columns -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
```

### Navigation on Mobile
The navigation component automatically adapts to mobile with a hamburger menu.

## Best Practices

1. **Consistency**: Always use `.btn`, `.input`, `.card` utilities instead of custom styles
2. **Color Semantics**: Use appropriate colors for their meaning (green for success, red for danger, etc.)
3. **Spacing**: Use consistent gap and padding values from the spacing scale
4. **Typography**: Use heading levels appropriately (h1, h2, h3, etc.)
5. **Accessibility**: Ensure sufficient color contrast and include proper ARIA labels
6. **Responsiveness**: Test all views on mobile, tablet, and desktop
7. **Performance**: Minimize inline styles; use Tailwind classes
8. **Reusability**: Create components for repeated patterns

## Maintenance

### Adding New Components
1. Create the component in `resources/views/components/`
2. Follow the naming convention (hyphenated)
3. Use existing color and spacing tokens
4. Add documentation to this file

### Updating Colors
To change the color scheme, modify the color palette in `tailwind.config.js`:
```javascript
colors: {
    primary: {...},
    secondary: {...},
}
```

## Migration Guide

If you're updating existing views:
1. Replace old button classes with `btn` utilities
2. Replace old form input classes with `input` utilities
3. Wrap content in `.card` and `.card-body` for consistency
4. Update navigation links to use `x-nav-link` component
5. Use `.container-fluid` for page containers
6. Replace old color references (blue, red) with primary, secondary, success, danger
