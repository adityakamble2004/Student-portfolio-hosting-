<!DOCTYPE html>
<html>
<head>
    <title>Recruiter Panel</title>
</head>
<body>

<h2>Recruiter Dashboard</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Name</th>
        <th>Portfolio</th>
    </tr>

    <?php foreach ($students as $student): ?>
        <tr>
            <td><?php echo htmlspecialchars($student['name']); ?></td>
            <td>
                <?php if ($student['path']): ?>
                    <a href="index.php?route=view_portfolio&id=<?php echo $student['id']; ?>">
                        View Portfolio
                    </a>
                <?php else: ?>
                    Not Uploaded
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<br>
<a href="index.php?route=dashboard">Back</a>

</body>
</html>