<?php declare(strict_types=1);

$config = [
    'google_api' => [
        'youtube_data_api_key' => 'REPLACE-ME',
        'youtube_max_results' => 50,
        'youtube_video_url' => 'https://www.youtube.com/watch?v={videoId}',
        'youtube_video_snippet_api_url' => 'https://www.googleapis.com/youtube/v3/search?'
            . 'part=snippet'
            . '&type=video'
            . '&order=viewCount'
            . '&maxResults={maxResults}'
            . '&q={keyword}'
            . '&key={key}',
        'youtube_video_snippet_pagination_api_url' => 'https://www.googleapis.com/youtube/v3/search?'
            . 'part=snippet'
            . '&type=video'
            . '&order=viewCount'
            . '&maxResults={maxResults}'
            . '&q={keyword}'
            . '&pageToken={pageToken}'
            . '&key={key}',
        'youtube_video_statistics_api_url' => 'https://www.googleapis.com/youtube/v3/videos?'
            . 'part=statistics'
            . '&id={id}'
            . '&key={key}',
    ],
    'excel_file' => [
        'directory' => 'var/data',
        'name' => 'youtube_videos.xlsx'
    ],
    'error_log' => [
        'directory' => 'var/logs',
        'file_name' => 'errors.log'
    ],
];

return $config;
