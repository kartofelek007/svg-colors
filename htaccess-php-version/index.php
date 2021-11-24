<?php
function checkColor($text) {
    if (empty($text)) return false;

    $htmlColors = ["black", "silver", "gray", "white", "maroon", "red", "purple", "fuchsia", "green", "lime", "olive", "yellow", "navy", "blue", "teal", "aqua", "orange", "aliceblue", "antiquewhite", "aquamarine", "azure", "beige", "bisque", "blanchedalmond", "blueviolet", "brown", "burlywood", "cadetblue", "chartreuse", "chocolate", "coral", "cornflowerblue", "cornsilk", "crimson", "cyan", "darkblue", "darkcyan", "darkgoldenrod", "darkgray", "darkgreen", "darkgrey", "darkkhaki", "darkmagenta", "darkolivegreen", "darkorange", "darkorchid", "darkred", "darksalmon", "darkseagreen", "darkslateblue", "darkslategray", "darkslategrey", "darkturquoise", "darkviolet", "deeppink", "deepskyblue", "dimgray", "dimgrey", "dodgerblue", "firebrick", "floralwhite", "forestgreen", "gainsboro", "ghostwhite", "gold", "goldenrod", "greenyellow", "grey", "honeydew", "hotpink", "indianred", "indigo", "ivory", "khaki", "lavender", "lavenderblush", "lawngreen", "lemonchiffon", "lightblue", "lightcoral", "lightcyan", "lightgoldenrodyellow", "lightgray", "lightgreen", "lightgrey", "lightpink", "lightsalmon", "lightseagreen", "lightskyblue", "lightslategray", "lightslategrey", "lightsteelblue", "lightyellow", "limegreen", "linen", "magenta", "mediumaquamarine", "mediumblue", "mediumorchid", "mediumpurple", "mediumseagreen", "mediumslateblue", "mediumspringgreen", "mediumturquoise", "mediumvioletred", "midnightblue", "mintcream", "mistyrose", "moccasin", "navajowhite", "oldlace", "olivedrab", "orangered", "orchid", "palegoldenrod", "palegreen", "paleturquoise", "palevioletred", "papayawhip", "peachpuff", "peru", "pink", "plum", "powderblue", "rebeccapurple", "rosybrown", "royalblue", "saddlebrown", "salmon", "sandybrown", "seagreen", "seashell", "sienna", "skyblue", "slateblue", "slategray", "slategrey", "snow", "springgreen", "steelblue", "tan", "thistle", "tomato", "turquoise", "violet", "wheat", "whitesmoke", "yellowgreen",];

    if (preg_match("|^[abcdef0-9]{6}|", $text)) {
        return "#".$text;
    }
    if (preg_match("|^[abcdef0-9]{3}$|", $text)) {
        return '#'.$text;
    }
    if (preg_match("|^.+$|", $text) && in_array($text, $htmlColors)) {
        return $text;
    }

    return false;
}

$replaces = [];

for ($i=1; $i<=100; $i++) {
    $index = $i;
    if ($i == 1) $index = "";
    if (isset($_REQUEST["c".$index]) && isset($_REQUEST["to".$index])) {
        $color = checkColor($_REQUEST["c".$index]);
        $to = checkColor($_REQUEST["to".$index]);
        if ($color && $to) {
            $ob = [
                "c"  => $color,
                "to" => $to
            ];
            array_push($replaces, $ob);
        }
    }
}

if (file_exists($_REQUEST["path"])) {
    header('Content-type: image/svg+xml');
    $svg = file_get_contents($_REQUEST["path"]);
    foreach ($replaces as $replace) {
        $color = $replace["c"];
        $to = $replace["to"];

        $svg = preg_replace("|$color|", $to, $svg);
    }
    echo $svg;
} else {
    http_response_code(404);
}
?>