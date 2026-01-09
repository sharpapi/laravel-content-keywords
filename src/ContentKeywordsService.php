<?php

declare(strict_types=1);

namespace SharpAPI\ContentKeywords;

use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use SharpAPI\Core\Client\SharpApiClient;

/**
 * @api
 */
class ContentKeywordsService extends SharpApiClient
{
    /**
     * Initializes a new instance of the class.
     *
     * @throws InvalidArgumentException if the API key is empty.
     */
    public function __construct()
    {
        parent::__construct(config('sharpapi-content-keywords.api_key'));
        $this->setApiBaseUrl(
            config(
                'sharpapi-content-keywords.base_url',
                'https://sharpapi.com/api/v1'
            )
        );
        $this->setApiJobStatusPollingInterval(
            (int) config(
                'sharpapi-content-keywords.api_job_status_polling_interval',
                5)
        );
        $this->setApiJobStatusPollingWait(
            (int) config(
                'sharpapi-content-keywords.api_job_status_polling_wait',
                180)
        );
        $this->setUserAgent('SharpAPILaravelContentKeywords/1.0.0');
    }

    /**
     * Generates keywords or tags from the provided text.
     * Perfect for generating SEO keywords or content tags.
     *
     * @param string $text The text to generate keywords from
     * @param string|null $language The language for the keywords (optional)
     * @param int|null $maxQuantity Maximum number of keywords to return (optional)
     * @param string|null $voiceTone The tone of voice for the keywords (optional)
     * @param string|null $context Additional context for better keyword generation (optional)
     * @return string The generated keywords or an error message
     *
     * @throws GuzzleException
     *
     * @api
     */
    public function generateKeywords(
        string $text,
        ?string $language = null,
        ?int $maxQuantity = null,
        ?string $voiceTone = null,
        ?string $context = null
    ): string {
        $response = $this->makeRequest(
            'POST',
            '/content/keywords',
            [
                'content' => $text,
                'language' => $language,
                'max_quantity' => $maxQuantity,
                'voice_tone' => $voiceTone,
                'context' => $context,
            ]
        );

        return $this->parseStatusUrl($response);
    }
}