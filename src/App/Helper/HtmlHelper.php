<?php

namespace App\Helper;

class HtmlHelper
{
    public static function removeImageTagFromString($text)
    {
        return preg_replace("/<img[^>]+\>/i", '', $text);
    }
}