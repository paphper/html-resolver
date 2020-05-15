<?php


namespace Tests\FileTypeResolvers;


use Paphper\Contents\Html;
use Tests\AbstractTestCase;

class HtmlResolverTest extends AbstractTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testHtmlResolver()
    {

        $htmlResolver = $this->fileContentResolver->resolve('naren.html');
        $this->assertInstanceOf(Html::class, $htmlResolver);
    }
}
