<?php

/**
 * Beskrivelse kommer snarest
 *
 * @author      Benjamin Jørgensen <bj@dunkstormen.dk>
 * @copyright   Aarhus Tech SKP 2017
 */

session_start();

$GLOBALS['config'] = array(
    'database' => array(
        'dsn'       => 'mysql:host=127.0.0.1;dbname=skp_tjekind',       # Database Host
        'username'  => 'skp',                                           # Database Brugernavn
        'password'  => 'Datait2019!!',                                  # Database Password
        'charset'   => 'utf8'                                           # Database Charset
    ),
    'tjek_ind' => array(
        'min' => '700',                                                 # Minimum klokkeslæt for tjek ind
        'max' => '700',                                                 # Maksimum klokkeslæt for tjek ind
    ),
    'tjek_ud' => array(
        'min'         => '1430',                                        # Minimum klokkeslæt for tjek ud (Mandag - Torsdag)
        'min_fredag'  => '1400',                                        # Minimum klokkeslæt for tjek ud (Fredag)
        'max'         => '1430',                                        # Maksimum klokkeslæt for tjek ud (Mandag - Torsdag)
        'max_fredag'  => '1400',                                        # Maksimum klokkeslæt for tjek ud (Fredag)
        'ts'          => '+ 7 hours 30 minutes',                        # Minimum tid tilstede (Mandag - Torsdag)
        'ts_fredag'   => '+ 7 hours'                                    # Minimum tid tilstede (Fredag)
    ),
    'info' => array(
        'tjekind_pc_ip' => '::1'
    )
);

spl_autoload_register(function($class) {
    require_once $_SERVER["DOCUMENT_ROOT"] . '/classes/' . $class . '.php';
});
