#!/usr/bin/python

import sys
import urllib
import re

def cleaner(lista):
    for i in range(len(lista)):
        if lista[i] == None:
            lista[i] = '-'
        else:
            lista[i] = lista[i].strip("[]:* ")

    return lista


def slice_section(lines, section):
    slice_line = []
    ok = 0

    # extract 3 fields
    p = re.compile(r'([0-9]+t)*([0-9]+f)*([0-9]+u)*')

    for line in lines:
        line = line.strip("\t\n ")

        if len(line) == 0:
            ok = 0

        if ok == 1:
            # hack por causa do erro do level 2
            if len(p.split(line)[0]) > 2:
                slice_line.append(cleaner(p.split(line)))

        if section in line:
            ok = 1

    return slice_line


def tabela(url, section):
    lines = urllib.urlopen(url).readlines()

    print "<table width=\"100%\" summary=\"tabela\">"

    print "<colgroup>"
    print "<col width=\"70%\" />"
    print "<col width=\"04%\" />"
    print "<col width=\"04%\" />"
    print "<col width=\"04%\" />"
    print "<col width=\"18%\" />"
    print "</colgroup>"

    print "<tr>"
    print "<td>Ficheiro</td>"
    print "<td>T</td>"
    print "<td>F</td>"
    print "<td>U</td>"
    print "<td>Tradutor</td>"
    print "</tr>"

    t = 0
    f = 0
    u = 0

    for line in slice_section(lines, section):
        i = 0
        print "<tr>"
        for col in line:
	    conteudo = col.decode("utf-8").encode("iso-8859-1")
	    if conteudo != '-':
	        if i == 1:
	            t = t + int(conteudo[0:-1])
                if i == 2:
	            f = f + int(conteudo[0:-1])
                if i == 3:
	            u = u + int(conteudo[0:-1])
            print "<td>" + conteudo + "</td>"
	    i = i + 1
        print "</tr>"

    print "<tr>\n"
    print "<td class=\"total\">Total</td>"
    print "<td class=\"total\">" + str(t) + "t</td>"
    print "<td class=\"total\">" + str(f) + "f</td>"
    print "<td class=\"total\">" + str(u) + "u</td>"
    print "<td class=\"total\">-</td>"
    print "</tr>\n"

    print "</table>"


if len(sys.argv) == 3:
    tabela(sys.argv[1], sys.argv[2])

