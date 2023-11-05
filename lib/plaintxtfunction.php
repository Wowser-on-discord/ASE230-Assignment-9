<?php
function readPlainTxt() {
    $f = "data/info.txt";
    $f1 = file_get_contents($f);

    // Split the file content into two parts based on the "Mission Statement:" delimiter
    list($overview, $msn) = explode("Mission Statement:", $f1, 2);

    // Trim any extra whitespace from the extracted parts
    $overview = trim($overview);
    $msn = trim($msn);

    // Display the first part (Overview) and second part (Mission Statement)
    echo " <br>" . $overview . "<br><br>";
    echo "Mission Statement: <br>" . $msn . "<br>";
}

// Call the readtxt function to read and display the contents of "info.txt"
readPlainTxt();
?>
