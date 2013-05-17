PHP-Colormap
============

A flexible colormap class

You can map scalar (floating point) values in range [0-1] to colors in the format #RRGGBB


Example:
--

Simple basic mapping



    <?php
    require_once("ColorMapper.php");

    $cm = new ColorMapper();
    
    print $c->floatMap(0.1);
    print $c->floatMap(0.5);
    print $c->floatMap(0.9);
    ?>


More complex stuff:
--

See implementation of `build($array)`
