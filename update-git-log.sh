#!/usr/bin/bash
# This should be run after every commit and definetly before a push.

git log --all --graph -p --decorate > ~/www/bartonlp.com/gitlog-simple
