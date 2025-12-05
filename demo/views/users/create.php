<div class="page-header">
    <h1>Create User</h1>
    <a href="/users" class="btn btn-secondary">Back to List</a>
</div>

<div class="form-container">
    <form method="POST" action="/users" class="form">
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
        
        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>
<?php unset($_SESSION['old']); ?>
