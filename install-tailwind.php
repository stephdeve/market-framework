<?php
/**
 * Market Framework - Install Tailwind CSS
 * 
 * Automatically installs and configures Tailwind CSS for your project
 * 
 * Usage: php install-tailwind.php
 */

$projectPath = __DIR__;

echo "Installing Tailwind CSS...\n";
echo "==========================\n\n";

// 1. Create package.json if it doesn't exist
$packageJson = [
    "name" => basename($projectPath),
    "version" => "1.0.0",
    "description" => "Market Framework Application with Tailwind CSS",
    "scripts" => [
        "dev" => "tailwindcss -i ./public/css/input.css -o ./public/css/output.css --watch",
        "build" => "tailwindcss -i ./public/css/input.css -o ./public/css/output.css --minify"
    ],
    "devDependencies" => [
        "tailwindcss" => "^3.4.0"
    ]
];

if (!file_exists($projectPath . '/package.json')) {
    file_put_contents(
        $projectPath . '/package.json',
        json_encode($packageJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
    );
    echo "✓ Created package.json\n";
} else {
    echo "✓ package.json already exists\n";
}

// 2. Create tailwind.config.js
$tailwindConfig = <<<'JS'
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./views/**/*.php",
    "./public/**/*.html",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#f5f3ff',
          100: '#ede9fe',
          200: '#ddd6fe',
          300: '#c4b5fd',
          400: '#a78bfa',
          500: '#8b5cf6',
          600: '#7c3aed',
          700: '#6d28d9',
          800: '#5b21b6',
          900: '#4c1d95',
        },
      },
    },
  },
  plugins: [],
}
JS;

file_put_contents($projectPath . '/tailwind.config.js', $tailwindConfig);
echo "✓ Created tailwind.config.js\n";

// 3. Create input CSS file with Tailwind directives
$inputCss = <<<'CSS'
/* Market Framework - Tailwind CSS Input */
@tailwind base;
@tailwind components;
@tailwind utilities;

/* Custom CSS can be added here */
@layer components {
  .btn {
    @apply px-4 py-2 rounded-lg font-semibold transition-all duration-200;
  }
  
  .btn-primary {
    @apply bg-gradient-to-r from-purple-600 to-indigo-600 text-white hover:from-purple-700 hover:to-indigo-700;
  }
  
  .btn-secondary {
    @apply bg-gray-200 text-gray-800 hover:bg-gray-300;
  }
  
  .card {
    @apply bg-white rounded-lg shadow-md p-6;
  }
  
  .input {
    @apply w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent;
  }
}

/* Your custom CSS alongside Tailwind */
CSS;

if (!file_exists($projectPath . '/public/css')) {
    mkdir($projectPath . '/public/css', 0777, true);
}

file_put_contents($projectPath . '/public/css/input.css', $inputCss);
echo "✓ Created public/css/input.css\n";

// 4. Create a .gitignore for node_modules
$gitignore = <<<'GITIGNORE'
node_modules/
public/css/output.css
package-lock.json
GITIGNORE;

if (file_exists($projectPath . '/.gitignore')) {
    $existing = file_get_contents($projectPath . '/.gitignore');
    if (strpos($existing, 'node_modules') === false) {
        file_put_contents($projectPath . '/.gitignore', $existing . "\n" . $gitignore);
    }
} else {
    file_put_contents($projectPath . '/.gitignore', $gitignore);
}
echo "✓ Updated .gitignore\n";

// 5. Create example view with Tailwind
$exampleView = <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind CSS Example</title>
    <!-- Tailwind CSS compiled output -->
    <link rel="stylesheet" href="/css/output.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="card max-w-md">
            <h1 class="text-3xl font-bold text-purple-600 mb-4">Tailwind CSS is Ready!</h1>
            <p class="text-gray-600 mb-6">
                Your Market Framework project now includes Tailwind CSS. 
                You can use Tailwind classes alongside your custom CSS.
            </p>
            
            <div class="space-y-3">
                <button class="btn btn-primary w-full">Primary Button</button>
                <button class="btn btn-secondary w-full">Secondary Button</button>
            </div>
            
            <div class="mt-6">
                <input type="text" placeholder="Example input" class="input">
            </div>
            
            <div class="mt-6 text-sm text-gray-500">
                <p>✓ Tailwind CSS configured</p>
                <p>✓ Custom components ready</p>
                <p>✓ Works with native CSS</p>
            </div>
        </div>
    </div>
</body>
</html>
HTML;

file_put_contents($projectPath . '/views/tailwind-example.php', $exampleView);
echo "✓ Created views/tailwind-example.php\n";

// 6. Create installation instructions
$instructions = <<<'README'
# Tailwind CSS Installation

Tailwind CSS has been configured for your Market Framework project!

## Installation Steps

### 1. Install Dependencies

Run this command to install Tailwind CSS:

```bash
npm install
```

If you don't have Node.js/npm installed:
- Download from: https://nodejs.org/
- Install Node.js (includes npm)
- Then run `npm install` in your project directory

### 2. Build Tailwind CSS

Choose one of these options:

**Option A - Watch Mode (Development):**
```bash
npm run dev
```
This watches for changes and rebuilds automatically.

**Option B - One-time Build:**
```bash
npm run build
```
This builds once and minifies the output.

### 3. Include in Your Views

Add this to your HTML `<head>`:
```html
<link rel="stylesheet" href="/css/output.css">
```

## Usage

### Using Tailwind Classes

```html
<div class="bg-blue-500 text-white p-4 rounded-lg">
    Hello Tailwind!
</div>
```

### Custom Components (Already Configured)

```html
<!-- Pre-configured button -->
<button class="btn btn-primary">Click Me</button>

<!-- Pre-configured card -->
<div class="card">
    <h2>Card Title</h2>
    <p>Card content</p>
</div>

<!-- Pre-configured input -->
<input type="text" class="input" placeholder="Enter text">
```

### Mixing with Native CSS

You can still use your custom CSS files alongside Tailwind:

```html
<head>
    <link rel="stylesheet" href="/css/output.css">    <!-- Tailwind -->
    <link rel="stylesheet" href="/css/custom.css">    <!-- Your CSS -->
</head>
```

## Files Created

- `package.json` - npm configuration
- `tailwind.config.js` - Tailwind configuration
- `public/css/input.css` - Source CSS with Tailwind directives
- `public/css/output.css` - Compiled CSS (generated after build)
- `views/tailwind-example.php` - Example usage

## Development Workflow

1. Start Tailwind watch: `npm run dev` (in one terminal)
2. Start PHP server: `composer serve` (in another terminal)
3. Edit your views with Tailwind classes
4. Tailwind auto-compiles on save

## Production Build

Before deployment:
```bash
npm run build
```

This creates a minified version of output.css.
README;

file_put_contents($projectPath . '/TAILWIND-SETUP.md', $instructions);
echo "✓ Created TAILWIND-SETUP.md\n";

echo "\n";
echo "========================================\n";
echo "Tailwind CSS configured successfully!\n";
echo "========================================\n";
echo "\n";
echo "✅ Created Files:\n";
echo "   - package.json\n";
echo "   - tailwind.config.js\n";
echo "   - public/css/input.css\n";
echo "   - views/tailwind-example.php\n";
echo "   - TAILWIND-SETUP.md\n";
echo "\n";
echo "📦 Next Steps:\n";
echo "\n";
echo "1. Install Node.js if not installed:\n";
echo "   https://nodejs.org/\n";
echo "\n";
echo "2. Install Tailwind CSS:\n";
echo "   npm install\n";
echo "\n";
echo "3. Build/Watch Tailwind:\n";
echo "   npm run dev     (watch mode)\n";
echo "   npm run build   (one-time build)\n";
echo "\n";
echo "4. Include in your views:\n";
echo "   <link rel=\"stylesheet\" href=\"/css/output.css\">\n";
echo "\n";
echo "5. See TAILWIND-SETUP.md for complete guide\n";
echo "\n";
echo "💡 Tip: Run 'npm run dev' in one terminal and 'composer serve' in another\n";
echo "\n";
echo "Done! 🎉\n";
