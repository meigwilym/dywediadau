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
        
        $pos = $this->calcPositions(count($lines));
        $fSize = $this->fontSize;

        foreach($lines as $i => $line) 
        {
            $img->text($line, round($this->x/2), $pos[$i], function($font) use ($randFont, $fSize) {
                $font->file($randFont);
                $font->size($fSize);
                $font->color('#ffffff');
                $font->align('center');
                $font->valign('bottom');
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

    /**
     * 
     **/
    private function calcPositions($lineCount)
    {
        $pos = [];
        $lineHeight = round($this->fontSize*1.1); 
        
        for($i=0;$i<$lineCount;$i++) 
        {
            $pos[] = ($i * $lineHeight) + (round($this->y/2) + $lineHeight) - ($lineCount * round(($lineHeight/2)));
        }
        return $pos;
    }
}