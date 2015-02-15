<?php

/**
 * This is a tester file for Pollen Buddy
 */

require_once("PollenBuddy.php");

$data = new PollenBuddy(19104);
echo $data->getSiteHTML();