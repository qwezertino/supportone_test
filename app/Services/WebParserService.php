<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WebParserService
{
    protected $httpClient;

    public function __construct(Http $httpClient)
    {
        $this->httpClient = $httpClient;
    }
    public function parseJson($url)
    {
        try {
            $response = $this->httpClient::get($url);
            if ($response->successful()) {
                return $response->json();
            } else {
                throw new \Exception('Failed to fetch content from ' . $url);
            }
        } catch (\Exception $e) {
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }
    public function parseWebpage($url)
    {
        try {
            $response = $this->httpClient::get($url);

            if ($response->successful()) {
                $html = $response->body();

                $links = $this->parseLinks($html);
                $images = $this->parseImages($html);

                return [
                    'links' => $links,
                    'images' => $images
                ];
            } else {
                throw new \Exception('Failed to fetch content from ' . $url);
            }
        } catch (\Exception $e) {
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }

    private function parseLinks($html)
    {
        $links = [];
        preg_match_all('/<a\s+.*?href=[\'"](.*?)[\'"].*?>/i', $html, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $url) {
                if (strpos($url, '#') === false && (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0)) {
                    $links[] = $url;
                }
            }
        }
        return $links;
    }

    private function parseImages($html)
    {
        $images = [];
        preg_match_all('/<img\s+.*?src=[\'"](.*?)[\'"].*?>/i', $html, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $src) {
                $images[] = $src;
            }
        }
        return $images;
    }
}
