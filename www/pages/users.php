<?php
$data = $_SESSION['view_data'] ?? [];
$users = $data['users'] ?? [];
$message = $data['message'] ?? '';
?>
<h1 class="pb-3 border-bottom">Users</h1>

<?php if ($message): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo htmlspecialchars($message); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Formulář pro přidání uživatele -->
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title">Přidat nového uživatele</h5>
        <form method="post" class="row g-3">
            <input type="hidden" name="action" value="add">
            <div class="col-md-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="col-md-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="col-md-4">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="User">User</option>
                    <option value="Administrator">Administrator</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Přidat uživatele</button>
            </div>
        </form>
    </div>
</div>

<!-- Tabulka uživatelů -->
<section class="mt-4">
    <h2>Users Management</h2>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $user['id']; ?>">
                            Edit
                        </button>
                        <form method="post" class="d-inline">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Opravdu chcete smazat tohoto uživatele?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- Modal pro editaci -->
                <div class="modal fade" id="editModal<?php echo $user['id']; ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post">
                                    <input type="hidden" name="action" value="edit">
                                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                    <div class="mb-3">
                                        <label for="username<?php echo $user['id']; ?>" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username<?php echo $user['id']; ?>" 
                                               name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email<?php echo $user['id']; ?>" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email<?php echo $user['id']; ?>" 
                                               name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="role<?php echo $user['id']; ?>" class="form-label">Role</label>
                                        <select class="form-select" id="role<?php echo $user['id']; ?>" name="role" required>
                                            <option value="User" <?php echo $user['role'] === 'User' ? 'selected' : ''; ?>>User</option>
                                            <option value="Administrator" <?php echo $user['role'] === 'Administrator' ? 'selected' : ''; ?>>Administrator</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Uložit změny</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
