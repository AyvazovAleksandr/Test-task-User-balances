<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operations</title>
    @vite('resources/css/app.css')
</head>
<body>
<div id="app">
    <input type="text" id="search" placeholder="Search by description">
    <table>
        <thead>
        <tr>
            <th>Date</th>
            <th>Description</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody id="operations-table">
        <!-- Operations will be populated here -->
        </tbody>
    </table>
</div>
@vite('resources/js/app.js')
</body>
</html>
