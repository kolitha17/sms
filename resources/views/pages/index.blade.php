<!-- resources/views/surveys/index.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Survey Data</title>
</head>
<body>

<h1>Survey Data</h1>

@if (isset($data) && is_array($data))
    <ul>
        @foreach ($data as $item)
            <li>
                <strong>Item:</strong>
                <ul>
                    @foreach ($item as $key => $value)
                        <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
@else
    <p>No data available.</p>
@endif

</body>
</html>
