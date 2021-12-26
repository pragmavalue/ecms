<?php
/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this file without the
 * .dist extension at the end and populate values as needed.
 *
 * @NOTE: This file is ignored from Git by default with the .gitignore included
 * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
 * credentials from accidentally being committed into version control.
 */

use Doctrine\DBAL\Driver\PDOMySql\Driver as PDOMySqlDriver;

return [
    'doctrine' => [
        
        'connection' => [
            'orm_default' => [

                'driverClass' => PDOMySqlDriver::class,
                'params' => [
                    'dbname'   => 'ecms',
                    'host'     => 'localhost',                    
                    'user'     => 'root',
                    'password' => '',
                    'driverOptions' => [1002 => 'SET NAMES utf8']
                 
               
            ],

            ],

          
],

],

    ];
