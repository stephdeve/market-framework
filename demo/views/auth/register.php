<div class="page-header">
    <h1>Register</h1>
</div>

<div class="form-container">
    <form method="POST" action="/register" class="form">
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
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($_SESSION['old']['name'] ?? '') ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Register</button>
        
        <p class="form-footer">
            Already have an account? <a href="/login">Login here</a>
        </p>
    </form>
</div>
<?php unset($_SESSION['old']); ?>
