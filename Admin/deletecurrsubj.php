/* ============================================================
   10. ADMIN: Admin/deletecurrsubj.php
   Replace the entire file.
   ============================================================ */

<?php
session_start();
require_once __DIR__ . '/logcheck.php';
require_once __DIR__ . '/includes/conn.php';

$subjectId = filter_input(INPUT_GET, 'accid', FILTER_VALIDATE_INT);

if (!$subjectId || $subjectId < 1) {
    header('Location: subjectreg.php');
    exit;
}

$stmt = $mysqli->prepare("DELETE FROM subjecttbl WHERE ID = ?");
$stmt->bind_param("i", $subjectId);
$stmt->execute();

header('Location: subjectreg.php');
exit;
?>