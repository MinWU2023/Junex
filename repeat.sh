#!/bin/bash

mkdir app/Repeats
mkdir app/Repeats/Controllers
mkdir app/Repeats/Models
mkdir app/Repeats/views

cp -r stub/repeats/*  app/Repeats/


find app/Repeats/Controllers/* -name *.stub  | while read i
do
     new=`echo $i | sed "s/\.stub/\.php/"`
        mv $i $new
done


find app/Repeats/Models/* -name *.stub  | while read i
do
     new=`echo $i | sed "s/\.stub/\.php/"`
        mv $i $new
done

cp stub/routes/repeat.php routes/repeat.php
