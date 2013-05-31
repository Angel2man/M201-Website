#!/bin/bash

mkdir thumbnails
  for f in *.jpg
  do   convert $f -resize 100x100 thumbnails/$f
  done

mkdir images
  for f in *.jpg
  do   convert $f -resize 200x200 images/$f
  done

exit 0
