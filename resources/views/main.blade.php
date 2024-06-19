<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main View</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}"></script>
</head>
<body>
    <h1>Main View</h1>

    <!-- Email Validator Section -->
    <div id="message" class="message"></div>
    <div id="email-validator">
        <h2>Email Validator</h2>
        <form id="emailForm">
            <input type="text" name="email" id="email" placeholder="Enter email">
            <button type="submit">Validate</button>
        </form>
    </div>

    <div id="transliterator">
        <h2>Transliterator</h2>
        <form id="transliteratorForm">
            <input type="text" name="trtext" id="tr_input" placeholder="Enter string">
            <button type="submit">Transliterate</button>
        </form>
    </div>

    <div id="combine-arrays">
        <h2>Combine Arrays</h2>
        <form id="combineArraysForm">
            <p>Array 1 - ['el', 'ab', 'cd']</p>
            <p>Array 2 - ['y5', 'y6', 'y7']</p>
            <button type="submit">Combine Arrays</button>
        </form>
    </div>

    <div id="folders-image-handler">
        <h2>Creating folders with files, get images</h2>
        <form id="foldersImageHandler">
            <p>Creating some folders, files and get .jpg files</p>
            <button type="submit">Process</button>
        </form>
    </div>

    <div id="create-csv">
        <h2>Creating CSV file with content from 2 arrays</h2>
        <form id="createCsv">
            <p>
                $arrayOne = [
                    'name' => 'some name',
                    'age' => 5,
                    'city' => 'some town'
                ];
            </p>
            <p>
                $arrayTwo = [
                    'age' => 6,
                    'country' => 'small country',
                    'city' => 'mego city',
                    'street' => 'cute ave.'
                ];
            </p>
            <button type="submit">Process</button>
        </form>
    </div>

    <div id="page-parser">
        <h2>Parsing a page from https://en.wikipedia.org/wiki/PHP </h2>
        <form id="pageParser">
            <button type="submit">Process</button>
        </form>
    </div>

    <div id="db-fetcher">
        <h2>Fetching data from DB</h2>
        <form id="fetchDb">
            <button type="submit">Process</button>
        </form>
    </div>

    <div id="db-duplicate-remover">
        <h2>Creating table and remove duplicates</h2>
        <form id="handleDb">
            <button type="submit">Process</button>
        </form>
    </div>
</body>
</html>