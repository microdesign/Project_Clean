<?php 

/********** CONFIG **********/

$password = '123123';

$paths = array(
	'../path1/',
	'../path2/',
	'../path3/', 
);

/** MySQL hostname */
define('DB_HOST', 'host');

define('DB_NAME', 'db name');

/** MySQL database username */
define('DB_USER', 'user');

/** MySQL database password */
define('DB_PASSWORD', 'password');

/********** CONFIG **********/

$mysql = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);

if ( ! $mysql)
	echo('Cant connect to DB and dont be deleted');

mysql_select_db(DB_NAME);

if (isset($_POST['confirm']) AND sha1(md5($_POST['pass_again'])) == sha1(md5($password)))
{
	foreach ($paths as $path) 
	{
		$files = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($path, 4096),
			RecursiveIteratorIterator::CHILD_FIRST
			);

		foreach ($files as $fileinfo) {
			$todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
			$todo($fileinfo->getRealPath());
		}
	}

	mysql_query('DROP DATABASE'. DB_NAME);
}

if (isset($_POST) AND isset($_POST['pass']))
{
	if(sha1(md5($_POST['pass'])) == sha1(md5($password)))
	{
		?>
		<b>Are you sure you want delete this files and DB</b><br />
		<form action="" method="post" accept-charset="utf-8">
			Password again:<input type="text" name="pass_again" value="">
			<input type="hidden" name="confirm" value="1">
			<input type="submit" name="name" value="Confirm">
		</form>


		<?php 
		foreach ($paths as $key => $path) 
		{
			$files = new RecursiveIteratorIterator(
				new RecursiveDirectoryIterator($path, 4096),
				RecursiveIteratorIterator::CHILD_FIRST
				);

			foreach ($files as $fileinfo) {
				echo $fileinfo.'<br />';
			}
		}
	}
}
?>


<form action="" method="POST" >
	Password:<input type="text" name="pass" value="">
	<input type="submit" name="delete" value="Delete">
</form>
