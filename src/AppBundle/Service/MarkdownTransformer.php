<?php

namespace AppBundle\Service;

use Doctrine\Common\Cache\Cache;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

/**
 * Class MarkdownTransformer
 * @package AppBundle\Service
 */
class MarkdownTransformer
{
    private $markdownParser;
    private $cache;

    /**
     * MarkdownTransformer constructor.
     * @param MarkdownParserInterface $markdownParser
     * @param Cache $cache
     */
    public function __construct(MarkdownParserInterface $markdownParser, Cache $cache)
    {
        $this->markdownParser = $markdownParser;
        $this->cache = $cache;
    }

    /**
     * @param $str
     * @return string
     */
    public function parse($str)
    {
        $cache = $this->cache;
        $key = md5($str);
        if($cache->contains($key)){
            $str = $cache->fetch($key);
        }

        sleep(1);
        $str = $this->markdownParser->transformMarkdown($str);
        $cache->save($key, $str);

        return $str;
    }
}