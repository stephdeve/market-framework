<div class="hero">
    <h1><?= htmlspecialchars($title) ?></h1>
    <p class="lead"><?= htmlspecialchars($message) ?></p>
    <div class="hero-buttons">
        <a href="/register" class="btn btn-primary">Get Started</a>
        <a href="/about" class="btn btn-secondary">Learn More</a>
    </div>
</div>

<div class="features">
    <h2>Framework Features</h2>
    <div class="feature-grid">
        <div class="feature-card">
            <h3>🚀 MVC Architecture</h3>
            <p>Clean separation of concerns with Models, Views, and Controllers</p>
        </div>
        <div class="feature-card">
            <h3>🛣️ Advanced Routing</h3>
            <p>Support for GET, POST, PUT, DELETE, PATCH with middleware and route groups</p>
        </div>
        <div class="feature-card">
            <h3>✅ Validation</h3>
            <p>Comprehensive validation system with multiple rules</p>
        </div>
        <div class="feature-card">
            <h3>🔐 Authentication</h3>
            <p>Built-in authentication system with password hashing</p>
        </div>
        <div class="feature-card">
            <h3>🗄️ Query Builder</h3>
            <p>Fluent SQL query builder for database operations</p>
        </div>
        <div class="feature-card">
            <h3>🔧 Middleware</h3>
            <p>Flexible middleware system for request filtering</p>
        </div>
    </div>
</div>
