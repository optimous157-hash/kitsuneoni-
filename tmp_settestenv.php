<?php
$c = file_get_contents('.env');
$c = preg_replace('/^DB_CONNECTION=.*/m', 'DB_CONNECTION=sqlite', $c);
$c = preg_replace('/^DB_DATABASE=.*/m', 'DB_DATABASE=C:/tmp/seedtest/test.sqlite', $c);
file_put_contents('.env', $c);
echo "switched to sqlite test\n";
