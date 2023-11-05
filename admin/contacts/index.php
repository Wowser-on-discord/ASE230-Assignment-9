<!DOCTYPE html>
<html>
<head>
    <title>Contact List</title>
</head>
<body>

    <?php
        $contacts = array_map('str_getcsv', file('../../data/contacts.csv'));

        if (count($contacts) > 0) {
            echo '<table border="1">';
            echo '<tr><th>Name</th><th>Subject</th></tr>';

            foreach ($contacts as $contact) {
                list($name, $email, $subject, $message) = $contact;
                echo "<tr><td><a href='detail.php?name=$name'>$name</a></td><td>$subject</td></tr>";
            }

            echo '</table>';
        } else {
            echo '<p>No contacts found.</p>';
        }
    ?>

</body>
</html>
