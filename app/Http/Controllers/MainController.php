<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Services\FileService;
use App\Services\WebParserService;

class MainController extends Controller
{
    protected $fileService;
    protected $webParserService;
    public function __construct(FileService $fileService, WebParserService $webParserService)
    {
        $this->fileService = $fileService;
        $this->webParserService = $webParserService;
    }
    public function index()
    {
        return view('main');
    }
    public function validateEmail(Request $request)
    {
        // Using default validator
        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|email',
        // ]);

        // if ($validator->passes()) {
        //     return response()->json(['message' => 'valid']);
        // } else {
        //     return response()->json(['message' => 'not valid']);
        // }

        //Using regex email validator
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'regex:/^[a-zA-Z0-9]+[a-zA-Z0-9._-]*@[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$/']
        ]);
        return response()->json(['nonvalid' => $validator->fails()]);
    }
    public function transliterate(Request $request)
    {
        $requestData = json_decode($request->getContent(), true);
        if (isset($requestData['trtext'])) {
            $transliterator = transliterator_create('Any-Latin; Latin-ASCII');
            $transliterated = transliterator_transliterate($transliterator, $requestData['trtext']);
            return response()->json(['message' => $transliterated]);
        } else {
            return response()->json(['message' => 'Missing trtext parameter']);
        }
    }
    public function combineArrays()
    {
        $arrayOne = ['el', 'ab', 'cd'];
        $arrayTwo = ['y5', 'y6', 'y7'];

        $result = [];
        $count = count($arrayOne);

        for ($i = 0; $i < $count; $i++) {
            $result[] = $arrayOne[$i] . '-' . $arrayTwo[$count - 1 - $i];
        }

        return response()->json(['message' => $result]);
    }

    public function createFiles()
    {
        $baseDir = 'storage_data/original';
        $fileCount = 4;
        $fileNameLength = 5;

        $folderCount = rand(2, 3);
        $subfolderCount = 3;
        $extensions = ['jpg', 'txt', 'php', 'md'];

        $created = $this->fileService->createFoldersAndFiles($baseDir, $fileCount, $fileNameLength, $folderCount, $subfolderCount, $extensions);

        $this->fileService->copyDirectory($baseDir, 'storage_data/copy');

        $this->fileService->renameFiles($baseDir);

        $jpgFiles = $this->fileService->listJpgFiles($baseDir);

        return response()->json(['message' => $jpgFiles]);
    }

    public function createCSV()
    {
        $arrayOne = [
            'name' => 'some name',
            'age' => 5,
            'city' => 'some town',
        ];

        $arrayTwo = [
            'age' => 6,
            'country' => 'small country',
            'city' => 'mego city',
            'street' => 'cute ave.'
        ];

        $csvFileName = 'testfile.csv';

        $headers = array_unique(array_merge(array_keys($arrayOne), array_keys($arrayTwo)));

        $combinedData = [];
        foreach ($headers as $header) {
            $valueOne = isset($arrayOne[$header]) ? $arrayOne[$header] : '';
            $valueTwo = isset($arrayTwo[$header]) ? $arrayTwo[$header] : '';

            if ($valueOne !== '' && $valueTwo !== '') {
                $combinedData[$header] = "{$valueOne}, {$valueTwo}";
            } elseif ($valueOne !== '') {
                $combinedData[$header] = $valueOne;
            } else {
                $combinedData[$header] = $valueTwo;
            }
        }

        $csvData = [];
        $csvData[] = array_values($combinedData);

        $csvFilePath = $this->fileService->createCSV($csvFileName, $headers, $csvData);

        return response()->json(['message' => "CSV file has been generated at: $csvFilePath"]);
    }

    public function parseWebpage()
    {
        $url = 'https://en.wikipedia.org/wiki/PHP'; // URL to parse

        try {
            $result = $this->webParserService->parseWebpage($url);

            $jsonFileName = 'parsed_data_' . time() . '.json'; // Generate a unique filename
            $jsonFilePath = storage_path('app/public/' . $jsonFileName); // Adjust path as needed
            $jsonData = [
                'links' => $result['links'],
                'images' => $result['images']
            ];

            file_put_contents($jsonFilePath, json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            return response()->json([
                'message' => 'JSON file created successfully!' . ' file path:' . asset('storage/' . $jsonFileName),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function fetchDataAndExportToCSV()
    {
        // $results = Category::with('products')->get(); // using if asscociation table has foreign key

        // SELECT categories.c_name, products.p_name
        // FROM associations
        // JOIN products ON associations.p_id = products.p_id
        // JOIN categories ON associations.c_id = categories.c_id;

        $results = DB::table('associations')
        ->join('products', 'associations.p_id', '=', 'products.p_id')
        ->join('categories', 'associations.c_id', '=', 'categories.c_id')
        ->select('categories.c_name', 'products.p_name')
        ->get();

        $csvData = $results->map(function ($item) {
            return (array) $item;
        })->toArray();

        $headers = ['c_name', 'p_name'];
        $csvFileName = 'result_db.csv';

        $csvFilePath = $this->fileService->createCSV($csvFileName, $headers, $csvData);
        return response()->json([
            'message' => 'File path: ' . $csvFilePath
        ]);
    }

    public function handleDBDuplicates()
    {
        if (Schema::hasTable('test_table')) {
            Schema::drop('test_table');
        }

        DB::statement('CREATE TABLE test_table (id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, `key` VARCHAR(255))');
        DB::table('test_table')->insert([
            ['key' => 'prod'],
            ['key' => 'cat'],
            ['key' => 'prod'],
            ['key' => 'key'],
            ['key' => 'key'],
        ]);
        $distinctKeys = DB::table('test_table')
            ->select('key', DB::raw('MAX(id) as id'))
            ->groupBy('key')
            ->pluck('id');

        DB::table('test_table')->whereNotIn('id', $distinctKeys)->delete();

        return response()->json([
            'message' => 'File path: ' . $distinctKeys
        ]);
    }
}
