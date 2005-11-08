#!/usr/bin/python

import debconf_parser

# utils

def lista2sql(lista):
    res = '('
    for x in lista:
        res = '%s%s, ' % (res, x)

    return res[0:-2] + ')'


def escrever_sql(tipo):
    result_final = debconf_parser.parse_unstable()

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

        # sql

        f1 = '\'' + nome + '\''
        f2 = '\'' + vers + '\''
        f3 = '\'' + t_statis + '\''
        f4 = '\'' + t_file_l + '\''
        f5 = '\'' + i_statis + '\''
        f6 = '\'' + i_file_l + '\''
        f7 = '\'' + i_pessoa + '\''
        f8 = '\'' + i_equipa + '\''

        # pseudo-estados

        e1 = '\'Por traduzir\''
        e2 = '\'A ser traduzido\''
        e3 = '\'OK\''

        # especial

        c1 = 'NULL'

        # criar BD (ou inserir novos com warnings)

        if tipo == 0:
            fs1 = ['nome', 'versao', 't_statis', 't_file_l', 'i_statis', 'i_file_l', 'i_pessoa', 'i_equipa', 'estado', 'data']
            vs1 = [f1, f2, f3, f4, f5, f6, f7, f8, e1, c1]

            print 'insert delayed into pacote %s values %s;' % (lista2sql(fs1), lista2sql(vs1))

        # upd. versao

        if tipo == 1:
            print 'update pacote set versao = %s, t_statis = %s, t_file_l = %s, i_statis = %s, \
                                                  i_file_l = %s, i_pessoa = %s, i_equipa = %s \
                                                  where nome = %s and versao != %s;' % (f2, f3, f4, f5, f6, f7, f8, f1, f2)
    # marcar
    if tipo == 2:
        print 'update pacote set estado = %s where estado = %s and i_file_l != \'\';' % (e3, e2)

    return 1

# run

escrever_sql(0)
escrever_sql(1)
escrever_sql(2)
