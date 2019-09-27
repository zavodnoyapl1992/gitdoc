<?php

require 'vendor/autoload.php';

$parse = new \GitDoc\Parse(__DIR__);
/**
 * You can register your custom parser
 */
$parse->moduleRegister(new \GitDoc\ParseModules\ChangesModule(), \GitDoc\DTO\ChangesDTO::class);

$relation = new \GitDoc\Analyser\BuildRelation($parse);
$relation->registerAnalyser(new \GitDoc\Analyser\Modules\Owners(), \GitDoc\DTO\ChangesDTO::class);

foreach ($relation->run() as $analyser) {
	echo $analyser->getName() . PHP_EOL;
	var_dump($analyser->getResult());
}


