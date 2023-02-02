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
    ),
    'token-terminal' => array(
        '5f51a4a917841eb4210b2c97979886d1cdcc1ece77e0bc1a2d49579449baf019',
        'f2b5407138b561103f17efc76117961ebb5673face973b573341bd50840011eb',
        '9786e29337c7b5682f5147f375e8552228c5c9f30c76a71c5fb5016967c09204',
        '26040e8d06d9fa568b3e974308cd822a00f7354b093a28a1780cf68abf9f14c1',
        '06bb21a25fd6fa618158591e6e6e7ff8369e3c8da859a636d6e94560f510d89d',
        'bc086ff954bcf61a82783898d129722afe76aa023a66c42b717cdb33d88f45e6',
        'e76db9531005d20ef4df0ed936ad70405383d26d930f4e66ce04bd0226699f6c',
        'd8ce464525b69c35f72e37407976ddbc4e42debadbc3c56eedd6bf4492ad0fe5',
        '8218e6b61fdb2f6e48de118502b014c7bb6aff83a9cfacbdf436e9b7f53209f5',
        '17a59e2dbdac1ee974ae1424f68baf67615a95ebf743ffc739e3a05d38d06b64',
    ),
    'token-webunits'=>array(),
);

spl_autoload_register(function($class) {
    require_once $_SERVER["DOCUMENT_ROOT"] . '/cloud/classes/' . $class . '.php';
});

/** Absolute path to the Tjekind directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', $_SERVER["DOCUMENT_ROOT"] . '/cloud/' );
}

/** Sets up WordPress vars and included files. */
//require_once( ABSPATH . 'wp-settings.php' );