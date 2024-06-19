<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
class FileService
{
    /**
     * Generates a random file name with the specified length and extensions.
     *
     * @param int $length The length of the random string to be generated.
     * @param array $extensions An array of file extensions to choose from.
     * @return string The generated random file name.
     */
    public function generateRandomFileName($length, $extensions)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)] . rand(0, 9);
        }

        $randomExtension = $extensions[array_rand($extensions)];
        return $randomString . '.' . $randomExtension;
    }

    /**
     * Creates a specified number of folders and files within each folder.
     *
     * @param string $baseDir The base directory where the folders will be created.
     * @param int $fileCount The number of files to be created in each subfolder.
     * @param int $fileNameLength The length of the generated file names.
     * @param int $folderCount The number of folders to be created.
     * @param int $subfolderCount The number of subfolders to be created in each folder.
     * @param array $extensions An array of allowed file extensions.
     * @return bool True if the folders and files were created successfully, false otherwise.
     */
    public function createFoldersAndFiles($baseDir, $fileCount, $fileNameLength, $folderCount, $subfolderCount, $extensions)
    {
        if (Storage::exists($baseDir)) {
            Storage::deleteDirectory($baseDir);
            Storage::deleteDirectory('storage_data/copy');
        }

        for ($i = 1; $i <= $folderCount; $i++) {
            $folderPath = "$baseDir/folder$i";

            // Create the main folder
            if (!Storage::exists($folderPath)) {
                Storage::makeDirectory($folderPath);
            }

            for ($j = 1; $j <= $subfolderCount; $j++) {
                $subfolderPath = "$folderPath/subfolder$j";

                if (!Storage::exists($subfolderPath)) {
                    Storage::makeDirectory($subfolderPath);
                }

                for ($k = 0; $k < $fileCount; $k++) {
                    $fileName = $this->generateRandomFileName($fileNameLength, $extensions);
                    $filePath = "$subfolderPath/$fileName";

                    if (!Storage::exists($filePath)) {
                        Storage::put($filePath, "This is $fileName in $subfolderPath");
                    }
                }
            }
        }
        return true;
    }
    /**
     * Copies a directory and its contents to a new location.
     *
     * @param string $src The source directory path.
     * @param string $dst The destination directory path.
     * @throws Exception If the destination directory cannot be created.
     * @return void
     */
    public function copyDirectory($src, $dst) {
        if (!Storage::exists($src)) {
            return false;
        }

        if (!Storage::exists($dst)) {
            Storage::makeDirectory($dst, 0777, true); // Recursively create directory
        }

        $files = Storage::allFiles($src);
        foreach ($files as $file) {
            $relativeFilePath = str_replace("$src/", '', $file);
            Storage::copy($file, "$dst/$relativeFilePath");
        }

        return true;
    }
    /**
     * Renames all files in a directory and its subdirectories by replacing any digit with '0'.
     *
     * @param string $dir The directory path to rename files in.
     * @throws None
     * @return void
     */
    public function renameFiles($dir) {
        // Ensure directory exists
        if (!Storage::exists($dir)) {
            return false;
        }

        $files = Storage::allFiles($dir);

        foreach ($files as $file) {
            if (Storage::exists($file)) {
                $fileName = pathinfo($file, PATHINFO_BASENAME);

                $newName = strtolower(preg_replace('/\d/', '0', $fileName));
                Storage::move($file, dirname($file) . '/' . $newName);
            }
        }
        return true;
    }
    /**
     * Recursively lists all JPG files in a directory and its subdirectories.
     *
     * @param string $dir The directory to search for JPG files.
     * @return array An array of full paths to all JPG files found.
     */
    public function listJpgFiles($dir) {
        // Ensure directory exists
        if (!Storage::exists($dir)) {
            return [];
        }

        $jpgFiles = [];

        $files = Storage::allFiles($dir);

        foreach ($files as $file) {
            $fileName = basename($file);
            if (pathinfo($file, PATHINFO_EXTENSION) === 'jpg') {
                $jpgFiles[] = $fileName;
            }
        }

        return $jpgFiles;
    }

    /**
     * Creates a CSV file with the provided array data and returns the file path.
     *
     * @param string $csvFileName The name of the CSV file to be created.
     * @param array $arrayOne The first array of data to be included in the CSV file.
     * @param array $arrayTwo The second array of data to be included in the CSV file.
     * @return string The file path of the created CSV file.
     */
    public function createCSV($csvFileName, $headers, $csvData) {
        $csvFilePath = storage_path('app/public/' . $csvFileName);

        $file = fopen($csvFilePath, 'w');
        fputcsv($file, $headers);

        foreach ($csvData as $row) {
            fputcsv($file, $row);
        }

        fclose($file);

        return $csvFilePath; // Return the generated CSV file path
    }
}