<!DOCTYPE html>
<html>
<head>
    <title>Task List</title>
</head>
<body>
<h1>Task List</h1>
<ul>
    <?php foreach ($tasks as $task): ?>
        <li>
            <?php echo $task->getTitle(); ?> - <?php echo $task->getDescription(); ?> - <?php echo $task->getStatus(); ?>
        </li>
    <?php endforeach; ?>
</ul>
<a href="task_add">Add Task</a>
</body>
</html>