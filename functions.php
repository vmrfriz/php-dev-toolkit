<?php

echo head();

/* =========== FUNCTIONS ===========
    head()                                      стили, bootstrap, favicon
    t($tag, $content)                           <tag> content </tag>
    pre($content)                               <pre> content </pre>
    xmp($code)                                  <xml> code </xml>
    spoiler([$title], $content, [$is_opened])   <details> <summary>title</summary> content </details>
*/

function head() {
    return <<<EOF
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="http://promtrans.pro/cargo/classes/favicon.ico" type="image/x-icon">

    <title>DEV</title>

    <style>
        * { box-sizing: border-box; }
        html { background-color: #222; color: #fff; font-family: Calibri, sans-serif; }
        body { margin: 0 auto; width: 100%; max-width: 960px; min-width: 300px; box-shadow: 0 0 30px rgba(50,50,50,.3); padding: 10px 25px; border-left: 1px solid #333; border-right: 1px solid #333; }
        span { color: #b70; }
        h1, h2, h3 { font-weight: 900; text-transform: uppercase; color: #f55; margin-left: -10px; }
        table { width: 100% }
        table th { background-color: rgba(255,255,255,.1) }
        td, th { text-align: left; padding: 5px 10px }
        thead > tr > td:first-child, tr > th:first-child { border-radius: 10px 0 0 10px }
        thead > tr > td:last-child, tr > th:last-child { border-radius: 0 10px 10px 0 }
        a { color: #aaf; white-space: nowrap }
        [id]:target { background-color: rgba(255,200,0,.2) }
        summary { background-color: #333; box-shadow: 0 0 15px rgba(100,100,100,.1); padding: 10px 20px; border-radius: 5px; cursor: pointer; margin: 0 -29px 25px }
        details { background-color: #272727; border-left: 4px solid #333; border-radius: 5px; padding: 0 25px }
        .mb-0 { margin-bottom: 0px }
        .mb-1 { margin-bottom: 20px }
        .mb-2 { margin-bottom: 40px }
        .mb-3 { margin-bottom: 80px }
        .mb-4 { margin-bottom: 160px }
    </style>
</head>
EOF;
}

function h1($title, $style = null) { return heading(1, $title, $style); }
function h2($title, $style = null) { return heading(2, $title, $style); }
function h3($title, $style = null) { return heading(3, $title, $style); }
function h4($title, $style = null) { return heading(4, $title, $style); }
function h5($title, $style = null) { return heading(5, $title, $style); }
function h6($title, $style = null) { return heading(6, $title, $style); }
function heading($size, $title, $vars = []) {
    if ($size < 1 || $size > 6) throw Error('Неверное значение заголовка <h[1-6]> в функции heading($size, $title, $style)');
    $style = null;
    $class = null;

    if ($vars['style']) {
        if (gettype($vars['style']) == 'array') {
            $style = implode('; ', $vars['style']);
        } else if (gettype($vars['style']) != 'string') {
            throw Error('Ожидалась строка или массив, а передано ' . gettype($vars['style']) . ' в heading(...)');
        }
        $style = " style=\"{$style}\"";
    }

    if ($vars['class']) {
        if (gettype($vars['class']) == 'array') {
            $style = implode('; ', $vars['class']);
        } else if (gettype($vars['style']) != 'string') {
            throw Error('Ожидалась строка или массив, а передано ' . gettype($style) . ' в heading(...)');
        }
        $class = " style=\"{$class}\"";
    }

    return "<h{$size}{$class}{$style}>{$title}</h{$size}>";
}

function t($tag, $content) {
    return "<{$tag}>{$content}</{$tag}>";
}

function pre($content) {
    if (gettype($content) != 'string') {
        $content = '<div style="color: #ca9">' .
            preg_replace(
                ['/\[(.+)]/i', '/ => (?!Array)(.+)/i'],
                ['[<span>$1</span>]', ' => <span style="color:#fff">$1</span>'],
                print_r($content, true)
            ) .
            '</div>';
    }
    return "<pre>{$content}</pre>";
}

function xmp($code) {
    return "<xmp>{$code}</xmp>";
}

function spoiler($title, $content = null, $is_opened = false) {
    $args_count = func_num_args();

    switch ($args_count) {
        case 1:
            $content = $title;
            $title = null;
            break;
        case 2:
            if (is_bool($content)) {
                $is_opened = $content;
                $content = $title;
                $title = null;
            }
    }

    $opened = ($is_opened ? ' open="open"' : '');
    return "<details{$opened}>" . ($title ? "<summary>{$title}</summary>" : '') . $content . "</details>";
}

function table($array) {
    $html = '<table>';

    // for ($row = 0; $row < count($array); $row++) {
    foreach ($array as $row) {
        // $html .= "\t<tr data-index=\"{$row}\">\n";
        $html .= "\t<tr>\n";

        // for ($cell = 0; $cell < count($array[$row]); $cell++) {
        foreach ($row as $cell) {
            // if (in_array(gettype($array[$row][$cell]), ['string', 'double', 'integer'])) {
            if (in_array(gettype($cell), ['string', 'double', 'integer'])) {
                // $array[$row][$cell] = str_replace(["\n", '\n', '\\'], '<br>', $array[$row][$cell]);
                $cell = str_replace(["\n", '\n', '\\'], '<br>', $cell);
                // switch ($array[$row][$cell][0]) {
                switch ($cell[0]) {
                    case '!':
                        // $html .= t('th', substr($array[$row][$cell], 1));
                        $html .= t('th', substr($cell, 1));
                        break;
                    case '^':
                        // $html .= t('td', eval(substr($array[$row][$cell], 1)));
                        $html .= t('td', eval(substr($cell, 1)));
                        break;
                    default:
                        // $html .= t('td', $array[$row][$cell]);
                        $html .= t('td', $cell);
                        break;
                }
            // } else if (gettype($array[$row][$cell]) == 'NULL') {
            } else if (gettype($cell) == 'NULL') {
                $html .= '<td></td>';
            } else {
                // $html .= '<td><span style="color:red"><b>Data type:</b> ' . gettype($array[$row][$cell]) . '</span><br>'. print_r($array[$row][$cell], true) .'</td>';
                $html .= '<td><span style="color:red"><b>Data type:</b> ' . gettype($cell) . '</span><br>'. print_r($cell, true) .'</td>';
            }
        }

        $html .= '</tr>';
    }

    $html .= '</table>';

    return $html;
}