<?php
require_once('../base.php');
$conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database'], $GLOBALS['port']);
require_once('../posts/getposts.php');
require_once('printViewPosts.php');

function getEmployeesAndEmployers() {
    try {
        $result = $GLOBALS['conn']->query("SELECT * FROM EmployeesAndEmployers LIMIT 50");
        $jobposts = $result->fetch_all(MYSQLI_ASSOC);
        if (isset($jobposts)) {
            return [NULL, $jobposts];
        }
        return ['Failed to find JobPosts.', NULL];
    }
    catch (Exception $e) {
        return ['Failed to find JobPosts. ' . $e, NULL];
    }
}

[$error, $posts] = getEmployeesAndEmployers();

if (isset($posts)) {
    $inject['body'] = '<h4>Users that are Empoyees and Employers</h4>' . printViewPosts($posts);
}
else {
    $inject['warning'] = 'Failed to fetch job posts. ' . $error;
}

printMain($inject);


?>
