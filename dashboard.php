<?php

require_once 'dashboard_process.php';

?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">
                    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                </h3>
            </div>
            <div class="card-body">
                <p class="lead">You have successfully logged into the system.</p>
                
                <h4 class="mt-4">Registered Users</h4>
                
                <?php if (!empty($users)): ?>
                    <div class="table-responsive user-table">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Signup Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($users as $user): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo date('M j, Y g:i A', strtotime($user['created_at'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">No users found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>