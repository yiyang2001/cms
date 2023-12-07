<?php
$path = getenv('PATH');
// $new_path = 'C:\node-v18.15.0-win-x64;' . getenv('PATH');
// putenv("PATH={$new_path}");

// $node_path = 'C:\node-v18.15.0-win-x64';
// $cmd = "setx PATH \"%PATH%;{$node_path}\"";
// exec($cmd, $output, $return_value);

// if ($return_value !== 0) {
//   // Error occurred, handle it as necessary
// } else {
//   // Success, the PATH environment variable was updated
// }
$node_path = 'C:\node-v18.15.0-win-x64';
$env_path = getenv('PATH');
putenv("PATH={$node_path};{$env_path}");

echo $path;
?>