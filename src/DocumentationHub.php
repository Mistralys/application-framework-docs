<?php
/**
 * @package App Framework Documentation
 * @see \Mistralys\AppFrameworkDocs\DocumentationHub
 */

declare(strict_types=1);

namespace Mistralys\AppFrameworkDocs;

use Mistralys\MarkdownViewer\DocsConfig;
use Mistralys\MarkdownViewer\DocsManager;
use Mistralys\MarkdownViewer\DocsViewer;

/**
 * Main documentation class: Handles the necessary Markdown Viewer
 * configuration to render the documents.
 *
 * @package App Framework Documentation
 * @author Sebastian Mordziol <s.mordziol@mistralys.eu>
 */
class DocumentationHub
{
    private DocsManager $manager;
    private string $vendorURL;

    public function __construct(string $vendorFolder, string $vendorURL)
    {
        $this->vendorURL = $vendorURL;

        $config = (new DocsConfig());
            //->addIncludePath($vendorFolder . '/communication/builder-content-generator/templates')
            //->addIncludeExtension('tpl');

        $this->manager = (new DocsManager($config))
            ->addFolder(__DIR__ . '/../documents', true);
    }

    private static ?DocumentationPages $pages = null;

    public static function getPageLink() : DocumentationPages
    {
        if(is_null(self::$pages)) {
            self::$pages = new DocumentationPages();
        }

        return self::$pages;
    }

    public static function create(string $vendorFolder, string $vendorURL): DocumentationHub
    {
        return new DocumentationHub($vendorFolder, $vendorURL);
    }

    public function display(): void
    {
        (new DocsViewer($this->manager, $this->vendorURL))
            ->setTitle('Application Framework Documentation')
            ->display();
    }
}
