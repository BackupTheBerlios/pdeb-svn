<?php

require('mfsql.inc');

function render_file($file) {
    $x = file($file);
    foreach($x as $line) {
        $res .= $line;
    }
    return $res;
}

# header.txt
echo render_file('header.txt');

echo "<h2>Processo: debconf</h2>\n";

echo "<p>Os dados destas tabelas sao actualizados automatica e periodicamente todos os dias pares às 8h22</p>\n";

$pself = $_SERVER[PHP_SELF];

if ($_GET['op'] == 'update') {
    $id = $_POST['pacote'];
    $data = date("Y-m-d");

    $sql  = "UPDATE pacote SET estado = 'A ser traduzido', data = '$data' ";
    $sql .= "WHERE id = '$id'";

    $db->Sql($sql);
}

echo "<div>\n";

echo "<form method=\"post\" action=\"$pself\">";

echo 'SELECT * FROM pacote WHERE estado = <select name="estado">';
echo '<option value="Por traduzir">Por traduzir</option>';
echo '<option value="A ser traduzido">A ser traduzido</option>';
echo '<option value="OK">Traduzido</option>';

echo '</select> ORDER BY <select name="order">';

echo '<option value="nome">nome</option>';
echo '<option value="versao">versao</option>';
echo '<option value="t_statis">t_statis</option>';
echo '<option value="estado">estado</option>';
echo '<option value="data">data</option>';
echo '<option value="dias_passados">dias_passados</option>';

echo '</select> <select name="sentido">';

echo '<option value="ASC">ASC</option>';
echo '<option value="DESC">DESC</option>';
echo '</select> ; <br /><br />';

echo '<input type="submit" value="executar" />';
echo '</form>';

echo "</div>\n";

$f1 = $_POST['estado'];
$f2 = $_POST['order'];
$f3 = $_POST['sentido'];

$sql  = 'SELECT nome, versao, t_file_l, t_statis, estado, data, ';
$sql .= '(to_days(curdate()) - to_days(data)) AS dias_passados FROM pacote ';

if (isset($_POST['estado'])) {
    $sql .= "WHERE estado = '$f1' ORDER BY $f2 $f3";
} else {
    $sql .= "WHERE id = '0'";
}

$db = new Database('mferra', 'mferra', 'Peipae5l', 'localhost');

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

# footer.txt
echo render_file('footer.txt');

?>

