/* ============================================================
   4. ADMIN: Admin/logcheck.php
   Replace the entire file.
   ============================================================ */

<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (
    empty($_SESSION['logcheck']) ||
    ($_SESSION['type'] ?? '') !== 'admin'
) {
    header('Location: ../index.php');
    exit;
}
?>