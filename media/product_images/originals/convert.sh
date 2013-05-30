#!/bin/bash

mkdir thumbnails
  for f in *.jpg
  do   convert $f -resize 100x100 thumbnails/$f.jpg
  done

exit 0
