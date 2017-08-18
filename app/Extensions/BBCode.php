<?php

namespace App\Extensions;
/**
 * BBCode to HTML converter
 *
 * Created by Kai Mallea (kmallea@gmail.com)
 *
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 */
class BBCode {
    protected static $bbcode_table = array();

    public function __construct () {
        if(count(self::$bbcode_table) > 0)
            return;
        
        // Replace [b]...[/b] with <strong>...</strong>
        self::$bbcode_table["/\[b\](.*?)\[\/b\]/is"] = function ($match) {
            return "<strong>$match[1]</strong>";
        };
        // Replace [i]...[/i] with <em>...</em>
        self::$bbcode_table["/\[i\](.*?)\[\/i\]/is"] = function ($match) {
            return "<em>$match[1]</em>";
        };
        // Replace [code]...[/code] with <pre><code>...</code></pre>
        self::$bbcode_table["/\[code\](.*?)\[\/code\]/is"] = function ($match) {
            return "<pre><code>$match[1]</code></pre>";
        };
        // Replace [quote]...[/quote] with <blockquote><p>...</p></blockquote>
        self::$bbcode_table["/\[quote\](.*?)\[\/quote\]/is"] = function ($match) {
            return "<blockquote><p>$match[1]</p></blockquote>";
        };
        // Replace [quote="person"]...[/quote] with <blockquote><p>...</p></blockquote>
        self::$bbcode_table["/\[quote=\"([^\"]+)\"\](.*?)\[\/quote\]/is"] = function ($match) {
            return "$match[1] wrote: <blockquote><p>$match[2]</p></blockquote>";
        };

        // Replace [size=30]...[/size] with <span style="font-size:30%">...</span>
        self::$bbcode_table["/\[size=(\d+)\](.*?)\[\/size\]/is"] = function ($match) {
            return "<span style=\"font-size:$match[1]%\">$match[2]</span>";
        };
        // Replace [s] with <del>
        self::$bbcode_table["/\[s\](.*?)\[\/s\]/is"] = function ($match) {
            return "<del>$match[1]</del>";
        };
        // Replace [u]...[/u] with <span style="text-decoration:underline;">...</span>
        self::$bbcode_table["/\[u\](.*?)\[\/u\]/is"] = function ($match) {
            return '<span style="text-decoration:underline;">' . $match[1] . '</span>';
        };

        // Replace [center]...[/center] with <div style="text-align:center;">...</div>
        self::$bbcode_table["/\[center\](.*?)\[\/center\]/is"] = function ($match) {
            return '<div style="text-align:center;">' . $match[1] . '</div>';
        };
        // Replace [color=somecolor]...[/color] with <span style="color:somecolor">...</span>
        self::$bbcode_table["/\[color=([#a-z0-9]+)\](.*?)\[\/color\]/is"] = function ($match) {
            return '<span style="color:'. $match[1] . ';">' . $match[2] . '</span>';
        };
        // Replace [email]...[/email] with <a href="mailto:...">...</a>
        self::$bbcode_table["/\[email\](.*?)\[\/email\]/is"] = function ($match) {
            return "<a href=\"mailto:$match[1]\">$match[1]</a>";
        };
        // Replace [email=someone@somewhere.com]An e-mail link[/email] with <a href="mailto:someone@somewhere.com">An e-mail link</a>
        self::$bbcode_table["/\[email=(.*?)\](.*?)\[\/email\]/is"] = function ($match) {
            return "<a href=\"mailto:$match[1]\">$match[2]</a>";
        };
        // Replace [url]...[/url] with <a href="...">...</a>
        self::$bbcode_table["/\[url\](.*?)\[\/url\]/is"] = function ($match) {
            return "<a href=\"$match[1]\">$match[1]</a>";
        };

        // Replace [url=http://www.google.com/]A link to google[/url] with <a href="http://www.google.com/">A link to google</a>
        self::$bbcode_table["/\[url=(.*?)\](.*?)\[\/url\]/is"] = function ($match) {
            return "<a href=\"$match[1]\">$match[2]</a>";
        };

        // Replace [img]...[/img] with <img src="..."/>
        self::$bbcode_table["/\[img\](.*?)\[\/img\]/is"] = function ($match) {
            return "<img src=\"$match[1]\"/>";
        };


        // Replace [list]...[/list] with <ul><li>...</li></ul>
        self::$bbcode_table["/\[list\](.*?)\[\/list\]/is"] = function ($match) {
            $match[1] = preg_replace_callback("/\[\*\]([^\[\*\]]*)/is", function ($submatch) {
                return "<li>" . preg_replace("/[\n\r?]$/", "", $submatch[1]) . "</li>";
            }, $match[1]);
            return "<ul>" . preg_replace("/[\n\r?]/", "", $match[1]) . "</ul>";
        };
        // Replace [list=1|a]...[/list] with <ul|ol><li>...</li></ul|ol>
        self::$bbcode_table["/\[list=(1|a)\](.*?)\[\/list\]/is"] = function ($match) {
            if ($match[1] == '1') {
                $list_type = '<ol>';
            } else if ($match[1] == 'a') {
                $list_type = '<ol style="list-style-type: lower-alpha">';
            } else {
                $list_type = '<ol>';
            }
            $match[2] = preg_replace_callback("/\[\*\]([^\[\*\]]*)/is", function ($submatch) {
                return "<li>" . preg_replace("/[\n\r?]$/", "", $submatch[1]) . "</li>";
            }, $match[2]);
            return $list_type . preg_replace("/[\n\r?]/", "", $match[2]) . "</ol>";
        };
        // Replace [youtube]...[/youtube] with <iframe src="..."></iframe>
        self::$bbcode_table["/\[youtube\](?:http?:\/\/)?(?:www\.)?youtu(?:\.be\/|be\.com\/watch\?v=)([A-Z0-9\-_]+)(?:&(.*?))?\[\/youtube\]/i"] = function ($match) {
            return "<iframe class=\"youtube-player\" type=\"text/html\" width=\"640\" height=\"385\" src=\"http://www.youtube.com/embed/$match[1]\" frameborder=\"0\"></iframe>";
        };

        // Custom bbcode
        // Replace [table]...[/table] with <table>...</table>
        self::$bbcode_table["/\[table\](.*?)\[\/table\]/is"] = function ($match) {
            return "<table>$match[1]</table>";
        };
        // Replace [dttable]...[/dttable] with <table class="dttable">...</table>
        self::$bbcode_table["/\[dttable\](.*?)\[\/dttable\]/is"] = function ($match) {
            return "<table class='dttable'>$match[1]</table>";
        };
        // Replace [thead]...[/thead] with <thead>...</thead>
        self::$bbcode_table["/\[thead\](.*?)\[\/thead\]/is"] = function ($match) {
            return "<thead>$match[1]</thead>";
        };
        // Replace [tbody]...[/tbody] with <tbody>...</tbody>
        self::$bbcode_table["/\[tbody\](.*?)\[\/tbody\]/is"] = function ($match) {
            return "<tbody>$match[1]</tbody>";
        };
        // Replace [tr]...[/tr] with <tr>...</tr>
        self::$bbcode_table["/\[tr\](.*?)\[\/tr\]/is"] = function ($match) {
            return "<tr>$match[1]</tr>";
        };
        // Replace [th]...[/th] with <th>...</th>
        self::$bbcode_table["/\[th\](.*?)\[\/th\]/is"] = function ($match) {
            return "<th>$match[1]</th>";
        };
        // Replace [td]...[/td] with <td>...</td>
        self::$bbcode_table["/\[td\](.*?)\[\/td\]/is"] = function ($match) {
            return "<td>$match[1]</td>";
        };
        // Replace [td colspan=..]...[/td] with <td colspan="..">...</td>
        self::$bbcode_table["/\[td colspan=([0-9]+)\](.*?)\[\/td\]/is"] = function ($match) {
            return "<td colspan='$match[1]'>$match[2]</td>";
        };

        // Replace Headers
        self::$bbcode_table["/\[h3](.*?)\[\/h3\]/is"] = function ($match) {
            return "<h3>$match[1]</h3>";
        };
        self::$bbcode_table["/\[h4](.*?)\[\/h4\]/is"] = function ($match) {
            return "<h4>$match[1]</h4>";
        };
        self::$bbcode_table["/\[h5](.*?)\[\/h5\]/is"] = function ($match) {
            return "<h5>$match[1]</h5>";
        };

    }



    public function toHTML ($str, $escapeHTML=false, $nr2br=false) {
        if (!$str) {
            return "";
        }

        if ($escapeHTML) {
            $str = htmlspecialchars($str);
        }
        foreach(self::$bbcode_table as $key => $val) {
            $str = preg_replace_callback($key, $val, $str);
        }
        if ($nr2br) {
            $str = preg_replace_callback("/\n\r?/", function ($match) { return "<br/>"; }, $str);
        }

        return $str;
    }
}