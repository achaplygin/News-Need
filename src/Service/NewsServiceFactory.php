<?php

namespace App\Service;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NewsServiceFactory
{
    /** @var HttpClientInterface */
    private $client;

    /** @var DecoderInterface */
    private $encoder;

    public function __construct(HttpClientInterface $client, DecoderInterface $encoder)
    {
        $this->client = $client;
        $this->encoder = $encoder;
    }

    public function create(string $link): NewsServiceInterface
    {
        if (in_array($link, LentaNewsService::LINKS, true)) {
            return new LentaNewsService($this->client, $this->encoder, $link);
        }

        if (in_array($link, YandexNewsService::LINKS, true)) {
            return new YandexNewsService($this->client, $this->encoder, $link);
        }

        if (in_array($link, VedomostiNewsService::LINKS, true)) {
            return new VedomostiNewsService($this->client, $this->encoder, $link);
        }

        throw new NotFoundHttpException();
    }
}
