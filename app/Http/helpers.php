<?php

function makeImageFromName($name) {
  $shortName = "";
  $names = explode(" ", $name);
  foreach($names as $word) {
    $shortName .= $word[0]; 
  }
  return Str::upper($shortName);
}