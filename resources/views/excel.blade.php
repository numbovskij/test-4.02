<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items List</title>
    @vite('resources/js/bootstrap.js')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f8f8f8;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .pagination {
            display: flex;
            justify-content: center;
            list-style-type: none;
            padding: 0;
        }

        .pagination li {
            margin: 5px;
        }

        .pagination a {
            text-decoration: none;
            color: #333;
            padding: 5px 10px;
            border: 1px solid #ddd;
            background-color: #fff;
        }

        .pagination a:hover {
            background-color: #f8f8f8;
        }

        .pagination .active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .pagination .disabled {
            color: #6c757d;
            pointer-events: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-2xl font-semibold leading-tight text-gray-800">
        Items List
    </h1>
    <table id="data-table">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $date => $rows)
            <tr>
                <td>{{ $date }}</td>
                <td>
                    <table>
                        @foreach($rows as $row)
                            <tr>
                                <td>{{ $row['id'] }}</td>
                                <td>{{ $row['name'] }}</td>
                                <td>{{ $row['date'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script type="module"> // the change is here
  Echo.channel('rows')
    .listen('RowCreated', (e) => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${e.row.date}</td>
        <td>
        <table><tr>
        <td>${e.row.id}</td>
        <td>${e.row.name}</td>
        <td>${e.row.date}</td>
        </tr></table>
        </td>
      `;
      document.getElementById('data-table').querySelector('tbody').prepend(tr);
    });
</script>
</body>
</html>
