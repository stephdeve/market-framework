<div class="page-header">
    <h1>Login</h1>
</div>

<div class="form-container">
    <form method="POST" action="/login" class="form">
        <?php if(isset($_SESSION['errors'])): ?>
            <div class="alert alert-error">
                <?php foreach($_SESSION['errors'] as $field => $errors): ?>
                    <?php foreach($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <?php unset($_SESSION['errors']); ?>
            </div>
        <?php endif; ?>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Login</button>
        
        <p class="form-footer">
            Don't have an account? <a href="/register">Register here</a>
        </p>
    </form>
</div>
