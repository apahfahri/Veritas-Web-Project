<?php
$file = 'C:/Users/ASUS/.gemini/antigravity/brain/4ae9a600-1865-42a6-8558-0b848fd9588d/.system_generated/logs/transcript_full.jsonl';
$lines = file($file);
$found = [];
foreach($lines as $line) {
    if(strpos($line, 'resources\\\\views\\\\subadmin\\\\pendaftaran\\\\show.blade.php') !== false) {
        if(strpos($line, 'multi_replace_file_content') !== false || strpos($line, 'replace_file_content') !== false) {
            $found[] = $line;
        }
    }
}
file_put_contents('found_transcript.json', implode("\n", $found));
