#!/bin/sh

# dados html

PT="/home/users/mferra/pdeb"
PS="$PT/traduz_tabelas.py"

DT="/home/groups/pdeb/htdocs/dados"

if [[ ! -d "$DT" ]] ; then mkdir "$DT" ; fi

for x in $(seq 5)
do
  URL="http://people.debian.org/~seppy/d-i/level$x/pt.txt"

  $PS $URL Outdated > $DT/level$x-outdated.txt
  $PS $URL Translated > $DT/level$x-translated.txt
  $PS $URL Missing > $DT/level$x-missing.txt
done

URL="http://people.debian.org/~seppy/d-i/manual/pt.txt"

$PS $URL Outdated > $DT/manual-outdated.txt
$PS $URL Translated > $DT/manual-translated.txt
$PS $URL Missing > $DT/manual-missing.txt

# dados tabulados

PS="$PT/traduz_tabelas_tabbed.py"

DT="/home/groups/pdeb/htdocs/dados_tabbed"

if [[ ! -d "$DT" ]] ; then mkdir "$DT" ; fi

for x in $(seq 5)
do
  URL="http://people.debian.org/~seppy/d-i/level$x/pt.txt"

  $PS $URL Outdated > $DT/level$x-outdated.txt
  $PS $URL Translated > $DT/level$x-translated.txt
  $PS $URL Missing > $DT/level$x-missing.txt
done

URL="http://people.debian.org/~seppy/d-i/manual/pt.txt"

$PS $URL Outdated > $DT/manual-outdated.txt
$PS $URL Translated > $DT/manual-translated.txt
$PS $URL Missing > $DT/manual-missing.txt

# scheck html

PS="$PT/scheck.py"

DT="/home/groups/pdeb/htdocs/scheck"

if [[ ! -d "$DT" ]] ; then mkdir "$DT" ; fi

for x in $(seq 5)
do
  URL_U="http://d-i.alioth.debian.org/spellcheck/level$x/latest/nozip/pt_unkn_wl.txt"
  URL_C="http://d-i.alioth.debian.org/spellcheck/level$x/latest/nozip/pt_wl.txt"

  $PS $URL_U > $DT/level$x-pt_unkn_wl.txt
  $PS $URL_C > $DT/level$x-pt_wl.txt
done

URL_U="http://d-i.alioth.debian.org/spellcheck/manual_d-i/latest/nozip/pt_unkn_wl.txt"
URL_C="http://d-i.alioth.debian.org/spellcheck/manual_d-i/latest/nozip/pt_wl.txt"

$PS $URL_U > $DT/manual-pt_unkn_wl.txt
$PS $URL_C > $DT/manual-pt_wl.txt

# scheck tabbed

PS="$PT/scheck_tabbed.py"

DT="/home/groups/pdeb/htdocs/scheck_tabbed"

if [[ ! -d "$DT" ]] ; then mkdir "$DT" ; fi

for x in $(seq 5)
do
  URL_U="http://d-i.alioth.debian.org/spellcheck/level$x/latest/nozip/pt_unkn_wl.txt"
  URL_C="http://d-i.alioth.debian.org/spellcheck/level$x/latest/nozip/pt_wl.txt"

  $PS $URL_U > $DT/level$x-pt_unkn_wl.txt
# $PS $URL_C > $DT/level$x-pt_wl.txt
done

URL_U="http://d-i.alioth.debian.org/spellcheck/manual_d-i/latest/nozip/pt_unkn_wl.txt"
URL_C="http://d-i.alioth.debian.org/spellcheck/manual_d-i/latest/nozip/pt_wl.txt"

$PS $URL_U > $DT/manual-pt_unkn_wl.txt
# $PS $URL_C > $DT/manual-pt_wl.txt

# stats

PS="$PT/traduz_stats.py"

DT="/home/groups/pdeb/htdocs/stats"

if [[ ! -d "$DT" ]] ; then mkdir "$DT" ; fi

for x in $(seq 5)
do
  URL="http://people.debian.org/~seppy/d-i/level$x/pt.txt"

  $PS $URL > $DT/level$x-stats.txt

done

# stats tabbed

PS="$PT/traduz_stats_tabbed.py"

DT="/home/groups/pdeb/htdocs/stats_tabbed"

if [[ ! -d "$DT" ]] ; then mkdir "$DT" ; fi

for x in $(seq 5)
do
  URL="http://people.debian.org/~seppy/d-i/level$x/pt.txt"

  $PS $URL > $DT/level$x-stats.txt

done

# ranks

PS="$PT/ranks.py"

DT="/home/groups/pdeb/htdocs/ranks"

if [[ ! -d "$DT" ]] ; then mkdir "$DT" ; fi

for x in $(seq 5)
do
  URL="http://people.debian.org/~seppy/d-i/level$x/rank.txt"

  $PS $URL pt > $DT/level$x-rank.txt

done

# manual

URL="http://people.debian.org/~seppy/d-i/manual/rank.txt"

$PS $URL pt > $DT/manual-rank.txt

# ranks tabbed

PS="$PT/ranks_tabbed.py"

DT="/home/groups/pdeb/htdocs/ranks_tabbed"

if [[ ! -d "$DT" ]] ; then mkdir "$DT" ; fi

for x in $(seq 5)
do
  URL="http://people.debian.org/~seppy/d-i/level$x/rank.txt"

  $PS $URL pt > $DT/level$x-rank.txt

done

# manual

URL="http://people.debian.org/~seppy/d-i/manual/rank.txt"

$PS $URL pt > $DT/manual-rank.txt

# done
