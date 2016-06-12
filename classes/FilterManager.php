<?php

/*
 * Manage image filters
 */
class FilterManager {

    private $_filters;

    public function getFilters()
    {
        return $this->_filters;
    }

    public function __construct()
    {
        $this->_filters = array(
            "Contrast+",
            "Contrast-",
            "Luminosity+",
            "Luminosity-",
            "Sepia",
            "Grayscale",
            "Gaussian Blur",
            "Edge",
            "Median",
            "Wave",
            "Charcoal",
            "Emboss",
            "Oil paint"
        );
    }

    public function applyFilter($image, $filter)
    {
        if ($filter == "Contrast+")
            $image->contrastImage(1);
        if ($filter == "Contrast-")
            $image->contrastImage(0);
        if ($filter == "Luminosity+")
            $image->modulateImage(150, 100, 100);
        if ($filter == "Luminosity-")
            $image->modulateImage(80, 100, 100);
        if ($filter == "Sepia")
            $image->sepiaToneImage(80);
        if ($filter == "Grayscale")
            $image->modulateImage(100, 0, 100);
        if ($filter == "Gaussian Blur")
            $image->gaussianBlurImage(5, 1);
        if ($filter == "Edge")
            $image->edgeImage(5);
        if ($filter == "Median")
            $image->medianFilterImage(10);
        if ($filter == "Wave")
            $image->waveImage(5, 20);
        if ($filter == "Charcoal")
            $image->charcoalImage(5, 1);
        if ($filter == "Emboss")
            $image->embossImage(5, 1);
        if ($filter == "Oil paint")
            $image->oilPaintImage(5);

        $image->writeImage();
    }
}