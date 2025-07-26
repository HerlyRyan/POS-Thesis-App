@props([
    'title' => 'Laporan',
    'companyName' => 'PT. Nama Perusahaan',
    'companyAddress' => 'Alamat lengkap perusahaan',
    'companyPhone' => '-',
    'companyEmail' => '-',
    'reportTitle' => 'Judul Laporan',
    'period' => 'Semua Waktu',
])


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Laporan' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 1cm;
        }

        /* Adjust header to be a flex container for horizontal layout */
        header {
            text-align: center; /* This will center the block content within the header */
            display: flex; /* Enable flexbox */
            flex-direction: column;
            align-items: center; /* Vertically center items */
            justify-content: space-between; /* Distribute items with space between them */
            margin-bottom: 20px; /* Space below the header block */
            border-bottom: 1px solid #000; /* Line under the header */
            padding-bottom: 10px; /* Padding for the line */
            page-break-after: avoid; /* Prevent page break right after the header section */
        }

        .company-logo {
            flex-shrink: 0; /* Prevent logo from shrinking */
            width: 100px; /* Adjust logo container width */
            text-align: center; /* Center logo within its container */
        }

        .company-logo img {
            width: 80px; /* Adjust logo image size */
            height: auto;
            display: block; /* Remove extra space below image */
            margin: 0 auto; /* Center the image horizontally */
        }

        /* Main company info (text) block */
        .company-info {
            flex-grow: 1; /* Allow company info to take available space */
            text-align: center; /* Center the text content */
            display: flex;
            flex-direction: column;
            justify-content: center; /* Vertically center content */
            gap: 2px; /* Small gap between lines of text */
            margin: 0 15px; /* Add some horizontal margin between logo and text */
        }

        .company-info h1 {
            font-size: 1.1em; /* Adjust font size to fit */
            margin: 0;
            line-height: 1.2; /* Tighter line spacing */
            font-weight: bold; /* Make the first line bold as in image */
            text-transform: uppercase; /* Match uppercase from image */
        }

        .company-info p {
            font-size: 0.9em; /* Smaller font size for address/contact */
            margin: 0;
            line-height: 1.2; /* Tighter line spacing */
        }              

        /* The actual report title and period */
        .report-header-section {
            text-align: center;
            margin-bottom: 20px;
            margin-top: 10px; /* Space after the company info block */
            page-break-after: avoid;            
        }

        h2 {
            font-size: 1.4em; /* Larger font for report title */
            margin: 10px 0 5px 0;
            page-break-after: avoid;
            font-weight: bold;
        }

        .meta {
            text-align: center;
            margin-bottom: 20px;
            page-break-after: avoid;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            page-break-inside: auto;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            page-break-inside: avoid;
        }

        th {
            background-color: #f2f2f2;            
        }

        .text-right {
            text-align: right;
        }

        .mt-20 {
            margin-top: 20px;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 10px;
            border-top: 1px solid #000;
            padding: 5px;
            page-break-before: avoid;
        }

        /* Print-specific styles */
        @media print {
            body {
                margin: 0;
            }

            @page {
                size: A4;
                margin: 1cm;
            }

            header {
                position: running(header); /* For more complex header repetition */
                padding-bottom: 5px; /* Adjust padding for print */
                border-bottom: 1px solid #000; /* Ensure the line prints */
            }

            footer {
                position: running(footer); /* For more complex footer repetition */
            }

            h1, h2, h3, h4, h5, h6 {
                page-break-after: avoid;
            }

            table, img, pre, blockquote {
                page-break-before: auto;
                page-break-inside: avoid;
            }

            .new-page {
                page-break-before: always;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <header class="report-header">
        <div class="company-logo">
            <img src="{{ asset('/storage/logo.png') }}" alt="Logo Galam Sani">
        </div>
        <div class="company-info">
            <h1>{{$companyName}}</h1>
            <p>{{$companyAddress}}</p>            
            <p>Kontak: {{$companyPhone}} Email: {{$companyEmail}}</p>
        </div>    
    </header>

    <div class="report-header-section">
        <h2>{{ $reportTitle ?? 'Judul Laporan' }}</h2>
        <div class="meta">
            Periode:
            {{ $period ?? 'Semua Waktu' }}
        </div>
    </div>


    <main>
        {{ $slot }}
    </main>

    <footer>
        Dicetak pada {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </footer>

    {{-- <script>
        window.print();
    </script> --}}
</body>

</html>