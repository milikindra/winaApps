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
                        <th style="text-align: center;  border: 1px solid #000000;">Supplier</th>
                        <th style="text-align: center;  border: 1px solid #000000;">PI</th>
                        <th style="text-align: center;  border: 1px solid #000000;">PI Date</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Due Date</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Invoice</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Currency</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Total</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Payment Paid</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Age</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Due In 1 Week</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Due In 2 Weeks</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Overdue < 15 days</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Overdue 15 - 30 days</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Overdue 31 - 60 days</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Overdue > 60 days</th>
                        <th style="text-align: center;  border: 1px solid #000000;">On Scheduled</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Total (IDR)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($body as $b)
                    @if(substr($b->nm_supplier,0,17) == 'Total Outstanding')
                    <tr style="font-weight: bold;">
                        @else
                    <tr>
                        @endif
                        <?php
                        $tgl_bukti = ($b->tgl_bukti != '') ? date_format(date_create($b->tgl_bukti), 'd-m-Y') : '';
                        $tgl_due = ($b->tgl_due != '') ? date_format(date_create($b->tgl_due), 'd-m-Y') : '';
                        $total = ($b->total != '') ? number_format($b->total, 2) : '';
                        $paid = ($b->paid != '') ? number_format($b->paid, 2) : '';
                        $overdue_1_14 = ($b->overdue_1_14 != '') ? number_format($b->overdue_1_14, 2) : '';
                        $overdue_15_30 = ($b->overdue_15_30 != '') ? number_format($b->overdue_15_30, 2) : '';
                        $overdue_31_60 = ($b->overdue_31_60 != '') ? number_format($b->overdue_31_60, 2) : '';
                        $overdue_60 = ($b->overdue_60 != '') ? number_format($b->overdue_60, 2) : '';
                        $in_1_weeks = ($b->in_1_weeks != '') ? number_format($b->in_1_weeks, 2) : '';
                        $in_2_weeks = ($b->in_2_weeks != '') ? number_format($b->in_2_weeks, 2) : '';
                        $on_schedule = ($b->on_schedule != '') ? number_format($b->on_schedule, 2) : '';
                        $total_idr = ($b->total_idr != '') ? number_format($b->total_idr, 2) : '';
                        ?>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black;" width="15%">{{$b->nm_supplier}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black;" width="7%">{{$b->no_pi}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black;" width="7%">{{$tgl_bukti }}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black;" width="7%">{{$tgl_due }}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black;" width="7%">{{$b->no_inv}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black;" width="7%">{{$b->currency}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{$total}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{$paid}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right;" width=" 7%">{{$b->age}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{$in_1_weeks}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{$in_2_weeks}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{$overdue_1_14}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{$overdue_15_30}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{$overdue_31_60}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{$overdue_60}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{$on_schedule}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black; text-align:right" width="7%">{{$total_idr}}</td>
                    </tr>
                    @if(!empty($b->internal_notes))
                    <tr>
                        <td colspan="100%" style="font-family: helvetica,sans-serif;font-size: 10px;border: thin solid black;">Notes : <i>{{$b->internal_notes}}</i></td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
<script type="text/javascript">
</script>