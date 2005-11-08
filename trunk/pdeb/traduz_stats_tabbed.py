#!/usr/bin/python

import sys
import urllib
import re

def slice_section(lines):
    slice_line = []

    # extract 3 fields
    p = re.compile(r'([0-9]+t)*([0-9]+f)*([0-9]+u)*')

    for line in lines:
        if 'Statistics of level' in line:
            n = line.split()[3]
        if 'Global statistics: ' in line:
            t = (p.split(line)[1])
            f = (p.split(line)[2])
            u = (p.split(line)[3])
            slice_line.append([n, t, f, u])

    return slice_line


def tabela(url):
    lines = urllib.urlopen(url).readlines()

#    print "<table width=\"100%\" summary=\"tabela\">"

#    print "<colgroup>"
#    print "<col width=\"70%\" />"
#    print "<col width=\"10%\" />"
#    print "<col width=\"10%\" />"
#    print "<col width=\"10%\" />"
#    print "</colgroup>"

#    print "<tr>"
#    print "<td>Level</td>"
#    print "<td>T</td>"
#    print "<td>F</td>"
#    print "<td>U</td>"
#    print "</tr>"

    for line in slice_section(lines):
        print line[0] + '\t' + line[1][0:-1] + '\t' + line[2][0:-1] + '\t' + line[3][0:-1]

#    print "</table>"

if len(sys.argv) == 2:
    tabela(sys.argv[1])

