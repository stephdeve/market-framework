<?php
/**
 * Market Framework - Update Documentation Page
 * 
 * This script reads the framework's README.md and creates a beautiful HTML documentation page
 * 
 * Usage: php update-docs.php
 */

$projectPath = __DIR__;
$frameworkReadme = dirname($projectPath) . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'README.md';

echo "Updating Documentation Page...\n";
echo "===============================\n\n";

// Check if README exists
if (!file_exists($frameworkReadme)) {
    die("Error: Framework README.md not found at: {$frameworkReadme}\n");
}

// Read the README content
$readmeContent = file_get_contents($frameworkReadme);
echo "✓ Loaded README.md from framework\n";

// Simple Markdown to HTML conversion
function markdownToHtml($markdown) {
    // Convert headers
    $html = preg_replace('/^# (.+)$/m', '<h1>$1</h1>', $markdown);
    $html = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $html);
    $html = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $html);
    $html = preg_replace('/^#### (.+)$/m', '<h4>$1</h4>', $html);
    
    // Convert bold
    $html = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $html);
    
    // Convert inline code
    $html = preg_replace('/`([^`]+)`/', '<code>$1</code>', $html);
    
    // Convert code blocks
    $html = preg_replace_callback('/```(\w+)?\n(.*?)```/s', function($matches) {
        $lang = $matches[1] ?? '';
        $code = htmlspecialchars($matches[2]);
        return "<pre><code class=\"language-{$lang}\">{$code}</code></pre>";
    }, $html);
    
    // Convert lists
    $html = preg_replace('/^- (.+)$/m', '<li>$1</li>', $html);
    $html = preg_replace('/(<li>.*<\/li>\n)+/s', '<ul>$0</ul>', $html);
    
    // Convert paragraphs
    $html = preg_replace('/^(?!<[h|u|p|l]|```)(.+)$/m', '<p>$1</p>', $html);
    
    // Clean up
    $html = str_replace("\r\n", "\n", $html);
    
    return $html;
}

$htmlContent = markdownToHtml($readmeContent);

// Create the full documentation page
$docsPage = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentation - Market Framework</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8f9fa;
            line-height: 1.6;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar h1 { 
            font-size: 1.5rem;
            margin: 0;
        }
        .back-link {
            display: inline-block;
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            background: rgba(255,255,255,0.2);
            border-radius: 5px;
            margin-left: 1rem;
            font-size: 0.9rem;
            transition: background 0.3s;
        }
        .back-link:hover {
            background: rgba(255,255,255,0.3);
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        .content {
            background: white;
            border-radius: 10px;
            padding: 3rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        h1 {
            color: #667eea;
            font-size: 2.5rem;
            margin: 2rem 0 1.5rem 0;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid #667eea;
        }
        h2 {
            color: #333;
            font-size: 2rem;
            margin: 2.5rem 0 1rem 0;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e0e0e0;
        }
        h3 {
            color: #555;
            font-size: 1.5rem;
            margin: 2rem 0 0.75rem 0;
        }
        h4 {
            color: #666;
            font-size: 1.25rem;
            margin: 1.5rem 0 0.5rem 0;
        }
        p {
            color: #444;
            margin-bottom: 1rem;
            line-height: 1.8;
        }
        ul {
            margin: 1rem 0 1rem 2rem;
            color: #444;
        }
        li {
            margin: 0.5rem 0;
            line-height: 1.6;
        }
        code {
            background: #f5f5f5;
            padding: 0.2rem 0.5rem;
            border-radius: 3px;
            font-family: 'Courier New', Consolas, monospace;
            color: #e83e8c;
            font-size: 0.9em;
        }
        pre {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 1.5rem;
            border-radius: 8px;
            overflow-x: auto;
            margin: 1.5rem 0;
            border-left: 4px solid #667eea;
        }
        pre code {
            background: none;
            color: #f8f8f2;
            padding: 0;
            font-size: 0.95em;
        }
        strong {
            color: #333;
            font-weight: 600;
        }
        .toc {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 1.5rem;
            margin: 2rem 0;
            border-radius: 5px;
        }
        .toc h3 {
            margin-top: 0;
            color: #667eea;
        }
        a {
            color: #667eea;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            .content {
                padding: 1.5rem;
            }
            h1 { font-size: 2rem; }
            h2 { font-size: 1.5rem; }
            h3 { font-size: 1.25rem; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>📚 Market Framework Documentation <a href="/" class="back-link">← Back to Home</a></h1>
    </div>

    <div class="container">
        <div class="content">
            {$htmlContent}
        </div>
    </div>
</body>
</html>
HTML;

// Save the documentation page
file_put_contents($projectPath . '/views/docs.php', $docsPage);
echo "✓ Created docs.php with complete framework documentation\n";

// Also create a static copy for offline viewing
file_put_contents($projectPath . '/FRAMEWORK-DOCS.html', $docsPage);
echo "✓ Created FRAMEWORK-DOCS.html for offline viewing\n";

echo "\n";
echo "========================================\n";
echo "Documentation updated successfully!\n";
echo "========================================\n";
echo "\n";
echo "✅ The /docs page now contains the complete framework documentation\n";
echo "✅ Also saved as FRAMEWORK-DOCS.html for offline viewing\n";
echo "\n";
echo "🚀 Visit: http://localhost:8000/docs\n";
echo "\n";
echo "Done! 🎉\n";
