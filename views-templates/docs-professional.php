<?php
// Professional documentation page - No dynamic content needed
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market Framework - Documentation</title>
    <link rel="stylesheet" href="/css/output.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
        }
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 280px;
            background: #2c3e50;
            color: white;
            overflow-y: auto;
            z-index: 1000;
        }
        .sidebar-header {
            padding: 2rem 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar-header h1 { font-size: 1.5rem; margin-bottom: 0.5rem; }
        .sidebar-header p { font-size: 0.9rem; opacity: 0.9; }
        .nav-section {
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .nav-section h3 {
            padding: 0.5rem 1.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.6;
        }
        .nav-link {
            display: block;
            padding: 0.75rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 0.9rem;
        }
        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            padding-left: 2rem;
        }
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            max-width: 1200px;
        }
        .page-header {
            padding: 3rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }
        .page-header h1 { font-size: 3rem; margin-bottom: 1rem; }
        .page-header p { font-size: 1.25rem; opacity: 0.95; }
        .content-section {
            background: white;
            padding: 2.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }
        h2 {
            color: #667eea;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 3px solid #667eea;
        }
        h3 { color: #333; font-size: 1.5rem; margin: 2rem 0 1rem 0; }
        h4 { color: #555; font-size: 1.25rem; margin: 1.5rem 0 0.75rem 0; }
        p { margin-bottom: 1rem; line-height: 1.8; color: #444; }
        .command-box {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1.5rem 0;
            font-family: 'Courier New', monospace;
            position: relative;
            border-left: 4px solid #667eea;
        }
        .command-box-label {
            position: absolute;
            top: -10px;
            left: 15px;
            background: #667eea;
            color: white;
            padding: 2px 10px;
            border-radius: 3px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        code {
            background: #f5f5f5;
            padding: 0.2rem 0.5rem;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            color: #e83e8c;
            font-size: 0.9em;
        }
        pre code { background: none; color: #f8f8f2; padding: 0; }
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        .feature-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 1.5rem;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }
        .feature-card h4 { color: #667eea; margin-top: 0; margin-bottom: 0.5rem; }
        .feature-card p { color: #333; font-size: 0.95rem; margin: 0; }
        ul, ol { margin: 1rem 0 1rem 2rem; line-height: 1.8; }
        li { margin: 0.5rem 0; }
        .step {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1rem 0;
            border-left: 4px solid #28a745;
        }
        .step-number {
            display: inline-block;
            width: 30px;
            height: 30px;
            background: #28a745;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            font-weight: 600;
            margin-right: 1rem;
        }
        .step-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 5px;
            margin: 1.5rem 0;
            border-left: 4px solid;
        }
        .alert-info { background: #e7f3ff; border-color: #2196F3; color: #0c5aa6; }
        .alert-success { background: #e8f5e9; border-color: #4caf50; color: #2e7d32; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; }
            .page-header h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h1>📚 Market Framework</h1>
            <p>Complete Documentation</p>
        </div>
        <div class="nav-section">
            <h3>Getting Started</h3>
            <a href="/" class="nav-link">Back to Home</a>
            <a href="#installation" class="nav-link">Installation</a>
            <a href="#quick-start" class="nav-link">Quick Start</a>
        </div>
    </div>
    
    <div class="main-content">
        <div class="page-header">
            <h1>Market Framework</h1>
            <p>A Modern, Lightweight PHP MVC Framework</p>
        </div>
        
        <div class="content-section" id="installation">
            <h2>🚀 Installation</h2>
            
            <div class="step">
                <span class="step-number">1</span>
                <div class="step-content">
                    <div class="step-title">Download Framework</div>
                    <div class="command-box">
                        <div class="command-box-label">Terminal</div>
                        <pre><code>cd "d:\Mes projets"
git clone https://github.com/your-repo/market-framework framework</code></pre>
                    </div>
                </div>
            </div>
            
            <div class="step">
                <span class="step-number">2</span>
                <div>
                    <div class="step-title">Create New Project</div>
                    <div class="command-box">
                        <div class="command-box-label">Terminal</div>
                        <pre><code>php framework\create-project.php my-app
cd my-app</code></pre>
                    </div>
                </div>
            </div>
            
            <div class="step">
                <span class="step-number">3</span>
                <div>
                    <div class="step-title">Configure Database</div>
                    <p>Edit <code>config/database.php</code></p>
                </div>
            </div>
            
            <div class="step">
                <span class="step-number">4</span>
                <div>
                    <div class="step-title">Start Server</div>
                    <div class="command-box">
                        <div class="command-box-label">Terminal</div>
                        <pre><code>composer serve</code></pre>
                    </div>
                </div>
            </div>
            
            <h3>Install Authentication</h3>
            <div class="command-box">
                <div class="command-box-label">Terminal</div>
                <pre><code>php install-auth.php
php migrate.php</code></pre>
            </div>
            
            <h3>Install Tailwind CSS</h3>
            <div class="command-box">
                <div class="command-box-label">Terminal</div>
                <pre><code>php install-tailwind.php
npm install
npm run dev</code></pre>
            </div>
        </div>
        
        <div class="content-section">
            <div class="alert alert-info">
                <strong>💡 Complete Documentation:</strong> See README.md in the framework directory for detailed information on all features.
            </div>
        </div>
    </div>
</body>
</html>
