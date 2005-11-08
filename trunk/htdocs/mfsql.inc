<?php

class Database {
    var $DBname, $DBuser, $DBpass, $DBhost;
    var $DBlink, $Result;

    function Database($name, $user, $pass, $host) {
        $this->DBname = $name;
        $this->DBuser = $user;
        $this->DBpass = $pass;
        $this->DBhost = $host;

        if ($this->DBlink = mysql_connect($host, $user, $pass)) {
            if (mysql_select_db($name, $this->DBlink)) {
                return true;
            }
        }
        return false;
    }

    function Disconnect() {
        return mysql_close($this->DBlink);
    }

    function Sql($sql) {
        if ($this->Result = mysql_query($sql, $this->DBlink)) {
            if ($this->Result == 1) {
                return 1;
            }
            $dados = array();
            for ($i = 0; $line = mysql_fetch_field($this->Result); $i++) {
                $dados[0][$i] = $line->name;
            }
            for ($i = 1; $line = mysql_fetch_assoc($this->Result); $i++) {
                $dados[$i] = $line;
            }
            mysql_free_result($this->Result);
            return $dados;
        }
        return false;
    }

    function RTable($tabela) {
        $table = "<table>\n";

        foreach($tabela as $line) {
            $table .= "<tr>\n";
            foreach($line as $coluna) {
                $table .= "<td>$coluna</td>\n";
            }
            $table .= "</tr>\n";
        }
        $table .= "</table>\n";
        return $table;
    }
}

?>

