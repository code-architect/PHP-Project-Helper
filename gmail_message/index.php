<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Contact Form</h1>
<form action="subject.php" method="post" enctype="multipart/form-data"> <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div class="form-group">
        <label for="subject">Subject:</label>
        <input type="text" name="subject" id="subject" required>
    </div>
    <div class="form-group">
        <label for="message">Message:</label>
        <textarea name="message" id="message" rows="5" required></textarea>
    </div>
    <button type="submit">Send Message</button>
</form>
</body>
</html>
