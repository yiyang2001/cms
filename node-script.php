<?php

$usage = "Usage: php node-script.php [-s|-e]\n\n"
       . "  -s    Set the PATH environment variable to include C:\\node-v18.15.0-win-x64\n"
       . "  -e    Remove C:\\node-v18.15.0-win-x64 from the PATH environment variable\n";

if ($argc != 2 || !in_array($argv[1], ['-s', '-e'])) {
    die($usage);
}

if ($argv[1] === '-s') {
    $nodePath = 'C:\\node-v18.15.0-win-x64';
    $path = getenv('PATH');
    if (strpos($path, $nodePath) === false) {
        putenv("PATH=$path;$nodePath");
        echo "Node path added to PATH environment variable.\n";
    } else {
        echo "Node path is already in PATH environment variable.\n";
    }
} elseif ($argv[1] === '-e') {
    $nodePath = 'C:\\node-v18.15.0-win-x64';
    $path = getenv('PATH');
    $newPath = str_replace(";$nodePath", '', $path);
    if ($newPath !== $path) {
        putenv("PATH=$newPath");
        echo "Node path removed from PATH environment variable.\n";
    } else {
        echo "Node path is not in PATH environment variable.\n";
    }
}

?>