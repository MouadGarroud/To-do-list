<!-- Mouad Garroud -->
<?php
include("connection.php");
session_start();
$query = "SELECT id_task, task, date_create, check_status, date_complete FROM task";
$result = $conn->query($query);
$task_results = [];
while ($row = $result->fetch_assoc()) {
    $task_results[] = $row;
}
$result->close();
if (isset($_POST['add'])) {
    $task = $_POST['task'];
    $date_create = date('Y-m-d H:i:s');
    $query = "INSERT INTO task (task, date_create, check_status) VALUES (?, ?, 0)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $task, $date_create);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}
if (isset($_POST['toggle']) && isset($_POST['id_task'])) {
    $id_task = $_POST['id_task'];
    $query = "SELECT check_status FROM task WHERE id_task = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id_task);
    $stmt->execute();
    $stmt->bind_result($current_status);
    $stmt->fetch();
    $stmt->close();
    $new_status = ($current_status == 0) ? 1 : 0;
    $date_complete = ($new_status == 1) ? date('Y-m-d H:i:s') : NULL;
    $query = "UPDATE task SET check_status = ?, date_complete = ? WHERE id_task = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isi', $new_status, $date_complete, $id_task);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}
if (isset($_POST['delete']) && isset($_POST['id_task'])) {
    $id_task = $_POST['id_task'];
    $query = "DELETE FROM task WHERE id_task = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id_task);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <div class="content">
        <div class="add_task">
            <form method="post">
                <input type="text" maxlength="100" id="task" name="task" required>
                <button type="submit" name="add">Add</button>
            </form>
        </div>
        <div id="tas" class="task">
            <?php if (!empty($task_results)) : ?>
                <?php foreach ($task_results as $result) : ?>
                    <div class="info">
                        <input name="bd_task" value="<?php echo htmlspecialchars($result['task']); ?>" readonly>
                        <p>Created: <?php echo htmlspecialchars($result['date_create']); ?></p>
                        <?php if ($result['check_status'] == 1 && !empty($result['date_complete'])) : ?>
                            <p>Completed: <?php echo htmlspecialchars($result['date_complete']); ?></p>
                        <?php endif; ?>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id_task" value="<?php echo htmlspecialchars($result['id_task']); ?>">
                            <button type="submit" name="toggle">
                                <?php echo ($result['check_status'] == 0) ? "Complete" : "Incomplete"; ?>
                            </button>
                            <button type="submit" name="delete">Delete</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No tasks.</p>
            <?php endif; ?>
            <div class="a"><br></div>
        </div>
    </div>
</body>
</html>
