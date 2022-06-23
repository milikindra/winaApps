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
                    <tr style="text-align: center;">
                        <th>SO</th>
                        <th>SO Date</th>
                        <th>SO Type</th>
                        <th>Customer</th>
                        <th>Sales</th>
                        <th>PO</th>
                        <th>Tag</th>
                        <th>Last DO</th>
                        <th>Payment Date</th>
                        <th>Age</th>
                        <th>CR Create Date</th>
                        <th>Revenue</th>
                        <th>COGS</th>
                        <th>In Ordered</th>
                        <th>Stock In Hand</th>
                        <th>Item Adjusment</th>
                        <th>Gross Profit</th>
                        <th>Gross Profit(%)</th>
                        <th>Expense</th>
                        <th>Ass Exp</th>
                        <th>Profit</th>
                        <th>Net Profit (%)</th>
                        <th>PH</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($body as $b)
                    <tr>
                        <td>{{$b->no_SO}}</td>
                        <td style="text-align:center;">{{date_format(date_create($b->tgl_SO), 'd-m-Y') }}</td>
                        <td style="text-align: center;">{{$b->jenisSO}}</td>
                        <td>{{$b->nm_cust}}</td>
                        <td>{{$b->Sales}}</td>
                        <td>{{$b->no_po}}</td>
                        <td style="text-align: center;">{{$b->Tag}}</td>
                        <td style="text-align: center;">{{date_format(date_create($b->tgl_Last_DO), 'd-m-Y') }}</td>
                        <td style="text-align: center;">{{$b->tgl_clear == null ? '-': date_format(date_create($b->tgl_clear), 'd-m-Y')}}</td>
                        <td style="text-align: center;">{{$b->umur == null ? '-': $b->umur}}</td>
                        <td style="text-align: center;">{{date_format(date_create($b->tgl_create_cr), 'd-m-Y') }}</td>
                        <td style="text-align: right;">{{accDollars($b->REVENUE)}}</td>
                        <td style="text-align: right;">{{accDollars($b->COGS)}}</td>
                        <td style="text-align: right;">{{accDollars($b->InOrdered)}}</td>
                        <td style="text-align: right;">{{accDollars($b->StockInHand)}}</td>
                        <td style="text-align: right;">{{accDollars($b->ItemAdjustment)}}</td>
                        <td style="text-align: right;">{{accDollars($b->Gross_Profit)}}</td>
                        <td style="text-align: right;">{{accDollars($b->prosen1)}}%</td>
                        <td style="text-align: right;">{{accDollars($b->other_exp)}}</td>
                        <td style="text-align: right;">{{accDollars($b->Ass_Exp)}}</td>
                        <td style="text-align: right;">{{accDollars($b->Profit)}}</td>
                        <td style="text-align: right;">{{accDollars($b->prosen2)}}%</td>
                        <td>{{$b->note_PH}}</td>
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