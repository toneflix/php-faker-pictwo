<?php

namespace Toneflix\FakerPicTwo\Tests;

use PHPUnit\Framework\TestCase;
use Toneflix\FakerPicTwo\FakerPicTwoProvider;

class FakerPicTwoProviderTest extends TestCase
{
    public function testImageUrlUses640x680AsTheDefaultSize()
    {
        $this->assertMatchesRegularExpression(
            '#^https://pictwo.toneflix.net/images\?w=640&h=480#',
            FakerPicTwoProvider::imageUrl()
        );
    }

    public function testImageUrlAcceptsCustomWidthAndHeight()
    {
        $this->assertMatchesRegularExpression(
            '#^https://pictwo.toneflix.net/images\?w=800&h=400#',
            FakerPicTwoProvider::imageUrl(800, 400)
        );
    }

    public function testImageUrlWithPixelate()
    {
        $this->assertMatchesRegularExpression(
            '#^https://pictwo.toneflix.net/images\?w=800&h=400&pixelate=#',
            FakerPicTwoProvider::imageUrl(800, 400, null, false, null, false, 5)
        );
    }

    public function testImageUrlWithText()
    {
        $this->assertMatchesRegularExpression(
            '#^https://pictwo.toneflix.net/images\?w=800&h=400&text=Hello#',
            FakerPicTwoProvider::imageUrl(800, 400, null, false, 'Hello', false)
        );
    }

    public function testImageUrlGrey()
    {
        $this->assertMatchesRegularExpression(
            '#^https://pictwo.toneflix.net/images\?w=800&h=400&greyscale=#',
            FakerPicTwoProvider::imageUrl(800, 400, null, false, null, true)
        );
    }

    public function testImageUrlWithCategoryAndCustomWidthAndHeight()
    {
        $this->assertMatchesRegularExpression(
            '#^https://pictwo.toneflix.net/images/avatar\?w=800&h=400#',
            FakerPicTwoProvider::imageUrl(800, 400, 'avatar')
        );
    }

    public function testImageUrlWithGreyAndPixelate()
    {
        $imageUrl = FakerPicTwoProvider::imageUrl(
            800,
            400,
            null,
            false,
            null,
            true,
            5
        );

        $this->assertSame('https://pictwo.toneflix.net/images?w=800&h=400&greyscale=true&pixelate=5', $imageUrl);
    }

    public function testImageUrlAddsARandomGetParameterByDefault()
    {
        $url = FakerPicTwoProvider::imageUrl(800, 400);
        $splitUrl = explode('?', $url);

        $this->assertEquals(count($splitUrl), 2);
        $this->assertMatchesRegularExpression('#random=\d{5}#', $splitUrl[1]);
    }

    public function testImageUrlAcceptsAllRealPictwoCategories()
    {
        $categories = [
            'african-fashion', 'album', 'avatar', 'cars', 'design', 'event', 'fabric',
            'fashion', 'nature', 'people', 'poster', 'product', 'profile', 'robots', 'technology',
        ];

        foreach ($categories as $category) {
            $this->assertMatchesRegularExpression(
                '#^https://pictwo\.toneflix\.net/images/' . preg_quote($category, '#') . '\?#',
                FakerPicTwoProvider::imageUrl(category: $category)
            );
        }
    }

    public function testImageUrlRejectsAStaleUnsupportedCategory()
    {
        $this->expectException(\InvalidArgumentException::class);

        FakerPicTwoProvider::imageUrl(category: 'house');
    }

    public function testImageDownloadWithDefaults()
    {
        $file = FakerPicTwoProvider::image(sys_get_temp_dir());

        if ($file === false) {
            $this->markTestSkipped('Could not reach ' . FakerPicTwoProvider::BASE_URL . ' to download a test image.');
        }

        $this->assertFileExists($file);
        if (function_exists('getimagesize')) {
            list($width, $height, $type) = getimagesize($file);

            $this->assertEquals(640, $width);
            $this->assertEquals(480, $height);
            $this->assertEquals(constant('IMAGETYPE_JPEG'), $type);
        } else {
            $this->assertEquals('jpg', pathinfo($file, PATHINFO_EXTENSION));
        }
        if (file_exists($file)) {
            unlink($file);
        }
    }
}
