<?php
require_once("FilterManager.php");

/*
 * An image and its associated manipulations
 */
class Image
{
    private $_image;
    private $_path;
    private $_filterManager;

    public function getImage()
    {
        return $this->_image;
    }

    public function getName()
    {
        return basename($this->_image->getImageFilename());
    }

    public function getFilters()
    {
        return $this->_filterManager->getFilters();
    }

    public function __construct($image, $path)
    {
        $this->_image = $image;
        $this->_path = $path;
        $this->_filterManager = new FilterManager();
    }

    public function show()
    {
        $imageName = basename($this->_image->getImageFilename());
        echo '<div class="large-6 columns">';
        echo '<p>';
        echo '<a href="image.php?image='.$imageName.'"><img src="'.$this->_path.$imageName.'" alt="'.$imageName.'"></a>';
        echo '</p>';
        echo '</div>';
    }

    public function applyFilter($filter)
    {
        $this->_filterManager->applyFilter($this->_image, $filter);
    }
}