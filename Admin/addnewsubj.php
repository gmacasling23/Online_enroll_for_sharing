
<?php
session_start();

require_once __DIR__ . '/logcheck.php';
require_once __DIR__ . '/includes/conn.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {

    // Get and validate form data
    $course = trim($_POST['course'] ?? '');
    $stitle = trim($_POST['stitle'] ?? '');
    $scode = trim($_POST['scode'] ?? '');
    $sdescription = trim($_POST['cdescription'] ?? '');
    $numunits = filter_input(INPUT_POST, 'numunits', FILTER_VALIDATE_INT);

    $sroom = trim($_POST['sroom'] ?? '');
    $stime = trim($_POST['stime'] ?? '');
    $sday = trim($_POST['sday'] ?? '');
    $sinstructor = trim($_POST['sinstructor'] ?? '');

    $islab = isset($_POST['islab']) ? 1 : 0;
    $istutorial = isset($_POST['istutorial']) ? 1 : 0;

    if (
        $course === '' ||
        $stitle === '' ||
        $scode === '' ||
        $sroom === '' ||
        $stime === '' ||
        $sday === '' ||
        $sinstructor === '' ||
        $numunits === false ||
        $numunits < 1 ||
        $numunits > 6
    ) {
        $message = 'Please complete all required fields correctly.';
    } else {
        try {
            $stmt = $mysqli->prepare(
                "INSERT INTO subjecttbl
                (subjectcode, subjecttitle, numofunits, room, `time`,
                 `day`, instructor, islab, istutorial, description, course_con)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "ssissssiiss",
                $scode,
                $stitle,
                $numunits,
                $sroom,
                $stime,
                $sday,
                $sinstructor,
                $islab,
                $istutorial,
                $sdescription,
                $course
            );

            $stmt->execute();

            header('Location: addnewsubj.php?success=1');
            exit;

        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage());
            $message = 'Unable to add the subject. Please try again.';
        }
    }
}

if (isset($_GET['success'])) {
    $message = 'Successfully created a new subject.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>John Paul College - Add New Subject</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>

<div class="header"></div>

<nav class="container">
    <?php include __DIR__ . '/includes/menu1.php'; ?>
</nav>

<div id="main">
    <div class="shell">
        <center>

            <?php if ($message !== ''): ?>
                <p>
                    <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
                </p>
            <?php endif; ?>

            <form class="cmxform" method="POST" action="">

                <fieldset>
                    <legend>Course Details</legend>
                    <ol>
                        <li>
                            <label for="course">Select Course:</label>
                            <select name="course" id="course" required>
                                <option value="bsit">BSIT</option>
                            </select>
                        </li>
                    </ol>
                </fieldset>

                <fieldset>
                    <legend>Subject Details</legend>
                    <ol>
                        <li>
                            <table>
                                <tr>
                                    <td>
                                        <label for="scode">Subject Code:</label>
                                    </td>
                                    <td>
                                        <input type="text" id="scode"
                                            name="scode" maxlength="100" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label for="stitle">Subject Title:</label>
                                    </td>
                                    <td>
                                        <input type="text" id="stitle"
                                            name="stitle" maxlength="100" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label for="numunits">Number of Units:</label>
                                    </td>
                                    <td>
                                        <select name="numunits" id="numunits" required>
                                            <?php for ($i = 1; $i <= 6; $i++): ?>
                                                <option value="<?= $i ?>">
                                                    <?= $i ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label for="cdescription">Subject Description:</label>
                                    </td>
                                    <td>
                                        <textarea name="cdescription"
                                            id="cdescription" maxlength="100"></textarea>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label for="sroom">Room:</label>
                                    </td>
                                    <td>
                                        <input type="text" id="sroom"
                                            name="sroom" maxlength="100" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label for="sday">Day:</label>
                                    </td>
                                    <td>
                                        <input type="text" id="sday"
                                            name="sday" maxlength="100" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label for="stime">Time:</label>
                                    </td>
                                    <td>
                                        <input type="text" id="stime"
                                            name="stime" maxlength="100" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label for="sinstructor">Instructor:</label>
                                    </td>
                                    <td>
                                        <input type="text" id="sinstructor"
                                            name="sinstructor" maxlength="100" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label for="islab">With Lab:</label>
                                    </td>
                                    <td>
                                        <input type="checkbox" name="islab" id="islab">
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label for="istutorial">With Tutorial:</label>
                                    </td>
                                    <td>
                                        <input type="checkbox"
                                            name="istutorial" id="istutorial">
                                    </td>
                                </tr>
                            </table>
                        </li>
                    </ol>
                </fieldset>

                <div align="center">
                    <input type="submit" name="register" value="Add New Subject">
                    <input type="reset" value="Clear">
                </div>

            </form>
        </center>
    </div>
</div>

<div id="footer">
    <div class="shell">
        <div class="footer-navigation">
            <?php include __DIR__ . '/includes/menu2.php'; ?>
        </div>

        <p class="right">Copyright 2014 | Online Enrollment</p>
        <div class="cl">&nbsp;</div>
    </div>
</div>

</body>
</html>
