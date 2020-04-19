<?php

namespace App\Http\Controllers;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkRenderer;

class StaticTextController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke($url)
    {
        $text = $this->convertMDinHtml($this->readMDText($url));

        return view('static-text', [
            'content' => $text,
        ]);
    }

    /**
     * @param  string $pageName
     * @return string
     */
    private function readMDText($pageName)
    {
        abort_unless($text = @file_get_contents(resource_path('static-text').'/'.$pageName.'.md'), 404);

        return $text;
    }

    /**
     * @param  string $text
     * @return string
     */
    private function convertMDinHtml($text)
    {
        $environment = Environment::createCommonMarkEnvironment();
        $environment->addExtension(new HeadingPermalinkExtension());
        $config = [
            'heading_permalink' => [
                'inner_contents' => '',
            ],
        ];

        $converter = new CommonMarkConverter($config, $environment);
        return $converter->convertToHtml($text);
    }
}
