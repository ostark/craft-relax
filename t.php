<?php

foreach(range(0,200) as $sec) {

    $rounded = round(time()/120)*120;
    echo date('H:i:s', $rounded) .' - '. $rounded . PHP_EOL;
    sleep(30);

}
