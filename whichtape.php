<?php
/**
 * For towers of hanoi for backup strategies
 */
function whichTape($backupDate, $tapeCount) {
        static $oneRotation;
        if(!isset($oneRotation)) { $oneRotation = array(); }
        if(!isset($oneRotation[$tapeCount])) {
                $oneRotation[$tapeCount] = getHanoi($tapeCount);
        }
        $days = round(strtotime($backupDate)/86400);
        $index = $days % count($oneRotation[$tapeCount]);
        return $oneRotation[$tapeCount][$index];
}

function getHanoi($elements=4) {
        // init
        $stacks = array();
        for($i=0; $i<pow(2,$elements); $i++) {
                $stacks[$i] = null;
        }

        // fill algorithm
        for($i=0; $i<$elements; $i++) {
                // counter for free places found
                $free = 0;
                // find first free place
                for($j=0; $j<count($stacks); $j++) {
                        if($stacks[$j] === null) {
                                $free++;
                                // fill if applies
                                $every_2nd_gap = $free % 2 === 1;
                                $last_element = $i == $elements-1;
                                $name = chr(65+$i);
                                if($every_2nd_gap) { $stacks[$j] = $name; }
                                if($last_element) { $stacks[$j] = $name; }
                        }
                }
        }
        return $stacks;
}

/**
 * CLI syntax: whichtape.php [<tapeCount>] [<lookahead, 0 means only today>]
 */
$tapeCount = isset($argv[1]) ? $argv[1] : 3;
$lookIntoFutureInDays = isset($argv[2]) ? $argv[2] : 0;
for($o=0; $o <= $lookIntoFutureInDays; $o++) {
  echo whichTape(date('Y-m-d', time()+86400*$o), $tapeCount);
}
