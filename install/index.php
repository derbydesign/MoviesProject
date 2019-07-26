<?php

require '../api/config/install.php';

$installer = new Install();
$installer->dbCreate();
$installer->dbReset();
