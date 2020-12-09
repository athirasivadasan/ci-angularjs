

#CodeIgniter 4

	cd ci
	php spark serve
	
	Go to browser : http://localhost:8080/index to access the page

#Database configuration

	ci/app/Config/Database.php


	change the Mysql username and password to complete the db connection

	public $default = [
			'DSN'      => '',
			'hostname' => 'localhost',
			'username' => 'admin',
			'password' => 'root',
			'database' => 'sayed',
			'DBDriver' => 'MySQLi',
			'DBPrefix' => '',
			'pConnect' => false,
			'DBDebug'  => (ENVIRONMENT !== 'production'),
			'cacheOn'  => false,
			'cacheDir' => '',
			'charset'  => 'utf8',
			'DBCollat' => 'utf8_general_ci',
			'swapPre'  => '',
			'encrypt'  => false,
			'compress' => false,
			'strictOn' => false,
			'failover' => [],
			'port'     => 3306,
		];
