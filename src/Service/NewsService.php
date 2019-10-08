<?php

namespace App\Service;

use App\Entity\NewsPost;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class NewsService
 * @package App\Service
 */
abstract class NewsService implements NewsServiceInterface
{
    /** @var string */
    protected $source;
    /** @var HttpClientInterface */
    protected $client;
    /** @var DecoderInterface */
    protected $encoder;

    /**
     * NewsService constructor.
     * @param HttpClientInterface $client
     * @param DecoderInterface $encoder
     * @param string $source
     */
    public function __construct(HttpClientInterface $client, DecoderInterface $encoder, string $source)
    {
        $this->source = $source;
        $this->client = $client;
        $this->encoder = $encoder;
    }

    /**
     * @return string|null
     */
    public function receive(): ?string
    {
        try {
            return $this->client->request('GET', $this->source)->getContent();
        } catch (ExceptionInterface $e) {
            throw new ResourceNotFoundException('Unable to load data from external source');
        }
    }

    /**
     * @param $data
     * @return array
     */
    public function parse($data): array
    {
        $items = $this->encoder->decode($data, 'xml');
        $news = [];
        foreach ($items['channel']['item'] as $item) {
            $news[] = new NewsPost([
                'title' => $this->getTitle($item),
                'date' => $this->getDate($item),
                'text' => $this->getText($item),
                'link' => array_key_exists('link', $item) ? $item['link'] : '',
                'image' => array_key_exists('enclosure', $item) ? $item['enclosure']['@url'] : '',
                'source' => $this->source,
            ]);
        }

        return $news;
    }

    /**
     * @return array
     */
    public static function getLinks(): array
    {
        return [
            'Lenta.ru' => LentaNewsService::LINKS,
            'Yandex News' => YandexNewsService::LINKS,
            'Vedomosti' => VedomostiNewsService::LINKS,
        ];
    }
}
