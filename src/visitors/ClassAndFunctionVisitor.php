<?php
namespace SCNetwork\visitors;

use PhpParser\Node;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Class_;

use SCNetwork\visitors\AbstractCodeVisitor;

class ClassAndFunctionVisitor extends AbstractCodeVisitor {
    private $nodes = 0;

    public function enterNode(Node $node) {
        if ($node instanceof Function_) {
            // Clean out the function body
            $this->nodes++;
        }
        if($node instanceof Class_)
        {
            foreach($node->getMethods() as $method)
            {
                $this->nodes++;
            }
        }
    }

    public function getNodesCount()
    {
        return $this->nodes;
    }
}



