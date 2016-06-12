<?php
require_once("Image.php");
require_once("Database.php");

/*
 * A user and its images
 */
class User
{
    private $_name;
    private $_images;
    private $_imagesPath;

    public function getName()
    {
        return $this->_name;
    }

    public function getImages()
    {
        return $this->_images;
    }

    public function getImagesPath()
    {
        return $this->_imagesPath;
    }

    public function __construct($name)
    {
        $this->_name = $name;
        $this->_imagesPath = 'images/'.$this->_name.'/';
        $this->_images = new Imagick(glob($this->_imagesPath.'*'));
    }

    public function displayImagesByColor($color)
    {
        $images = new Imagick(glob($this->_imagesPath.'*'));
        if ($images->getNumberImages() != 0)
        {
            $i = 0;
            foreach ($images as $image)
            {
                if ($i % 2 != 0)
                {
                    echo '<div class="row">';
                }
                $img = new Image($image, $this->_imagesPath);
                $img->show();
                if ($i % 2 != 0)
                {
                    echo '</div>';
                }
                $i = $i + 1;
            }
        }
    }

    public function displayImagesGif()
    {
        if (file_exists("images.gif"))
        {
            unlink("images.gif");
        }
        $images = new Imagick(glob($this->_imagesPath.'*'));
        if ($images->getNumberImages() != 0)
        {
            echo '<div class="row text-center">';
            $gif = new Imagick();
            $gif->setFormat("gif");
            $max = 0;
            foreach ($images as $image)
            {
                if ($image->getImageHeight() > $max)
                    $max = $image->getImageHeight();
            }
            foreach ($images as $image)
            {
                $frame = new Imagick();
                $frame->newImage(420, $max, new ImagickPixel('white'));
                $frame->readImage($image->getImageFilename());
                $frame->setImageDelay(70);
                $gif->addImage($frame);
            }
            $gif->writeImages("images.gif", true);
            echo '<img src="images.gif" alt="images.gif">';
            echo '</div><br/>';
        }
    }

    public function displayImages()
    {
        $images = new Imagick(glob($this->_imagesPath.'*'));
        if ($images->getNumberImages() != 0)
        {
            $i = 0;
            foreach ($images as $image)
            {
                if ($i % 2 != 0)
                {
                    echo '<div class="row">';
                }
                $img = new Image($image, $this->_imagesPath);
                $img->show();
                if ($i % 2 != 0)
                {
                    echo '</div>';
                }
                $i = $i + 1;
            }
        }
    }

    public function deleteImage($image)
    {
        $img = $this->_imagesPath.$image;
        if (file_exists($img))
        {
            unlink($img);
        }
        $db = new Database();
        $db->deleteImage($image);
    }

    public function hasImage($imageName)
    {
        $images = new Imagick(glob($this->_imagesPath.'*'));
        if ($images->getNumberImages() != 0)
        {
            foreach ($images as $image)
            {
                $img = new Image($image, $this->_imagesPath);
                if ($img->getName() == $imageName)
                {
                    return true;
                }
            }
        }
        return false;
    }

    public function getImage($imageName)
    {
        $image = new Imagick(glob($this->_imagesPath.$imageName));
        $img = new Image($image, $this->_imagesPath);
        return $img;
    }

    public function applyFilter($imageName, $filter)
    {
        $images = new Imagick(glob($this->_imagesPath.'*'));
        if ($images->getNumberImages() != 0)
        {
            foreach ($images as $image)
            {
                $img = new Image($image, $this->_imagesPath);
                if ($img->getName() == $imageName)
                {
                    $img->applyFilter($filter);
                }
            }
        }
    }
}