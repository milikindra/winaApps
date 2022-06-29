<!DOCTYPE html>
<html>
<!-- DataTables -->

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
            -webkit-print-color-adjust: exact !important;
            /* margin: 0; */
            font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }

        .tableBorder {
            border-spacing: 0;
            border: 1px;
            border-collapse: collapse;
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


<body>
    <div style="padding:0px; box-sizing: border-box; position: relative;">
        <!-- <div style=";border-bottom:2px solid #ddd;margin-bottom:10px; position: relative;">
                <img height="50px" src="{{ asset('images/apps/company.png') }}" alt="WINA">
            </div> -->
        <h4 style="font-family: helvetica,sans-serif;text-align: center;margin-top: 0px;margin-bottom: 5px;">{{$title}}</h4>
        <div style="display: inline-block; clear: both; position: static; margin-bottom: 0px; width: 100%;">
            <h5 style="font-family: helvetica,sans-serif;text-align: center;margin-top: 0px;margin-bottom: 5px;">{{$subtitle}}</h5>
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
                        <th style="text-align: center;">Supplier</th>
                        <th style="text-align: center;">PI</th>
                        <th style="text-align: center;">PI Date</th>
                        <th style="text-align: center;">Due Date</th>
                        <th style="text-align: center;">Invoice</th>
                        <th style="text-align: center;">Currency</th>
                        <th style="text-align: center;">Total</th>
                        <th style="text-align: center;">Payment Paid</th>
                        <th style="text-align: center;">Age</th>
                        <th style="text-align: center;">Overdue < 15 days</th>
                        <th style="text-align: center;">Overdue 15 - 30 days</th>
                        <th style="text-align: center;">Overdue 31 - 60 days</th>
                        <th style="text-align: center;">Overdue > 60 days</th>
                        <th style="text-align: center;">Due In 1 Week</th>
                        <th style="text-align: center;">Due In 2 Weeks</th>
                        <th style="text-align: center;">On Scheduled</th>
                        <th style="text-align: center;">Total (IDR)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($body as $b)
                    <tr>
                        <td style="width: 20%; border-right:none;">{{$b->nm_supplier}}</td>
                        <td style="width: 15%; border-right:none;">{{$b->no_pi}}</td>
                        <td style="width: 5%; border-right:none;text-align:center;">{{date_format(date_create($b->tgl_bukti), 'd-m-Y') }}</td>
                        <td style="width: 5%; border-right:none;text-align:center;">{{date_format(date_create($b->tgl_due), 'd-m-Y') }}</td>
                        <td style="width: 15%; border-right:none;">{{$b->no_inv}}</td>
                        <td style="width: 5%; border-right:none;text-align:center;">{{$b->currency}}</td>
                        <td style="width: 5%; border-right:none;text-align:right;">{{accDollars($b->total)}}</td>
                        <td style="width: 5%; border-right:none;text-align:right;">{{accDollars($b->paid)}}</td>
                        <td style="width: 5%; border-right:none;">{{$b->age}}</td>
                        <td style="width: 5%; border-right:none; text-align:right;">{{accDollars($b->overdue_1_14)}}</td>
                        <td style="width: 5%; border-right:none; text-align:right;">{{accDollars($b->overdue_15_30)}}</td>
                        <td style="width: 5%; border-right:none; text-align:right;">{{accDollars($b->overdue_31_60)}}</td>
                        <td style="width: 5%; border-right:none; text-align:right;">{{accDollars($b->overdue_60)}}</td>
                        <td style="width: 5%; border-right:none; text-align:right;">{{accDollars($b->in_1_weeks)}}</td>
                        <td style="width: 5%; border-right:none; text-align:right;">{{accDollars($b->in_2_weeks)}}</td>
                        <td style="width: 5%; border-right:none; text-align:right;">{{accDollars($b->on_schedule)}}</td>
                        <td style="width: 5%; text-align:right;">{{accDollars($b->total_idr)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
<script type="text/javascript">
    // window.onafterprint = window.close;
    // window.print();
</script>