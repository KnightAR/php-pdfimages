<?php
/*
* (c) Waarneembemiddeling.nl
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/ 

namespace Wb\PdfImages;

class PdfImagesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PdfImages
     */
    private $pdfImages;

    public function setUp()
    {
        $this->pdfImages = PdfImages::create(array(
            'pdfimages.binaries' => getenv('binary')
        ));
    }

    public function testExtractImage()
    {
        $result = $this->pdfImages->extractImages(dirname(__DIR__) . '/Resources/test_gif.pdf');

        $this->assertSame(1, iterator_count($result));
    }

    public function testExtractPngImage()
    {
        $result = $this->pdfImages->extractImages(dirname(__DIR__) . '/Resources/test_png.pdf');

        $this->assertSame(2, iterator_count($result));
    }

    public function testExtractImageToGivenDir()
    {
        $destinationDir = sys_get_temp_dir() . '/pdfimages';
        @mkdir($destinationDir);

        $result = $this->pdfImages->extractImages(dirname(__DIR__) . '/Resources/test_gif.pdf', $destinationDir);

        $this->assertSame(1, iterator_count($result));
    }

    public function testExtractMultipleImages()
    {
        $result = $this->pdfImages->extractImages(dirname(__DIR__) . '/Resources/test_gif2.pdf');

        $this->assertSame(2, iterator_count($result));
    }

    public function testPageOption()
    {
        $result = $this->pdfImages->extractImages(dirname(__DIR__) . '/Resources/test_gif2.pdf', null, ['page' => 1]);

        $this->assertSame(2, iterator_count($result));
    }

    public function testFirstLastPageOption()
    {
        $result = $this->pdfImages->extractImages(dirname(__DIR__) . '/Resources/test_gif2.pdf', null, ['firstPage' => 1, 'lastPage' => 1]);

        $this->assertSame(2, iterator_count($result));
    }
}
