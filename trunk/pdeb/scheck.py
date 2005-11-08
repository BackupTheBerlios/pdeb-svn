#!/usr/bin/python

import sys
import urllib

def stats_scheck(url):
    u = urllib.urlopen(url)

    if 'text/plain' in u.info().getheader('Content-Type'):
        slice_line = []

        for line in u.readlines():
            try:
                linha = line.decode("utf-8").encode("iso-8859-1").split()
                if len(linha) == 2:
                    slice_line.append(linha)
            except UnicodeError:
                pass

        i = 0

        if len(slice_line) == 0:
            return 0

        print "<table width=\"100%\" summary=\"tabela\">"

        print "<tr>"
        for x in range(5):
            print "<td>O</td>"
	    print "<td>P</td>"
        print "</tr>"

        for line in slice_line:
	    if i == 0:
                print "<tr>"

            i = i + 1

            print "<td>" + line[0] + "</td>"
            print "<td>" + line[1] + "</td>"

            if i == 5:
                print "</tr>"
                i = 0

        if i < 5:
            for x in range(5 - i):
                print "<td>-</td>"
                print "<td>-</td>"
            print "</tr>"

        print "</table>"

    return 1

if len(sys.argv) == 2:
    stats_scheck(sys.argv[1])

