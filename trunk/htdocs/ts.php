<?

function render_file($file) {
    $x = file($file);
    foreach($x as $line) {
        $res .= $line;
    }
    return $res;
}

$pself = $_SERVER[PHP_SELF];

# header.txt

echo render_file('header.txt');

echo "<h2>Processo: d-i e manual</h2>\n";

echo "<p>Os dados destas tabelas sao criados automatica e periodicamente (00h02 08h02 e 16h02)</p>\n";

echo "<p><a href=\"$pself?level=stats\">Panorama</a></p>\n";

$l1 = "<a href=\"$pself?level=1\">1</a>";
$l2 = "<a href=\"$pself?level=2\">2</a>";
$l3 = "<a href=\"$pself?level=3\">3</a>";
$l4 = "<a href=\"$pself?level=4\">4</a>";
$l5 = "<a href=\"$pself?level=5\">5</a>";
$lm = "<a href=\"$pself?level=manual\">manual</a>";
$lf = "<a href=\"dados_tabbed/\">dados_tabbed/</a>";

$s1 = "<a href=\"$pself?scheck=1\">1</a>";
$s2 = "<a href=\"$pself?scheck=2\">2</a>";
$s3 = "<a href=\"$pself?scheck=3\">3</a>";
$s4 = "<a href=\"$pself?scheck=4\">4</a>";
$s5 = "<a href=\"$pself?scheck=5\">5</a>";
$sm = "<a href=\"$pself?scheck=manual\">manual</a>";
$sf = "<a href=\"scheck_tabbed/\">scheck_tabbed/</a>";

echo "<table width=\"100%\" summary=\"tabela do interface\">\n";

echo "<tr>\n";
echo "<td>Interface</td>\n";
echo "<td colspan=\"5\">Levels</td>\n";
echo "<td>d-i</td>\n";
echo "<td>Fonte</td>\n";
echo "</tr>\n";

echo "<tr>\n";
echo "<td>Estados dos niveis</td>\n";
echo "<td>$l1</td>\n";
echo "<td>$l2</td>\n";
echo "<td>$l3</td>\n";
echo "<td>$l4</td>\n";
echo "<td>$l5</td>\n";
echo "<td>$lm</td>\n";
echo "<td>$lf</td>\n";
echo "</tr>\n";

echo "<tr>\n";
echo "<td>Palavras desconhecidas (corrector)</td>\n";
echo "<td>$s1</td>\n";
echo "<td>$s2</td>\n";
echo "<td>$s3</td>\n";
echo "<td>$s4</td>\n";
echo "<td>$s5</td>\n";
echo "<td>$sm</td>\n";
echo "<td>$sf</td>\n";
echo "</tr>\n";

echo "</table>\n";

if (count($_GET)) {
    if (($_GET['level'] > 0) && ($_GET['level'] < 6)) {

        $onde = $_GET[level];

        echo "<p>Legenda: T - Traduzido : F - Difuso : U - Por traduzir</p>\n";

        echo "<p>Level $onde outdated</p>\n";
        echo render_file("dados/level$onde-outdated.txt");

        echo "<p>Level $onde translated</p>\n";
        echo render_file("dados/level$onde-translated.txt");

        echo "<p>Level $onde missing</p>\n";
        echo render_file("dados/level$onde-missing.txt");
    }

    if ($_GET['level'] == 'manual') {

        echo "<p>Legenda: T - Traduzido : F - Difuso : U - Por traduzir</p>\n";

        echo "<p>d-i manual - outdated</p>\n";
        echo render_file("dados/manual-outdated.txt");

        echo "<p>d-i manual - translated</p>\n";
        echo render_file("dados/manual-translated.txt");

        echo "<p>d-i manual - missing</p>\n";
        echo render_file("dados/manual-missing.txt");
    }

    if ($_GET['level'] == 'stats') {

        $l1 = "<a href=\"stats_tabbed/\">stats_tabbed/</a>";
        $l2 = "<a href=\"ranks_tabbed/\">ranks_tabbed/</a>";

        echo "<p>Estatisticas dos 5 niveis</p>\n";

        echo "<table width=\"50%\" summary=\"stats table\">\n";

        echo "<tr>\n";
        echo "<td class=\"total\">Level</td>\n";
        echo "<td class=\"total\">T</td>\n";
        echo "<td class=\"total\">F</td>\n";
        echo "<td class=\"total\">U</td>\n";
        echo "</tr>\n";

        for ($i = 1; $i < 6; $i++) {
            echo render_file("stats/level$i-stats.txt");
        }

        echo "</table>\n";

        echo "<p>Ranks nos 5 niveis</p>\n";

        echo "<table width=\"50%\" summary=\"stats table\">\n";

        echo "<tr>\n";
        echo "<td class=\"total\">Level</td>\n";
        echo "<td class=\"total\">Rank</td>\n";
        echo "<td class=\"total\">Percentagem</td>\n";
        echo "</tr>\n";

        for ($i = 1; $i < 6; $i++) {
            echo render_file("ranks/level$i-rank.txt");
        }

        echo render_file("ranks/manual-rank.txt");

        echo "</table>\n";
    }

    if (($_GET['scheck'] > 0) && ($_GET['scheck'] < 6)) {

        $onde = $_GET['scheck'];

        echo "<p>Legenda: O - total de ocorrencias da palavra : P - palavra</p>\n";

        echo "<p>Level $onde (desconhecidas)</p>\n";
        echo render_file("scheck/level$onde-pt_unkn_wl.txt");
    }

    if ($_GET['scheck'] == 'manual') {

        echo "<p>Legenda: O - total de ocorrencias da palavra : P - palavra</p>\n";

        echo "<p>d-i manual</p>\n";
        echo render_file("scheck/manual-pt_unkn_wl.txt");
    }
}

echo render_file('footer.txt');

?>

