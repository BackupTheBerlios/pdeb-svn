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

#   print "Ficheiro\tT\tF\tU\tTradutor"

    for line in slice_section(lines, section):
        coluna = ''
        for col in line:
            coluna = coluna + col + '\t'
        print coluna.decode("utf-8").encode("iso-8859-1")

if len(sys.argv) == 3:
    tabela(sys.argv[1], sys.argv[2])

