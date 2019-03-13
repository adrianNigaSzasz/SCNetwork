<?php
namespace SCNetwork;

use PhpParser\Error;

use PhpParser\NodeTraverser;

use Symfony\Component\Finder\Finder;







abstract class SourceCodeNetworkAbstract
{
    public function getFileTypes($path) : array
    {
        $finder = Finder::create()->files()->in($path);
        $extensionsArray = [];
        /** @var Symfony\Component\Finder\SplFileInfo $files */
        foreach($finder as $files)
        {
            $ext = strtolower($files->getExtension());
            if(!isset($extensionsArray[$ext])){
                $extensionsArray[$ext] = 0;
            }
            $extensionsArray[$ext]++;

        }

        asort($extensionsArray);
        return $extensionsArray;

    }

    public function analyze($path, \PhpParser\ParserAbstract $withParser, NodeTraverser $withTraverser, visitors\AbstractCodeVisitor $nodeVisitor) : void
    {
        $finder = Finder::create()->files()->name('*.php')->in($path)->notPath('vendor')->ignoreVCS(true);

        $total = 0;
        /** @var Symfony\Component\Finder\SplFileInfo $file */
        foreach($finder as $file)
        {
            echo "Processing ".$file->getRealPath();
            $code = $file->getContents();

            try {
                $ast = $withParser->parse($code);
            } catch (Error $error) {
                echo "Parse error: {$error->getMessage()}\n";
                return;
            }

            $withTraverser->addVisitor($nodeVisitor);
            $ast = $withTraverser->traverse($ast);
            echo "; Found ".$nodeVisitor->getNodesCount()." nodes\n";
            $total += $nodeVisitor->getNodesCount();

        }
        echo "Total of ".$total." nodes";

    }
}



