<div class="page-header">
    <h1>User Details</h1>
    <a href="/users" class="btn btn-secondary">Back to List</a>
</div>

<div class="card">
    <h2><?= htmlspecialchars($user->name) ?></h2>
    <p><strong>Email:</strong> <?= htmlspecialchars($user->email) ?></p>
    <p><strong>ID:</strong> <?= $user->id ?></p>
    <p><strong>Created:</strong> <?= $user->created_at ?? 'N/A' ?></p>
</div>
