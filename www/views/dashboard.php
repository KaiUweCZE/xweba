<?php
$data = $_SESSION['view_data'] ?? [];
$logins = $data['logins'] ?? [];
?>

<h1 class="pb-3 border-bottom">Dashboard</h1>

<section class="mt-5">
    <h2>Poslední přihlášení</h2>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Jméno</th>
                    <th>Příjmení</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Čas přihlášení</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logins as $login): ?>
                <tr>
                    <td><?php echo htmlspecialchars($login['firstname']); ?></td>
                    <td><?php echo htmlspecialchars($login['lastname']); ?></td>
                    <td><?php echo htmlspecialchars($login['email']); ?></td>
                    <td><?php echo htmlspecialchars($login['role']); ?></td>
                    <td><?php echo htmlspecialchars(date('d.m.Y H:i:s', strtotime($login['login_time']))); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>