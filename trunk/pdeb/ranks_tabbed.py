#!/usr/bin/python

import sys
import urllib
import re

def tabela(url, pais):
    lines = urllib.urlopen(url).readlines()

    percent = 0

    for x in lines:
        if '%' in x:
            fatia = x.split()
            if pais in fatia:
                if '%' in fatia[0]:
                    percent = fatia[0]
                else:
                    percent = fatia[1]

    for x in lines:
        if '%' in x:
            fatia = x.split()
            if fatia[1] == percent:
                if lines[0].split()[3] == 'po':
                  nivel = 'manual'
                else:
                  nivel = lines[0].split()[3]
                print nivel + "\t" + fatia[0] + "\t" + fatia[1]

if len(sys.argv) == 3:
    tabela(sys.argv[1], sys.argv[2])


