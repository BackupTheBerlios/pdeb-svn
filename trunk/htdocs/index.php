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

echo "<p>Para obter todos os ficheiros que concebem este site:</p>\n";

echo "<div><code>shell$ svn checkout svn://svn.berlios.de/pdeb/trunk<code></div>\n";
echo "<div><code>shell$ svn checkout http://svn.berlios.de/svnroot/repos/pdeb/trunk<code></div>\n";

echo render_file('footer.txt');

?>

