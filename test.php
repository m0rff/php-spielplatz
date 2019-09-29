<?php
include('MaxSquareFinder.php');

$finder = new MaxSquareFinder();

$finder->setSquare([
    '1000',
    '0100',
]);


var_dump($finder->findLargestSquare(););