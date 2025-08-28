<?php
function navLink($page, $label, $lang, $currentPage, $curr)
{
    $href = $page;
    $params = [];

    if ($currentPage === 'detail' && $curr) {
        $params['slug'] = $curr;
    }

    $params['lang'] = $lang;
    $queryString = http_build_query($params);
    $href .= '?' . $queryString;

    return <<<HTML
<a href="{$href}" class="relative text-white/90 hover:text-white transition-all duration-300 group">
    <span class="relative z-10">{$label}</span>
    <div class="absolute -inset-2 bg-gradient-to-r from-blue-500/0 via-purple-500/0 to-pink-500/0 
                group-hover:from-blue-500/20 group-hover:via-purple-500/20 group-hover:to-pink-500/20 
                rounded-lg transition-all duration-300"></div>
</a>
HTML;
}
