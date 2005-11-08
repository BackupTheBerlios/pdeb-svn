<?php

require('mfsql.inc');

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

echo "<h2>Processo: debconf</h2>\n";

echo "<p>Os dados destas tabelas sao actualizados automatica e periodicamente todos os dias pares às 8h22</p>\n";

# nota:  quando fizer commit para o svn mudar a password para 'x'

$db = new Database('pdeb', 'pdeb', 'x', 'db.berlios.de');

if ($_GET['op'] == 'update') {
    $id = $_POST['pacote'];
    $data = date("Y-m-d");

    $sql  = "UPDATE pacote SET estado = 'A ser traduzido', data = '$data' ";
    $sql .= "WHERE id = '$id'";

    $db->Sql($sql);
}

$l1 = "<a href=\"$pself?vista=1\">Por traduzir</a>";
$l2 = "<a href=\"$pself?vista=2\">A ser traduzido</a>";
$l3 = "<a href=\"$pself?vista=3\">Traduzido</a>";
$l4 = "<a href=\"$pself?vista=4\">Todos</a>";

echo "<p>Ponto de vista:</p>\n";

echo "<ol>\n";
echo "<li>$l1</li>\n";
echo "<li>$l2</li>\n";
echo "<li>$l3</li>\n";
echo "<li>$l4</li>\n";
echo "</ol>\n";

switch ($_GET['vista']) {
case 1:
    $estado = "estado = 'Por traduzir'";
    break;
case 2:
    $estado = "estado = 'A ser traduzido'";
    break;
case 3:
    $estado = "estado = 'OK'";
    break;
case 4:
    $estado = "id = id";
    break;
    default: $estado = "estado = 'nada'";
    break;
}

$sql  = "SELECT nome, versao, t_file_l, t_statis, estado, data, ";
$sql .= "(to_days(curdate()) - to_days(data)) AS dias_passados FROM pacote ";
$sql .= "WHERE $estado ORDER BY nome";

$tabela = $db->Sql($sql);

# linhas
echo "<p>Pacotes desta vista: " . (count($tabela) - 1) . "</p>\n";

$tabela_nova = array();
$i = 0;

foreach($tabela as $pacote) {
    $f1 = $pacote['nome'];
    $f2 = $pacote['versao'];
    $f3 = $pacote['t_file_l'];
    $f4 = $pacote['t_statis'];
    $f5 = $pacote['estado'];
    $f6 = $pacote['data'];
    $f7 = $pacote['dias_passados'];

    $link  = 'http://merkel.debian.org/~barbier/l10n/material/po/unstable/';
    $link .= $f3 . '.gz';

    $f1 = "<a href=\"$link\">$f1</a>";

    $tabela_nova[$i++] = array($f1, $f2, $f4, $f5, $f6, $f7);
}

# update fields
$tabela_nova[0] = array('nome', 'versao', 't_statis', 'estado', 'data', 'dias_passados');

echo $db->RTable($tabela_nova);

# desenhar form #2
$sql  = "SELECT id, nome FROM pacote ";
$sql .= "WHERE estado = 'Por traduzir' ORDER BY nome";

$tabela = $db->Sql($sql);

# fields are OUT
array_shift($tabela);

echo "<p>Quero traduzir o pacote:</p>\n";

echo "<form method=\"post\" action=\"$pself?op=update\">\n";
echo "<select name=\"pacote\">\n";

foreach($tabela as $pacote) {
    $f1 = $pacote['id'];
    $f2 = $pacote['nome'];
    echo "<option value=\"$f1\">$f2</option>\n";
}

echo "</select><br /><br />\n";
echo "<input type=\"submit\" value=\"executar\" />\n";
echo "</form>\n";

$db->Disconnect();

echo render_file('footer.txt');

?>

