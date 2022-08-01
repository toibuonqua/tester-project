<?php

namespace App\Common;

class ExtractList
{
    static function transformList($iterable, $contentExtract)
    {
        $contentList = [];
        foreach ($iterable as $item) {
            $contentList[] = $item[$contentExtract];
        }
        return $contentList;
    }
}
