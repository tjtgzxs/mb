<?php
include ('includes/header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tid']) && filter_var($_POST['tid'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) {
        $tid = $_POST['tid'];
    } else {
        $tid = FALSE;
    }
    if (!$tid && empty($_POST['subject'])) {
        $subject = FALSE;
        echo '<p>Please enter a subject for this post.</p>';
    } elseif (!$tid && !empty($_POST['subject'])) {
        $subject = htmlspecialchars(strip_tags($_POST['subject']));
    } else {
        $subject = TRUE;
    }
    if (!empty($_POST['body'])) {
        $body = htmlentities($_POST['body']);
    } else {
        $body = FALSE;
        echo '<p>Please enter a body for this post.</p>';
    }
    if ($subject && $body) {
        if (!$tid) {
            $q = "INSERT INTO threads (lang_id, user_id, subject) VALUES ({$_SESSION['lid']}, {$_SESSION['user_id']}, '" . mysqli_real_escape_string($dbc, $subject) . "')";
            $r = mysqli_query($dbc, $q);
            if (mysqli_affected_rows($dbc) == 1) {
                $tid = mysqli_insert_id($dbc);
            } else {
                echo '<p>Your post could not be handled due to a system error.</p>';
            }
        }
        if ($tid) {
            $q = "INSERT INTO posts (thread_id, user_id, message, posted_on) VALUES ($tid, {$_SESSION['user_id']}, '" . mysqli_real_escape_string($dbc, $body) . "', UTC_TIMESTAMP())";
            $r = mysqli_query($dbc, $q);
            if (mysqli_affected_rows($dbc) == 1) {
                echo '<p>Your post has been entered.</p>';
            } else {
                echo '<p>Your post could not be handled due to a system error.</p>';
            }
        }
    } else {
        include ('includes/post_form.php');
    }
} else {
    include ('includes/post_form.php');

}
include ('includes/footer.html');
?>