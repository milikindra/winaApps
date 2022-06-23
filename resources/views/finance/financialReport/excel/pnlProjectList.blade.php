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

        .fixed-bottom {
            width: 100%;
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
        <div class="container-fluid">
        </div>
        <br />
        <br />
        <div class="container-fluid">
            <table class="table tableBorder" id="tr" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="text-align: center;  border: 1px solid #000000;">SO</th>
                        <th style="text-align: center;  border: 1px solid #000000;">SO Date</th>
                        <th style="text-align: center;  border: 1px solid #000000;">SO Type</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Customer</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Sales</th>
                        <th style="text-align: center;  border: 1px solid #000000;">PO</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Tag</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Last DO</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Payment Date</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Age</th>
                        <th style="text-align: center;  border: 1px solid #000000;">CR Create Date</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Revenue</th>
                        <th style="text-align: center;  border: 1px solid #000000;">COGS</th>
                        <th style="text-align: center;  border: 1px solid #000000;">In Ordered</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Stock In Hand</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Item Adjusment</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Gross Profit</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Gross Profit(%)</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Expense</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Ass Exp</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Profit</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Net Profit (%)</th>
                        <th style="text-align: center;  border: 1px solid #000000;">PH</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($body as $b)
                    <tr>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black;" width="7%">{{$b->no_SO}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:center;" width="7%">{{date_format(date_create($b->tgl_SO), 'd-m-Y') }}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:center;" width="7%">{{$b->jenisSO}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black;" width="7%">{{$b->nm_cust}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black;" width="7%">{{$b->Sales}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black;" width="7%">{{$b->no_po}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:center;" width="7%">{{$b->Tag}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:center;" width="7%">{{date_format(date_create($b->tgl_Last_DO), 'd-m-Y') }}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:center;" width="7%">{{$b->tgl_clear == null ? '-': date_format(date_create($b->tgl_clear), 'd-m-Y')}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:center;" width="7%">{{$b->umur == null ? '-': $b->umur}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:center;" width="7%">{{date_format(date_create($b->tgl_create_cr), 'd-m-Y') }}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:right;" width="7%">{{accDollars($b->REVENUE)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:right;" width="7%">{{accDollars($b->COGS)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:right;" width="7%">{{accDollars($b->InOrdered)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:right;" width="7%">{{accDollars($b->StockInHand)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:right;" width="7%">{{accDollars($b->ItemAdjustment)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:right;" width="7%">{{accDollars($b->Gross_Profit)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:right;" width="7%">{{accDollars($b->prosen1)}}%</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:right;" width="7%">{{accDollars($b->other_exp)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:right;" width="7%">{{accDollars($b->Ass_Exp)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:right;" width="7%">{{accDollars($b->Profit)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:right;" width="7%">{{accDollars($b->prosen2)}}%</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black;" width="7%">{{$b->note_PH}}</td>
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