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
            border: 1px solid #000;
            text-align: center;
        }

        .tableBorder td {
            border-spacing: 0;
            padding: 8px;
            border: 1px solid #000;
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
                        <th style="text-align: center;  border: 1px solid #000000;" id="no-sort">Customer</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Invoice</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Invoice Date</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Due Date</th>
                        <th style="text-align: center;  border: 1px solid #000000;">PO</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Total</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Sales</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Overdue > 100 days</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Overdue 1 - 30 days</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Overdue 31 - 60 days</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Overdue 61 - 100 days</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Not Due</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Grand Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($body as $b)
                    <tr>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black;" width="15%">{{$b->nm_cust}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black;" width="7%">{{$b->no_inv}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black;" width="7%">{{date_format(date_create($b->tgl_bukti), 'd-m-Y') }}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black;" width="7%">{{date_format(date_create($b->tgl_due), 'd-m-Y') }}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black;" width="7%">{{$b->no_po}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{number_format($b->total,2)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black;" width="7%">{{$b->sales}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{number_format($b->overdue_100,2)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{number_format($b->overdue_1_30,2)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{number_format($b->overdue_31_60,2)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{number_format($b->overdue_61_100,2)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{number_format($b->notdue,2)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{number_format($b->sisa,2)}}</td>
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