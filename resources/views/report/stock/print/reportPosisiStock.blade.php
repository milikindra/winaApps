<!DOCTYPE html>
<html>

<head>
    <title>
        Report Posisi Stock
    </title>

    <style>
        @page {
            margin: 10px 20px;
        }

        body {
            margin: 10px 20px;
        }

        .tableBorder {
            border-spacing: 0;
            border: 0px;
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
        }

        .tableBorder th {
            padding: 3px;
            border-spacing: 0;
            border: 0.5px solid #ddd;
            text-align: center;
        }

        .tableBorder td {
            border-spacing: 0;
            padding: 8px;
            border: 0.5px solid #ddd;
        }

        table .bottom {
            width: 100%;
            table-layout: fixed;
        }

        .fixed-bottom {
            width: 100%;
        }

        ol {
            vertical-align: top;
            margin: 5px 0;
            padding-left: 22px;
            font-family: helvetica, sans-serif;
            font-size: 10px;
        }

        ol li {
            font-family: helvetica, sans-serif;
            font-size: 10px;
        }

        .footer {
            font-family: helvetica, sans-serif;
            font-size: 8px;
            position: fixed;
            left: 62%;
            bottom: -45px;
            right: 0;
            height: 80px;
        }

        .footer .page:after {
            font-family: helvetica, sans-serif;
            font-size: 8px;
            content: "Printed Date : "+ date('d-m-Y H:i:s') + " | Page "+counter(page);
        }

        .footer .page {
            font-family: helvetica, sans-serif;
            font-size: 8px;
        }
    </style>
</head>

<body>
    <div class="footer">
        <span class="page"></span>
    </div>
    <div style="padding:0px; box-sizing: border-box; position: relative;">
        <!-- <div style=";border-bottom:2px solid #ddd;margin-bottom:10px; position: relative;">
                <img height="50px" src="{{ asset('images/apps/company.png') }}" alt="WINA">
            </div> -->
        <h4 style="font-family: helvetica,sans-serif;text-align: center;margin-top: 0px;margin-bottom: 5px;">Report Posisi Stock</h4>
        <div style="display: inline-block; clear: both; position: static; margin-bottom: 0px; width: 100%;">
            <h6 style="font-family: helvetica,sans-serif;text-align: center;margin-top: 0px;margin-bottom: 5px;">Gudang : {{ $lokasi }}</h6>
            <h6 style="font-family: helvetica,sans-serif;text-align: center;margin-top: 0px;margin-bottom: 5px;">{{ $edate }}</h6>
        </div>
        <table class="tableBorder fixed-bottom" style="margin-top: 5px; clear: both; top: 80px;">
            <thead>
                <tr style="border-collapse: collapse; border: 2px solid #ddd;">
                    <th style="font-family: helvetica,sans-serif;font-size: 10px; font-weight: 700;" width="10%">Kode</th>
                    <th style="font-family: helvetica,sans-serif;font-size: 10px; font-weight: 700;" width="10%">Nama Barang</th>
                    <th style="font-family: helvetica,sans-serif;font-size: 10px; font-weight: 700;" width="10%">Satuan</th>
                    <th style="font-family: helvetica,sans-serif;font-size: 10px; font-weight: 700;" width="10%">Qty</th>
                    <th style="font-family: helvetica,sans-serif;font-size: 10px; font-weight: 700;" width="10%">Total</th>
                    <th style="font-family: helvetica,sans-serif;font-size: 10px; font-weight: 700;" width="10%">Harga Rata-rata</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                $total_rata = 0;
                foreach ($posisiStock as $posisi) {
                    $total += $posisi->jml_pok;
                    $total_rata += $posisi->rata;
                ?>
                    <tr>
                        <td style="font-family: helvetica,sans-serif;font-size: 9px; font-weight: 500;">{{$posisi->no_stock }}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 9px; font-weight: 500;">{{$posisi->nm_stock }}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 9px; font-weight: 500; text-align:center;">{{$posisi->sat}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 9px; font-weight: 500; text-align:right;">{{number_format($posisi->qty,2) }}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 9px; font-weight: 500; text-align:right;">{{number_format($posisi->jml_pok,2) }}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 9px; font-weight: 500; text-align:right;">{{number_format($posisi->rata,2) }}</td>
                    </tr>
                <?php } ?>
                <tr>
                    <td style="font-family: helvetica,sans-serif;font-size: 9px; font-weight: 500; text-align:right;" colspan="4"><b>Total</b></td>
                    <td style="font-family: helvetica,sans-serif;font-size: 9px; font-weight: 500; text-align:right;">{{number_format($total,2) }}</td>
                    <td style="font-family: helvetica,sans-serif;font-size: 9px; font-weight: 500; text-align:right;">{{number_format($total_rata,2) }}</td>
                </tr>
            </tbody>
        </table>


    </div>

</html>
<script type="text/javascript">
    window.onafterprint = window.close;
    window.print();
</script>