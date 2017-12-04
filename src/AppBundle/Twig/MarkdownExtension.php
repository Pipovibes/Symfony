<?php

namespace AppBundle\Twig;

use AppBundle\Service\MarkdownTransformer;

class MarkdownExtension extends \Twig_Extension
{
    private $markdownTransformer;

    public function __construct(MarkdownTransformer $markdownTransformer)
    {
        $this->markdownTransformer = $markdownTransformer;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('markdownify', array($this,'parseMarkdown'), [
                'is_safe' => ['html']
            ])
        ];
    }

    public function parseMarkdown($str)
    {
        return $this->markdownTransformer->parse($str);
    }

    /**
     * @return string
     * @deprecated since 1.26 (to be removed in 2.0), not used anymore internally
     */
    /*public function getName()
    {
        return 'app_markdown';
    }*/
}