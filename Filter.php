<?php

namespace Tale\Jade;

use Tale\Jade\Parser\Node;

/**
 * Class Filter
 * @package Tale\Jade
 */
class Filter
{

    /**
     * @param $tag
     * @param Node $node
     * @param $indent
     * @param $newLine
     * @return string
     */
    public static function wrapTag($tag, Node $node, $indent, $newLine)
    {

        return "<$tag>".$newLine.self::filterPlain($node, $indent, $newLine).$indent."</$tag>".$newLine;
    }

    /**
     * @param Node $node
     * @param $indent
     * @param $newLine
     * @return string
     */
    public static function wrapCode(Node $node, $indent, $newLine)
    {

        $strlen = function_exists('mb_strlen') ? 'mb_strlen' : 'strlen';
        $text = self::filterPlain($node, $indent, $newLine);

        $text = preg_replace(['/^\s*<\?php ?/i', '/\?>\s*$/'], '', $text);

        return $indent.'<?php '.$newLine.$text.$newLine.$indent.'?>'.$newLine;
    }


    /**
     * @param Node $node
     * @param $indent
     * @param $newLine
     * @return string
     */
    public static function filterPlain(Node $node, $indent, $newLine)
    {

        $text = trim($node->text());

        //Normalize newlines to $newLine and append our indent
        $i = 0;
        return implode($newLine, array_map(function($value) use($indent, $newLine, &$i) {

            if (strlen($indent) < 1 && $i++ !== 0&& strlen($value) > 0) {

                //Make sure we separate with at least one white-space
                $indent = ' ';
            }

            return $indent.trim($value);
        }, explode("\n", $text)));
    }

    /**
     * @param Node $node
     * @param $indent
     * @param $newLine
     * @return string
     */
    public static function filterStyle(Node $node, $indent, $newLine)
    {

        return self::wrapTag('style', $node, $indent, $newLine);
    }

    /**
     * @param Node $node
     * @param $indent
     * @param $newLine
     * @return string
     */
    public static function filterScript(Node $node, $indent, $newLine)
    {

        return self::wrapTag('script', $node, $indent, $newLine);
    }

    /**
     * @param Node $node
     * @param $indent
     * @param $newLine
     * @return string
     */
    public static function filterCode(Node $node, $indent, $newLine)
    {

        return self::wrapCode($node, $indent, $newLine);
    }

    /**
     * @param Node $node
     * @param $indent
     * @param $newLine
     * @return string
     */
    public static function filterMarkdown(Node $node, $indent, $newLine)
    {

        return self::wrapTag('markdown', $node, $indent, $newLine);
    }
}