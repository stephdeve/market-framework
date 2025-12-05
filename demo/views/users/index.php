<div class="page-header">
    <h1>Users</h1>
    <a href="/users/create" class="btn btn-primary">Create User</a>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($users)): ?>
                <?php foreach($users as $user): ?>
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><?= htmlspecialchars($user->name) ?></td>
                        <td><?= htmlspecialchars($user->email) ?></td>
                        <td><?= $user->created_at ?? 'N/A' ?></td>
                        <td>
                            <a href="/users/<?= $user->id ?>" class="btn btn-sm">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No users found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
