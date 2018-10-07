<?php
require("../PlayersObject.php");
/*
These end up being a visual test in console. 
I'm sure there's a number of php test frameworks available, but I just some basic tests in place before I begin refactoring.
*/

# Test PlayersObject#display
echo "\t======Testing PlayersObject#display=====\n";

$playersObject = new PlayersObject();

echo "\t======Testing displaying from array (cli)=====\n";
$playersObject->display(true, 'array');

echo "\t======Testing displaying from json (cli)=====\n";
$playersObject->display(true, 'json');

echo "\t======Testing displaying from file (cli)=====\n";
$playersObject->display(true, 'file', '../playerdata.json');

echo "\t======Testing displaying from array (html)=====\n";
$playersObject->display(false, 'array');

echo "\t======Testing displaying from json (html)=====\n";
$playersObject->display(false, 'json');

echo "\t======Testing displaying from file (html)=====\n";
$playersObject->display(false, 'file', '../playerdata.json');

# Test PlayersObject#writePlayer
# Note this test doesn't test if the player was written correctly as we can't access the instance vars (private at the moment) that hold player array values. This basically tests that nothing explodes when the variations are called.
echo "\t======Testing PlayersObject#writePlayer=====\n";

$player = new \stdClass();
$player->name = 'New Player';
$player->age = 26;
$player->job = 'Center';
$player->salary = '4.66m';

echo "\t======Testing writing to array=====\n";
$playersObject = new PlayersObject();
$playersObject->writePlayer('array', $player);

echo "\t======Testing writing to json=====\n";
$playersObject = new PlayersObject();
$playersObject->writePlayer('json', $player);

echo "\t======Testing writing to file=====\n";
$playersObject = new PlayersObject();
$playersObject->writePlayer('file', $player, "playersDataTest.json");
// Clear file.
file_put_contents("playersDataTest.json", "");

?>