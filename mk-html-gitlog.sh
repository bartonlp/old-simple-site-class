#!/bin/bash
# !!! You need pandoc: sudo apt-get install pandoc

# Create the simple gitlog
git log --all --graph -p --decorate > ~/www/bartonlp.com/gitlog-simple

# Make .html files from .md files
pagetitle="Main Readme file";
/usr/bin/pandoc -Vpagetitle="$pagetitle" --css=docs/stylesheets/pandoc.css --standalone -f gfm -t html5 README.md -o index.html

# now move into the docs directory and do those html files

cd docs

# Make .html files from .md files
echo "index";
pagetitle="index";
/usr/bin/pandoc -f gfm -t html5 -Vpagetitle="$pagetitle" --css=stylesheets/styles.css --standalone index.md -o index.html
echo "dbTables";
pagetitle="dbTables";
/usr/bin/pandoc -f gfm -t html5 -Vpagetitle="$pagetitle" --css=stylesheets/pandoc.css --standalone dbTables.md -o dbTables.html
echo "simplesiteclass";
pagetitle="SimpleSiteClass Methods";
/usr/bin/pandoc -f gfm -t html5 -Vpagetitle="$pagetitle" --css=stylesheets/pandoc.css --standalone siteclass.md -o siteclass.html
pagetitle="Additional Files";
echo "files";
/usr/bin/pandoc -f gfm -t html5 -Vpagetitle="$pagetitle" --css=stylesheets/pandoc.css --standalone files.md -o files.html
pagetitle="examplereadme";
echo "examplereadme";
/usr/bin/pandoc -f gfm -t html5 -Vpagetitle="$pagetitle" --css=stylesheets/pandoc.css --standalone ../examples/README.md -o examplereadme.html
