<?php

use Difference\Fun\Module\Data;
use Difference\Fun\Module\Dir;
use Difference\Fun\Module\Core;
use Difference\Fun\Module\Event;
use Difference\Fun\Module\File;
use Difference\Fun\Module\Parse;

/**
 * @throws \Difference\Fun\Exception\FileWriteException
 * @throws \Difference\Fun\Exception\ObjectException
 * @throws \Doctrine\ORM\Exception\ORMException
 * @throws \Doctrine\ORM\ORMException
 * @throws \Doctrine\DBAL\Exception
 */
function function_log_archive(Parse $parse, Data $data){
    $object = $parse->object();
    $source = $object->parameter($object, 'archive', 1);
    $explode = explode('.', File::basename($source));
    if(array_key_exists(1, $explode)){
        $dir = $object->config('project.dir.log') .
            'Archive' .
            $object->config('ds')
        ;
        $destination = $dir .
            $explode[0] .
            '."{date(\'Ymd\')}".' .
            $explode[1] .
            '.zip'
        ;
        $binary = Core::binary($object);
        $execute = $binary . ' zip archive ' . $source . ' ' . $destination;
        $output = false;
        Core::execute($object, $execute, $output);
        File::chown($dir, 'www-data', 'www-data', true);
        if($object->config('project.log.name')){
            $object->logger($object->config('project.log.name'))->info('log_archive dir', [ $dir ]);
        }
        File::write($source,'');
        $dir = Dir::name($source);
        File::chown($dir, 'www-data', 'www-data', true);
        if($object->config('project.log.name')){
            $object->logger($object->config('project.log.name'))->info('log_archive dir', [ $dir ]);
        }
        Event::trigger($object, 'cli.log.archive', [
            'channel' => $explode[0],
            'source' => $source,
            'destination' => $destination,
            'output' => $output,
        ]);
        echo 'Log file has been reset...' . PHP_EOL;
    }
}
