<?php

namespace Tests;

use function Clue\React\Block\await;
use Paphper\Config;
use Paphper\FileContentResolver;
use Paphper\FileTypeResolvers\HtmlResolver;
use Paphper\PageResolvers\FilesystemPageResolver;
use PHPUnit\Framework\TestCase;
use React\EventLoop\Factory;
use React\Filesystem\Filesystem;

class AbstractTestCase extends TestCase
{
    protected $filesystem;
    protected $loop;
    protected $baseDir;
    protected $config;
    protected $fileContentResolver;
    protected $pageResolvers;

    public function setUp(): void
    {
        $this->loop = Factory::create();
        $this->filesystem = Filesystem::create($this->loop);
        $this->baseDir = getBaseDir();
        $configData =   include BASE_DIR . '/config.php';
        $this->config = new Config($configData);
        $htmlResolver = new HtmlResolver($this->config, $this->filesystem);

        $this->fileContentResolver = new FileContentResolver();
        $this->fileContentResolver->add('html', $htmlResolver);
        $this->pageResolvers = new FilesystemPageResolver($this->config, $this->filesystem);
    }

    public function deleteBuildFolder()
    {
        $promise = $this->filesystem->dir($this->config->getBuildBaseFolder())
            ->stat()
            ->then(function () {
                return $this->filesystem->dir($this->config->getBuildBaseFolder())->removeRecursive();
            }, function (\Exception $exception) {
            });
        await($promise, $this->loop);
    }
}
