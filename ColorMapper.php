<?php

/**
 * User: Alberto Boschetti
 * Date: 17/05/13
 * Time: 10:10
 */

class ColorMapper
{
    private $colorArray = array();
    private $nColors;
    private $step;
    private $invalidColor = '#000000';

    function __construct($colorArray = NULL)
    {
        $this->build($colorArray);
    }

    public function isValid() {
        if ($this->nColors > 0)
            return true;
        else
            return false;
    }

    private function build($colorArray) {

        if (is_null($colorArray)) {
            $this->colorArray[0] = array(0,     0, 255);
            $this->colorArray[1] = array(0,   255, 255);
            $this->colorArray[2] = array(0,   255,   0);
            $this->colorArray[3] = array(255, 255,   0);
            $this->colorArray[4] = array(255,   0,   0);
            $this->nColors = 5;

        }
        elseif (is_array($colorArray) && is_array($colorArray[0]) && count($colorArray[0]) == 3) {
            $this->colorArray = $colorArray;
            $this->nColors = count($colorArray);
        }
        $this->step = 1.0 / ($this->nColors-1);

    }

    private function toHexCompString($dec) {
        $string = dechex($dec);
        if (strlen($string) == 1) {
            $string = "0" . $string;
        }
        return $string;
    }

    private function toHexRGBString($arr) {
        $R = $arr[0];
        $G = $arr[1];
        $B = $arr[2];

        $rString = $this->toHexCompString($R);
        $gString = $this->toHexCompString($G);
        $bString = $this->toHexCompString($B);

        return "#" . $rString . $gString . $bString;
    }

    private function linearInterpolation($x, $x0, $x1, $y0, $y1) {
        $y = $y0 + ($y1-$y0) * ($x-$x0)/($x1-$x0);
        return $y;
    }

    public function floatMap($f) {
        if ($this->isValid()) {
            if ($f < 0.0)
                return $this->toHexRGBString($this->colorArray[0]);
            elseif ($f >= 1.0)
                return $this->toHexRGBString($this->colorArray[$this->nColors-1]);

            else {
                $nFloor = floor($f/$this->step);
                $nCeil = $nFloor + 1;
                $v = array();
                $v[0] = $this->linearInterpolation($f, $this->step*$nFloor, $this->step*$nCeil, $this->colorArray[$nFloor][0], $this->colorArray[$nCeil][0]);
                $v[1] = $this->linearInterpolation($f, $this->step*$nFloor, $this->step*$nCeil, $this->colorArray[$nFloor][1], $this->colorArray[$nCeil][1]);
                $v[2] = $this->linearInterpolation($f, $this->step*$nFloor, $this->step*$nCeil, $this->colorArray[$nFloor][2], $this->colorArray[$nCeil][2]);
                return $this->toHexRGBString($v);
            }

        }
        else
            return $this->invalidColor;
    }

    public function getInvalidColor() {
        return $this->invalidColor;
    }

}


?>