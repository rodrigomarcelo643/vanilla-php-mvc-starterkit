<?php

function dd($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function github_stars(string $repo): string
{
    static $cache = [];
    if (isset($cache[$repo])) return $cache[$repo];

    $url     = 'https://api.github.com/repos/' . $repo;
    $token   = $_ENV['GITHUB_TOKEN'] ?? '';
    $headers = ['User-Agent: PHP'];
    if ($token) $headers[] = 'Authorization: Bearer ' . $token;
    $data    = null;

    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 3,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        if ($response) $data = json_decode($response, true);
    }

    if (!$data) {
        $ctx = stream_context_create(['http' => [
            'timeout' => 3,
            'header'  => implode("\r\n", $headers),
        ]]);
        $response = @file_get_contents($url, false, $ctx);
        if ($response) $data = json_decode($response, true);
    }

    $count  = $data['stargazers_count'] ?? null;
    $result = $count !== null
        ? ($count >= 1000 ? round($count / 1000, 1) . 'k' : (string) $count)
        : '0';

    return $cache[$repo] = $result;
}