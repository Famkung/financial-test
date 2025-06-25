<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายงานจำนวนสมาชิกตามอายุ</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>รายงานจำนวนสมาชิกตามอายุ</h1>

    <canvas id="ageChart" width="600" height="400"></canvas>

    <table border="1" cellpadding="8" cellspacing="0" style="margin-top:20px;">
        <thead>
            <tr>
                <th>อายุ</th>
                <th>จำนวนสมาชิก</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ageGroups as $age => $count)
            <tr>
                <td>{{ $age }}</td>
                <td>{{ $count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        const ctx = document.getElementById('ageChart').getContext('2d');

        const ageLabels = {!! json_encode($ageGroups->keys()) !!};
        const ageCounts = {!! json_encode($ageGroups->values()) !!};

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ageLabels,
                datasets: [{
                    label: 'จำนวนสมาชิก',
                    data: ageCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true, precision: 0 }
                }
            }
        });
    </script>
      @include('layouts.footer-buttons')
</body>
</html>