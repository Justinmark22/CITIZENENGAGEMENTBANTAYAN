<?php
// Script to create storage symlink on shared hosting

// Get the document root (public directory)
$publicDir = __DIR__;

// Get the storage directory (up two levels and into storage/app/public)
$storageDir = dirname($publicDir, 2) . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'public';

// Target for the symlink (storage directory inside public)
$targetDir = $publicDir . DIRECTORY_SEPARATOR . 'storage';

// Create storage directory if it doesn't exist
if (!is_dir($storageDir)) {
    mkdir($storageDir, 0755, true);
    echo "Created storage directory at: " . $storageDir . "\n";
}

// Remove existing symlink if it exists
if (is_link($targetDir)) {
    unlink($targetDir);
    echo "Removed existing symlink\n";
}

// Create the symlink
if (symlink($storageDir, $targetDir)) {
    echo "Successfully created symlink from:\n";
    echo $storageDir . "\n";
    echo "to:\n";
    echo $targetDir . "\n";
} else {
    echo "Failed to create symlink\n";
}

// Set proper permissions
chmod($storageDir, 0755);
echo "Set permissions on storage directory\n";

// Create reports directory
$reportsDir = $storageDir . DIRECTORY_SEPARATOR . 'reports';
if (!is_dir($reportsDir)) {
    mkdir($reportsDir, 0755, true);
    echo "Created reports directory at: " . $reportsDir . "\n";
}

echo "Setup complete!\n";
?>