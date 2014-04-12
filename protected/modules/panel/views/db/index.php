<h2>Database Status</h2>
<hr>
<?php
	$this->dumpNow($db->getActive(), 'Is Connection Active');
	$this->dumpNow($db->getDriverName(), 'Driver Name');
	$this->dumpNow($db->connectionString, 'Connection String');
	$this->dumpNow($db->getConnectionStatus(), 'Connection Status');
	$this->dumpNow($db->getServerVersion(),'Server Version');

	$info = explode('  ', $db->getServerInfo());
	$serverInfo = array();
	foreach ($info as $in) {
		list($key, $value) = explode(': ', $in);
		$serverInfo[$key] = $value;
	}
	$this->dumpNow($serverInfo,'Server Info');
