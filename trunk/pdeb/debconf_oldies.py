#!/usr/bin/python

import sys
import debconf_parser

def lista_nova():
    result_final = debconf_parser.parse_unstable()

    lista = []

    for pacote in result_final:
        nome = pacote[0][0]
        vers = pacote[0][1]

        t_file_s = pacote[1][0]
        t_idioma = pacote[1][1]
        t_statis = pacote[1][2]
        t_file_l = pacote[1][3]

        i_file_s = ''
        i_idioma = ''
        i_statis = ''
        i_file_l = ''
        i_pessoa = ''
        i_equipa = ''

        if len(pacote) == 3:
            i_file_s = pacote[2][0]
            i_idioma = pacote[2][1]
            i_statis = pacote[2][2]
            i_file_l = pacote[2][3]

            if len(pacote[2]) > 4:
                i_pessoa = pacote[2][4]
            if len(pacote[2]) > 5:
                i_equipa = pacote[2][5]

        lista.append(['null', nome, vers, t_statis, t_file_l, i_statis, i_file_l, i_pessoa, i_equipa, 'null', 'null'])

    return lista


def lista_antiga():
    lista = []

    for x in sys.stdin.readlines():
        lista.append(x.strip().split('\t'))

    return lista


def cruzar():
    l1 = lista_antiga()
    l2 = lista_nova()

    lista = []

    for c1 in l1:
        found = 0
        for c2 in l2:
            if c1[1] == c2[1]:
                found = 1

        if found == 0:
            lista.append(c1)

    return lista


def sql_delete():
    obsoletos = cruzar()
    for x in obsoletos:
        print 'delete from pacote where nome = \'' + x[1] + '\'' + ';'

sql_delete()
