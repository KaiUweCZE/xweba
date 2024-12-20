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
        <form method="post">
            <input type="hidden" name="action" value="add">
            <div class="mb-3">
                <label for="firstname" class="form-label">Jméno</label>
                <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Příjmení</label>
                <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Telefon</label>
                <input type="tel" class="form-control" id="phone" name="phone">
            </div>
            <div class="mb-3">
                <label for="office" class="form-label">Pracovna</label>
                <input type="text" class="form-control" id="office" name="office">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Popis</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Heslo</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="User">Uživatel</option>
                    <option value="Administrator">Správce</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Přidat uživatele</button>
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
                    <th>Jméno</th>
                    <th>Příjmení</th>
                    <th>Email</th>
                    <th>Telefon</th>
                    <th>Pracovna</th>
                    <th>Role</th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($user['firstname'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($user['lastname'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($user['email'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($user['phone'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($user['office'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($user['role'] ?? ''); ?></td>
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
                                        <label for="firstname<?php echo $user['id']; ?>" class="form-label">Jméno</label>
                                        <input type="text" class="form-control" id="firstname<?php echo $user['id']; ?>" 
                                               name="firstname" value="<?php echo htmlspecialchars($user['firstname'] ?? ''); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastname<?php echo $user['id']; ?>" class="form-label">Příjmení</label>
                                        <input type="text" class="form-control" id="lastname<?php echo $user['id']; ?>" 
                                               name="lastname" value="<?php echo htmlspecialchars($user['lastname'] ?? ''); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email<?php echo $user['id']; ?>" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email<?php echo $user['id']; ?>" 
                                               name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone<?php echo $user['id']; ?>" class="form-label">Telefon</label>
                                        <input type="tel" class="form-control" id="phone<?php echo $user['id']; ?>" 
                                               name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="office<?php echo $user['id']; ?>" class="form-label">Pracovna</label>
                                        <input type="text" class="form-control" id="office<?php echo $user['id']; ?>" 
                                               name="office" value="<?php echo htmlspecialchars($user['office'] ?? ''); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="description<?php echo $user['id']; ?>" class="form-label">Popis</label>
                                        <textarea class="form-control" id="description<?php echo $user['id']; ?>" 
                                                  name="description"><?php echo htmlspecialchars($user['description'] ?? ''); ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password<?php echo $user['id']; ?>" class="form-label">Heslo</label>
                                        <input type="password" class="form-control" id="password<?php echo $user['id']; ?>" 
                                               name="password" placeholder="Ponechte prázdné pro zachování současného hesla">
                                    </div>
                                    <div class="mb-3">
                                        <label for="role<?php echo $user['id']; ?>" class="form-label">Role</label>
                                        <select class="form-select" id="role<?php echo $user['id']; ?>" name="role" required>
                                            <option value="User" <?php echo $user['role'] === 'User' ? 'selected' : ''; ?>>Uživatel</option>
                                            <option value="Administrator" <?php echo $user['role'] === 'Administrator' ? 'selected' : ''; ?>>Správce</option>
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
