<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
</head>
<body>
<h1>Edit Task</h1>
<form method="POST">
    <input type="hidden" id="id" name="id" value="<?php echo $task->getId(); ?>">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="<?php echo $task->getTitle(); ?>" required>
    <br>
    <label for="description">Description:</label>
    <textarea id="description" name="description" required><?php echo $task->getDescription(); ?></textarea>
    <br>
    <label for="status">Status:</label>
    <select id="status" name="status">
        <option value="pending" <?php if ($task->getStatus() === 'pending') echo 'selected'; ?>>Pending</option>
        <option value="completed" <?php if ($task->getStatus() === 'completed') echo 'selected'; ?>>Completed</option>
    </select>
    <br>
    <button type="submit">Update Task</button>
</form>
</body>
</html>