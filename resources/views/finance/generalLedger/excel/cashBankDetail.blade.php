<!DOCTYPE html>
<html>
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.css')}}" />

<style>
</style>

<head>
    <title>
        {{$title}}
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
            border: 1px;
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
        }

        .tableBorder th {
            padding: 3px;
            border-spacing: 0;
            border: 1px solid #fff;
            background-color: #000;
            color: #fff;
            text-align: left;
            font-size: 12px;
        }

        .tableBorder td {
            border-spacing: 0;
            padding: 1px;
            border: 1px solid #ccc;
            font-size: 10px;
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

        .form-control:disabled,
        .form-control[readonly] {
            background-color: #fff;
        }
    </style>
</head>
<?php
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=" . $title . ".xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
echo "Some Text"; //no ending ; here
?>

<body>
    <div class="footer">
        <span class="page"></span>
    </div>
    <div style="padding:0px; box-sizing: border-box; position: relative;">
        <!-- <div style=";border-bottom:2px solid #ddd;margin-bottom:10px; position: relative;">
                <img height="50px" src="{{ asset('images/apps/company.png') }}" alt="WINA">
            </div> -->
        <h4 style="font-family: helvetica,sans-serif;text-align: center;margin-top: 0px;margin-bottom: 5px;">{{$title}}</h4>
        <div style="display: inline-block; clear: both; position: static; margin-bottom: 0px; width: 100%;">
            <h6 style="font-family: helvetica,sans-serif;text-align: center;margin-top: 0px;margin-bottom: 5px;">{{$subtitle}}</h6>
        </div>
        <div style="display: inline-block; clear: both; position: static; margin-bottom: 0px; width: 100%;">
            <h6 style="font-family: helvetica,sans-serif;text-align: center;margin-top: 0px;margin-bottom: 5px;">{{$filter}}</h6>
        </div>
        <br />
        <br />
        <div class="container-fluid">
            <table class="table tableBorder" id="tr" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="text-align: center;  border: 1px solid #000000;">No. Account</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Account Name</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Transaction Number</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Date</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Description</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Debet (IDR)</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Credit (IDR)</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Saldo (IDR)</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Debet (Valas)</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Credit (Valas)</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Saldo (Valas)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($body as $b)
                    <tr>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black;" width="7%">{{$b->NO_REK}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black;" width="7%">{{$b->NM_REK}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black;" width="7%">{{$b->Nomor}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black;" width="7%">{{date_format(date_create($b->tgl_bukti), 'd-m-Y') }}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black;" width="7%">{{$b->uraian}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{accDollars($b->debet)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{accDollars($b->kredit)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{accDollars($b->saldo)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{accDollars($b->debet_us)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{accDollars($b->kredit_us)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{accDollars($b->saldo_valas)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
<script type="text/javascript">
</script>