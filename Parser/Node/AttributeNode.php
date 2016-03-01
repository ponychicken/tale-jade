<?php

namespace Tale\Jade\Parser\Node;

use Tale\Jade\Parser\Node;
use Tale\Jade\Util\CheckTrait;
use Tale\Jade\Util\EscapeTrait;
use Tale\Jade\Util\NameTrait;
use Tale\Jade\Util\ValueTrait;

class AttributeNode extends Node
{
    use NameTrait;
    use ValueTrait;
    use EscapeTrait;
    use CheckTrait;
}