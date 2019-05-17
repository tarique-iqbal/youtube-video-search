<?php declare(strict_types = 1);

$config = [
    'google_api' => [
        'youtube_data_api_key' => 'dummyKey',
        'youtube_max_results' => 50,
        'youtube_video_url' => 'dummyUrl?v={videoId}',
        'youtube_video_snippet_api_url' => 'dummyApiUrl?'
            . 'part=snippet'
            . '&type=video'
            . '&order=viewCount'
            . '&maxResults={maxResults}'
            . '&q={keyword}'
            . '&key={key}',
        'youtube_video_snippet_pagination_api_url' => 'dummyApiUrl?'
            . 'part=snippet'
            . '&type=video'
            . '&order=viewCount'
            . '&maxResults={maxResults}'
            . '&q={keyword}'
            . '&pageToken={pageToken}'
            . '&key={key}',
        'youtube_video_statistics_api_url' => 'dummyApiUrl?'
            . 'part=statistics'
            . '&id={id}'
            . '&key={key}',
    ],
    'excel_file' => [
        'directory' => 'var/data',
        'name' => 'test_videos.xlsx'
    ],
    'error_log' => [
        'directory' => 'var/logs',
        'file_name' => 'test_errors.log'
    ],
];

return $config;
