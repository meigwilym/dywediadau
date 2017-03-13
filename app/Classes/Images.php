<?php

namespace App\Classes;

use Image;

class Images {

    protected $resources;

    protected $filename = '';

    protected $x = 506;

    protected $y = 253;

    protected $fontSize = 40;

    public function __construct()
    {
        $this->resources = new Resources();
    }

    public function textToImage($text) 
    {
        $this->filename = str_slug($text).'.jpg';

        $img = Image::make($this->resources->getImgRandom());
        
        $randFont = $this->resources->getFontRandom();

        $lines = $this->textToLines($text);
        
        $pos = $this->calcPositions($lines);
        $fSize = $this->fontSize;

        foreach($lines as $i => $line) 
        {
            $img->text($line, round($this->x/2), $pos[$i], function($font) use ($randFont, $fSize) {
                $font->file($randFont);
                $font->size($fSize);
                $font->color('#ffffff');
                $font->align('center');
                $font->valign('top');
            });
        }
        
        \Storage::put('imgz/' . $this->filename, $img->stream()->detach());
        
        return storage_path('app/imgz/'.$this->filename);
    }

    private function textToLines($text)
    {
        if(strlen($text) < 21) return [$text];

        $string = wordwrap($text, 15, "|");

        return explode("|", $string);
    }

    private function calcPositions($lines)
    {
        $pos = [];
        $middle = round($this->y/2) - round($this->fontSize/2) + 10;

        switch(count($lines))
        {
            case 1:
                $pos[] = $middle;
                break;
            case 2:
                $pos[] = round($this->y/2) - 2 - $this->fontSize;
                $pos[] = round($this->y/2);
                break;
            case 3:
                $pos[] = $middle - 4 - $this->fontSize;
                $pos[] = $middle;
                $pos[] = $middle + 4 + $this->fontSize;
                break;
            case 4:
                $pos[] = round($this->y/2) - 2 - (2*$this->fontSize);
                $pos[] = round($this->y/2) - 2 - $this->fontSize;
                $pos[] = round($this->y/2);
                $pos[] = round($this->y/2) + 2 + $this->fontSize;
            case 5:
                $pos[] = $middle - 4 - (2*$this->fontSize);
                $pos[] = $middle - 4 - $this->fontSize;
                $pos[] = $middle;
                $pos[] = $middle + 4 + $this->fontSize;
                $pos[] = $middle + 4 + (2*$this->fontSize);
        }

        return $pos;
    }
}