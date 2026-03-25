<!DOCTYPE html>
<html>
<head>
    <title>Upload Portfolio</title>
</head>
<body>

<h2>Upload Your Portfolio (ZIP)</h2>

<form method="POST" action="index.php?route=do_upload" enctype="multipart/form-data">
    <input type="file" name="zip" required><br><br>
    <button type="submit">Upload</button>
</form>

<br>
<a href="index.php?route=dashboard">Back</a>

</body>
</html>