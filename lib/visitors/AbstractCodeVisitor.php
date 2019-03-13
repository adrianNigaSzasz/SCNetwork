<?php
namespace SCNetwork\visitors;

use PhpParser\NodeVisitorAbstract;

abstract class AbstractCodeVisitor extends NodeVisitorAbstract
{
    public abstract function getNodesCount() : int;
}