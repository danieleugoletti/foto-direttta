<?php

namespace App\Http\Controllers;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\Table\TableExtension;


class StaticTextController extends Controller
{

    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke($url)
    {
        abort_unless($page = @file_get_contents(resource_path('static-text').'/'.$url.'.md'), 404);

        $converter = new CommonMarkConverter();
        return view('static-text', [
            'content' => $converter->convertToHtml($page),
        ]);
    }
}
