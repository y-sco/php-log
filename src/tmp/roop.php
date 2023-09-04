<?php

$correncies = [
  'japan' => 'yen',
  'us' => 'dollar',
  'england' => 'pond',
];

foreach ($correncies as $country => $currency) {
  echo $country . ':' . $currency . PHP_EOL;
}
