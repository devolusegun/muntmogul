<?php
session_start();
require '../config/config.php';

if (!isset($_SESSION["admin_id"])) {
    header("Location: route_logon");
    exit();
}

// ✅ Fetch Pending Withdrawals
$stmt = $pdo->query("SELECT crypto_withdrawals.id, crypticusers.first_name, crypticusers.last_name, 
                            crypto_withdrawals.crypto_type, crypto_withdrawals.wallet_address, 
                            crypto_withdrawals.amount, crypto_withdrawals.created_at 
                     FROM crypto_withdrawals 
                     JOIN crypticusers ON crypto_withdrawals.user_id = crypticusers.id
                     WHERE crypto_withdrawals.status = 'pending'");
$pendingWithdrawals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Admin Withdrawals</h2>

<table border="1">
    <tr>
        <th>User</th>
        <th>Crypto Type</th>
        <th>Wallet Address</th>
        <th>Amount</th>
        <th>Request Date</th>
        <th>Action</th>
    </tr>
    <?php foreach ($pendingWithdrawals as $withdrawal) : ?>
    <tr>
        <td><?= htmlspecialchars($withdrawal["first_name"] . " " . $withdrawal["last_name"]); ?></td>
        <td><?= htmlspecialchars($withdrawal["crypto_type"]); ?></td>
        <td><?= htmlspecialchars($withdrawal["wallet_address"]); ?></td>
        <td><?= number_format($withdrawal["amount"], 8) . " " . htmlspecialchars($withdrawal["crypto_type"]); ?></td>
        <td><?= $withdrawal["created_at"]; ?></td>
        <td>
            <a href="approve_route.php?id=<?= $withdrawal['id']; ?>&action=approve&type=withdrawal">Approve</a> | 
            <a href="#" onclick="showRejectionModal(<?= $withdrawal['id']; ?>)">Reject</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<!-- Rejection Modal -->
<div id="rejectionModal" style="display: none;">
    <form id="rejectionForm" action="approve_route.php" method="POST">
        <input type="hidden" name="id" id="withdrawal_id">
        <input type="hidden" name="action" value="reject">
        <input type="hidden" name="type" value="withdrawal">
        <label for="rejection_reason">Reason for Rejection:</label>
        <textarea name="rejection_reason" id="rejection_reason" required></textarea>
        <button type="submit">Submit</button>
        <button type="button" onclick="hideRejectionModal()">Cancel</button>
    </form>
</div>

<script>
function showRejectionModal(id) {
    document.getElementById('withdrawal_id').value = id;
    document.getElementById('rejectionModal').style.display = 'block';
}

function hideRejectionModal() {
    document.getElementById('rejectionModal').style.display = 'none';
}
</script>
