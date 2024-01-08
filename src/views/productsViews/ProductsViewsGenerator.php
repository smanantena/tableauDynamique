<?php
namespace App\Views\ProductsViews;

class ProductsViewsGenerator
{
    public static function filterLink (string $direction, string $linkName, string $activeFilter, ?string $keywords = null) : string
    {
        if (strtolower($activeFilter) === strtolower($linkName)) {
            $classList = "";
        } else {
            $classList = "link-sort-muted";
        }
        if (strtolower($direction) === "asc" && strtolower($activeFilter) === strtolower($linkName)) {
            $direction = "desc" ;
            $classList .= " link-asc";  
        } else {
            $direction = "asc";
            $classList .= " link-desc";  
        }

        $keywordsLink = null;
        
        if (!is_null($keywords)) {
            $keywordsLink = "&keywords={$keywords}";
        }

        return <<<HTML
            <a class="{$classList}" href="/?page=1&sort={$linkName}&dir={$direction}{$keywordsLink}">$linkName</a>
HTML;
    }
}