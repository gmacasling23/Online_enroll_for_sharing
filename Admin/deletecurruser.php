/* ============================================================
   9. ADMIN: Admin/deletecurruser.php
   Replace the entire file.
   ============================================================ */

<?php
session_start();
require_once __DIR__ . '/logcheck.php';
require_once __DIR__ . '/includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['accid'])) {
    header('Location: userreg.php');
    exit;
}

$studentId = filter_input(INPUT_GET, 'accid', FILTER_VALIDATE_INT);

if (!$studentId || $studentId < 1) {
    header('Location: userreg.php');
    exit;
}

$stmt = $mysqli->prepare(
    "SELECT accountID FROM studenttbl WHERE ID = ?"
);
$stmt->bind_param("i", $studentId);
$stmt->execute();

$student = $stmt->get_result()->fetch_assoc();

if ($student) {
    $accountId = (int) $student['accountID'];

    $mysqli->begin_transaction();

    try {
        $stmt = $mysqli->prepare(
            "DELETE FROM student_subject WHERE studentID = ?"
        );
        $stmt->bind_param("s", $student['studnum'] ?? '');
        $stmt->execute();

        $stmt = $mysqli->prepare(
            "DELETE FROM studenttbl WHERE ID = ?"
        );
        $stmt->bind_param("i", $studentId);
        $stmt->execute();

        $stmt = $mysqli->prepare(
            "DELETE FROM usertbl WHERE ID = ? AND user_type = 'student'"
        );
        $stmt->bind_param("i", $accountId);
        $stmt->execute();

        $mysqli->commit();
    } catch (Throwable $e) {
        $mysqli->rollback();
        error_log($e->getMessage());
        exit('Unable to delete the student account.');
    }
}

header('Location: userreg.php');
exit;
?>