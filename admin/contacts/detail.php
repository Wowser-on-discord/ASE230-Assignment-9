<!DOCTYPE html>
<html>
<head>
    <title>Contact Details</title>
</head>
<body>

<?php
if (isset($_GET['name'])) {
    $name = $_GET['name'];
    
    $contacts = array_map('str_getcsv', file('../../data/contacts.csv'));
    
    foreach ($contacts as $contact) {
        if ($contact[0] === $name) {
            list($name, $email, $subject, $message) = $contact;

            echo "<h1>Contact Details</h1>";
            echo "<p><strong>Name:</strong> $name</p>";
            echo "<p><strong>Email:</strong> $email</p>";
            echo "<p><strong>Subject:</strong> $subject</p>";
            echo "<p><strong>Message:</strong> $message</p>";
            
            break;
        }
    }

    if (!isset($name)) {
        echo "This contact cannot be found.";
    }
} else {
    echo "Invalid request.";
}
?>

</body>
</html>
