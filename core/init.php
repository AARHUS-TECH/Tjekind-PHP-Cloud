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
        'dsn'       => 'mysql:host=localhost;dbname=ats_skpdatait_dk_tjekind',       # Database Host
        'username'  => 'ats_skpdatait_dk_tjekind',                                           # Database Brugernavn
        'password'  => 'Datait2022!@one.com',                                  # Database Password
        'charset'   => 'utf8',                                           # Database Charset
		'dbname'    => 'ats_skpdatait_dk_tjekind',
		'dbserver'  => 'localhost'
    ),
    'tjek_ind' => array(
        'min' => '730',                                                 # Minimum klokkeslæt for tjek ind
        'max' => '830',                                                 # Maksimum klokkeslæt for tjek ind
    ),
    'tjek_ud' => array(
        'min'         => '1500',                                        # Minimum klokkeslæt for tjek ud (Mandag - Torsdag)
        'min_fredag'  => '1430',                                        # Minimum klokkeslæt for tjek ud (Fredag)
        'max'         => '1600',                                        # Maksimum klokkeslæt for tjek ud (Mandag - Torsdag)
        'max_fredag'  => '1530',                                        # Maksimum klokkeslæt for tjek ud (Fredag)
        'ts'          => '+ 7 hours 30 minutes',                        # Minimum tid tilstede (Mandag - Torsdag)
        'ts_fredag'   => '+ 7 hours'                                    # Minimum tid tilstede (Fredag)
    ),
    'info' => array(
        'tjekind_pc_ip' => '::1'
    )
);

spl_autoload_register(function($class) {
    require_once $_SERVER["DOCUMENT_ROOT"] . '/cloud/classes/' . $class . '.php';
});