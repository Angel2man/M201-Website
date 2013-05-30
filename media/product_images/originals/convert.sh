#!/bin/bash

mkdir thumbnails
  for f in *.jpg
  do   convert $f -resize 100x100 thumbnails/$f
  done

exit 0
