<?php
function readtxt($filename) {
    $f1 = file_get_contents(__DIR__ . '/../data/' . $filename);
    $f2 = json_decode($f1, true);

    foreach ($f2["information"] as $info) {
        $name = $info["name"];
        $description = $info["description"];

        echo '<div class="service-box text-center px-4 py-5 position-relative mb-4">';
        echo "<div class='service-box-content p-4'>";
        echo '<div class="icon-mono service-icon avatar-md mx-auto mb-4">';
        echo '<i class="" data-feather="box"></i>';
        echo '</div>';
        echo "<h4 class='mb-3 font-size-22'>";
        echo "$name:<br><span style='font-weight: normal; font-size: 19px;'>$description</span><br>";
        echo "</h4>";
        echo "<p class='text-muted mb-0'>";
        if (isset($info["applications"])) {
            echo "<span style='font-weight: bold; font-size: 16px;'>Applications:</span><br>";
            foreach ($info["applications"] as $application => $description2) {
                echo "• $application: $description2<br>";
            }
        } else {
            echo "No applications found<br>";
        }        
        echo "</p>";
        echo '</div>';
        echo '</div>';
    }
}

readtxt("info.json");
?>
