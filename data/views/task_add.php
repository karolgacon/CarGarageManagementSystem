<!DOCTYPE html>
<html>
<head>
    <title>Add Task</title>
</head>
<body>
<h1>Add Task</h1>
<form method="POST">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required>
    <br>
    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea>
    <br>
    <label for="status">Status:</label>
    <select id="status" name="status">
        <option value="pending">Pending</option>
        <option value="completed">Completed</option>
    </select>
    <br>
    <button type="submit">Add Task</button>
</form>
</body>
</html>