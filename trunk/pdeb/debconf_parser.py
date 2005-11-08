#!/usr/bin/python

def parse_pacotes():
    pac = []
    res = []

    f = open('unstable')

    for x in f.readlines():
        if '\n' == x:
            res.append(pac)
            pac = []
        else:
            pac.append(x)

    f.close()
    return res


def slice_debconf(pacote):
    res = []
    zona = 0

    for line in pacote:
        if zona == 1:
            if '!' in line:
                res.append(line)
            else:
                zona = 0

        if 'PODEBCONF:\n' == line:
            zona = 1

    return res


def list_strip(lista):
    res = []

    for x in lista:
        res.append(x.strip())

    return res


def parse_unstable():

    res = parse_pacotes()
    result_final = []

    for pacote in res:
        debconf = slice_debconf(pacote)

        if len(debconf) > 0:
            pacote_final = []

            nome = pacote[0].split()[1]
            vers = pacote[1].split()[1]
            pdir = pacote[5].split()[1]

            pacote_final.append([nome, vers, pdir])

            for line in debconf:
                fatia = list_strip(line.split('!'))

                file_s = fatia[0]
                idioma = fatia[1]
                statis = fatia[2]
                file_l = fatia[3]
                pessoa = ''
                equipa = ''

                if len(fatia) == 5:
                    pessoa = fatia[4]
                if len(fatia) == 6:
                    equipa = fatia[5]

                if file_s == 'templates.pot':
                    pacote_final.append(fatia)

                if idioma == 'pt':
                    pacote_final.append(fatia)

            result_final.append(pacote_final)

    return result_final

# EOF
