<?php

/****************************** [ FUNCTIONS.php ] ******************************
 * h1-h6( $title, $style )                              - заголовки
 * heading( $size, $title, $vars )                      - заголовки
 *                                                        $vars = ['class' => (string|array), 'style' => (string|array)]
 * t( $tag, $content )                                  - тег + контент
 * pre( $content )                                      - генерация контента с сохранением отступов и переносов
 *                                                        массивы генерируются с подсветкой
 * xmp( $content )                                      - генерация кода "как есть", без интерпретации HTML
 * spoiler ( [$title,] $content, [$is_opened = false] ) - details-summary конструкция для скрытия контента
 * table ($array)                                       - генерация двумерных массивов (ужасная, непрофессиональная)
 *
 * Каждая функция для вывода требует => echo
 * Например: echo spoiler(h1('Заголовок') . pre($code));
*/
include 'functions.php';
