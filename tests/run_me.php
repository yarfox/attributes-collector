<?php
/**
 * The file is part of the annotation.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/14 12:00 上午
 */

use Anhoder\Annotation\AttributeKeeper;

require __DIR__ . '/../vendor/autoload.php';

AttributeKeeper::bootloader();
AttributeKeeper::collect();
