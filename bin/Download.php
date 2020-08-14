<?php

$url = 'http://kabusapo.com/dl-file/dl-stocklist.php';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$csv = curl_exec($ch);
curl_close($ch);

$csv = str_replace(["\r\n", "\r"], "\n", trim($csv));
$line = explode("\n", $csv);

// 先頭行スキップ
array_shift($line);

$json = [];
foreach ($line as $record) {
    $record = trim($record);
    if (empty($record)) {
        continue;
    }
    $record = explode(',', $record);

    $code = (int)$record[0];
    $json[] = [
        'code' => $code,
        'company_name' => $record[1],
        'market_name' => $record[2],
        'industry_name' => $record[3],
        'nikkei_225' => strlen($record[5]) > 0,
    ];
}

file_put_contents(
    'listed_stocks.json',
    json_encode(
        $json,
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    )
);

file_put_contents(
    'listed_stocks.minify.json',
    json_encode(
        $json
    )
);