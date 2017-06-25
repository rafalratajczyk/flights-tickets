<?php

if (!isset($_COOKIE['visits'])) {
    setcookie('visits', 1, time() + 3600 * 24 * 365);
    echo "Welcome for the first time on Our site !";
} else {
    setcookie('visits', $_COOKIE['visits'] + 1);
    echo "Welcome again, You visited Us " . $_COOKIE['visits'] . " times !";
}

?>
