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

        if len(slice_line) == 0:
            return 0

        for line in slice_line:
            print line[0] + ' ' +  line[1]

    return 1


if len(sys.argv) == 2:
    stats_scheck(sys.argv[1])

