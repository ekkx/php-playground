<?php

require '../db_conn.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    if (empty($id)) {
        echo 'error';
    } else {
        $tasks = $conn->prepare('SELECT id, checked FROM tasks WHERE id = ?');
        $tasks->execute([$id]);

        $tasks = $tasks->fetch();
        $uId = $tasks['id'];
        $checked = $tasks['checked'];

        $uChecked = $checked ? 0 : 1;

        $res = $conn->query("UPDATE tasks SET checked=$uChecked WHERE id=$uId");

        if ($res) {
            echo $checked;
        } else {
            echo 'error';
        }

        $conn = null;
        exit();
    }
} else {
    header('Location: ../index.php?message=error');
}
