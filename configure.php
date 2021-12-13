#!/usr/bin/env php
<?php

function ask(string $question, string $default = ''): string {
    $answer = readline($question . ($default ? " ({$default})" : null) . ': ');

    if (! $answer) {
        return $default;
    }

    return $answer;
}

function confirm(string $question, bool $default = false): bool {
    $answer = ask($question . ' (' . ($default ? 'Y/n' : 'y/N') . ')');

    if (! $answer) {
        return $default;
    }

    return strtolower($answer) === 'y';
}

function writeln(string $line): void {
    echo $line . PHP_EOL;
}

function run(string $command): string {
    return trim(shell_exec($command));
}

function slugify(string $subject): string {
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $subject), '-'));
}

function title_case(string $subject): string {
    return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $subject)));
}

function replace_in_file(string $file, array $replacements): void {
    $contents = file_get_contents($file);

    file_put_contents(
        $file,
        str_replace(
            array_keys($replacements),
            array_values($replacements),
            $contents
        )
    );
}

function remove_prefix(string $prefix, string $content): string {
    if (strpos($content, $prefix) === 0) {
        return substr($content, strlen($prefix));
    }

    return $content;
}

function findFilesWithTokens($tokens = ":author|:vendor|:package|VendorName|skeleton|vendor_name|vendor_slug|plugin_license|author@domain.com"): array {
    return explode(PHP_EOL, run('grep -E -r -l -i "'.$tokens.'" --exclude-dir=vendor ./* ./.github/* | grep -v ' . basename(__FILE__)));
}

$gitName = run('git config user.name');
$authorName = ask('Author name', $gitName);

$gitEmail = run('git config user.email');
$authorEmail = ask('Author email', $gitEmail);

$usernameGuess = explode(':', run('git config remote.origin.url'))[1];
$usernameGuess = dirname($usernameGuess);
$usernameGuess = basename($usernameGuess);
$authorUsername = ask('Author username', $usernameGuess);

$vendorName = ask('Vendor name', $authorUsername);
$vendorSlug = slugify($vendorName);
$vendorNamespace = ucwords($vendorName);
$vendorNamespace = ask('Vendor namespace', $vendorNamespace);

$currentDirectory = getcwd();
$folderName = basename($currentDirectory);

$packageName = ask('Plugin name', $folderName);
$packageSlug = slugify($packageName);
$pluginHandle = remove_prefix('craft-', $packageSlug);
$className = title_case($packageName);
$className = ask('Class name', $className);
$description = ask('Plugin description', "This is my plugin {$packageSlug}");
$pluginLicense = ask('Plugin license (MIT or proprietary)', 'MIT');


writeln('------');
writeln("Author        : {$authorName} ({$authorUsername}, {$authorEmail})");
writeln("Vendor        : {$vendorName} ({$vendorSlug})");
writeln("Package       : {$packageSlug} <{$description}>");
writeln("Namespace     : {$vendorNamespace}\\{$className}");
writeln("Class name    : {$className}");
writeln("Plugin handle : {$pluginHandle}");
writeln("Plugin license: {$pluginLicense}");


writeln('------');

writeln('This script will replace the above values in all relevant files in the project directory.');

if (! confirm('Modify files?', true)) {
    exit(1);
}

$files = findFilesWithTokens();

foreach ($files as $file) {
    replace_in_file($file, [
        'author_name' => $authorName,
        'author_username' => $authorUsername,
        'author@domain.com' => $authorEmail,
        'vendor_name' => $vendorName,
        'vendor_slug' => $vendorSlug,
        'VendorName' => $vendorNamespace,
        'package_name' => $packageName,
        'package_slug' => $packageSlug,
        'plugin_handle' => $pluginHandle,
        'plugin_license' => $pluginLicense,
        'Skeleton' => $className,
        'skeleton' => $packageSlug,
        'package_description' => $description,
    ]);
}

$fileMap = [
    'src/SkeletonPlugin.php' => "src/$className.php",
    'src/SkeletonSettings.php' => "src/Settings.php",
    'src/Services/SkeletonService.php' => "src/Services/FooService.php",
    'src/Handlers/SkeletonHandler.php' => "src/Handlers/FooHandler.php",

];

foreach ($fileMap as $src => $target) {
    rename($src, $target);
}

if ($pluginLicense === 'MIT') {
    unlink('LICENSE_CRAFT.md');
    rename('LICENSE_MIT.md', 'LICENSE.md');
} else {
    unlink('LICENSE_MIT.md');
    rename('LICENSE_CRAFT', 'LICENSE.md');
}

$php = $_SERVER['_'] ?? 'php';
$composer = file_exists('/usr/local/bin/composer') ? '/usr/local/bin/composer' : 'composer';

confirm('Execute `composer install` and run tests?') && run("$php $composer  install && $php $composer test");

confirm('Let this script delete itself?', true) && unlink(__FILE__);
