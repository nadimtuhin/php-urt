<?php
require __DIR__.'/../functions.php';

$failures = 0;

function check($label, $expected, $actual){
    global $failures;
    if ($expected === $actual) {
        echo "ok   - {$label}\n";
        return;
    }
    $failures++;
    echo "FAIL - {$label}\n  expected: ".var_export($expected, true)."\n  actual:   ".var_export($actual, true)."\n";
}

$raw = [
    "\377\377\377\377statusResponse",
    "\\mapname\\ut4_turnpike\\sv_maxclients\\16",
    '5 48 "Big Boss"',
    '3 120 "Solo"',
    '',
];

$players = array_values(parsePlayers($raw));
check('player name keeps spaces and drops quotes', 'Big Boss', $players[0]['name']);
check('single-word name drops quotes', 'Solo', $players[1]['name']);
check('ping and score are parsed', ['ping' => '48', 'score' => '5'], ['ping' => $players[0]['ping'], 'score' => $players[0]['score']]);

check('info is parsed into key/value pairs', ['mapname' => 'ut4_turnpike', 'sv_maxclients' => '16'], parseInfo($raw));

$start = microtime(true);
try {
    createUdpSocketConnection('not-an-ip', 27960, 1);
    $result = 'no exception';
} catch (\Exception $e) {
    $result = 'exception';
}
check('connect error throws instead of looping', 'exception', $result);
check('connect error returns quickly', true, microtime(true) - $start < 3);

echo $failures ? "\n{$failures} failure(s)\n" : "\nall passed\n";
exit($failures ? 1 : 0);
