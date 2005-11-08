<?php

function render_file($file) {
    $x = file($file);
    foreach($x as $line) {
        $res .= $line;
    }
    return $res;
}

# header.txt

echo render_file('header.txt');

echo "<h2>Saltar para o processo:</h2>\n";

echo "<ul>\n";
echo "<li><a href=\"ts.php\">d-i e manual</a></li>\n";
echo "<li><a href=\"debconf.php\">debconf</a></li>\n";
echo "</ul>\n";

echo render_file('footer.txt');

?>

