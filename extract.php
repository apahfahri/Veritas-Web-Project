<?php
$lines = file('found_transcript.json');
foreach($lines as $line) {
    $json = json_decode($line, true);
    if(isset($json['tool_calls'])) {
        foreach($json['tool_calls'] as $call) {
            if($call['name'] == 'replace_file_content' && isset($call['args']['ReplacementContent'])) {
                file_put_contents('recovered_replacement.blade.php', $call['args']['ReplacementContent']);
            }
        }
    }
}
