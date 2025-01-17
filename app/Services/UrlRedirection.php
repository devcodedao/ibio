<?php

namespace App\Services;

use App\Models\Urls;
use Illuminate\Http\RedirectResponse;

class UrlRedirection
{
    /**
     * Execute the HTTP redirect and return the redirect response.
     *
     * @param Url $url \App\Models\Url
     */
    public function execute(Urls $url): RedirectResponse
    {
        $statusCode = (int) config('urls.redirect_status_code');
        $maxAge = (int) config('urls.redirect_cache_max_age');
        $headers = [
            'Cache-Control' => sprintf('private,max-age=%s', $maxAge),
        ];

        return redirect()->away($url->destination, $statusCode, $headers);
    }
}
