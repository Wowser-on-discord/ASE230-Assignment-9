<?php

function displayCSVData($csvFilename) {
    $filePath = "data/" . $csvFilename;

    $f = fopen($filePath, "r");

    if ($f !== false) {
        echo '<div class="row">';
        $currentDataType = "";

        while ($record = fgetcsv($f)) {
            // Determine the data type based on the number of columns
            $numColumns = count($record);

            if ($numColumns === 2) {
                // Data has two columns, treat it as "Awards"
                $year = isset($record[0]) ? $record[0] : '';
                $award = isset($record[1]) ? $record[1] : '';

                if ($currentDataType !== "Awards") {
                    $currentDataType = "Awards";
                }

                echo '<div class="col-lg-3 col-sm-6">';
                echo '<div class="award-box mt-4 position-relative overflow-hidden rounded text-center shadow">';
                echo '<div class="p-4">';
                echo '<p class="text-muted text-uppercase font-size-14 mb-0">' . $year . '</p>';
                echo '<p class="font-size-19 mb-1">' . $award . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            } elseif ($numColumns === 3) {
                // Data has three columns, treat it as "Team"
                $name = isset($record[0]) ? $record[0] : '';
                $position = isset($record[1]) ? $record[1] : '';
                $description = isset($record[2]) ? $record[2] : '';

                if ($currentDataType !== "Team") {
                    $currentDataType = "Team";
                }

                echo '<div class="col-lg-3 col-sm-6">';
                echo '<div class="team-box mt-4 position-relative overflow-hidden rounded text-center shadow">';
                echo '<div class="p-4">';
                echo '<h5 class="font-size-19 mb-1">' . $name . '</h5>';
                echo '<p class="text-muted text-uppercase font-size-14 mb-0">' . $position . '</p>';
                echo '<p class="text-muted font-size-14 mb-0">' . $description . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }

        echo '</div>';

        fclose($f);
    } else {
        echo "Failed to open the CSV file.";
    }
}
?>
