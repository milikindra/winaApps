<!DOCTYPE html>
<html>

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
    <div class="footer">
        <span class="page"></span>
    </div>
    <div style="padding:0px; box-sizing: border-box; position: relative;">
        <!-- <div style=";border-bottom:2px solid #ddd;margin-bottom:10px; position: relative;">
                <img height="50px" src="{{ asset('images/apps/company.png') }}" alt="WINA">
            </div> -->
        <h4 style="font-family: helvetica,sans-serif;text-align: center;margin-top: 0px;margin-bottom: 5px;">{{$title}}</h4>
        <div style="display: inline-block; clear: both; position: static; margin-bottom: 0px; width: 100%;">
            <h5 style="font-family: helvetica,sans-serif;text-align: center;margin-top: 0px;margin-bottom: 5px;">{{$subtitle}}</h5>
        </div>
        <div style="display: inline-block; clear: both; position: static; margin-bottom: 0px; width: 100%;">
            <h6 style="font-family: helvetica,sans-serif;text-align: center;margin-top: 0px;margin-bottom: 5px;"></h6>
        </div>
        <div class="container-fluid">
            <table>
                <?php foreach ($filter as $key => $value) { ?>
                    <tr>
                        <td><strong>{{$key}}</strong></td>
                        <td>: {{$value}}</td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <br />
        <div class="container-fluid">
            <table class="table tableBorder" id="tr" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Transaction Name</th>
                        <th>Transaction Number</th>
                        <th style=" text-align:center" colspan="2">Description</th>
                    </tr>
                    <tr>
                        <th style="text-indent:5rem">Account Number</th>
                        <th style="text-indent:5rem">Account Name</th>
                        <th style="text-indent:5rem">Prime</th>
                        <th style="text-align:center">Debet</th>
                        <th style="text-align:center">Credit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($body as $b) {
                        $totalDebet = 0;
                        $totalKredit = 0; ?>
                        <tr style="border: #000">
                            <td style="width: 7%;">{{date_format(date_create($b->head->tgl_bukti), 'd-m-Y') }}</td>
                            <td style="width: 7%;">{{$b->head->trx}}</td>
                            <td style="width: 7%;">{{$b->head->no_bukti}}</td>
                            <td style="width: 7%;" colspan="2">{{$b->head->uraian}}</td>
                        </tr>
                        <?php foreach ($b->child as $c) { ?>
                            <tr>
                                <td style="width: 7%;text-align:left; text-indent:5rem">{{$c->no_rek}}</td>
                                <td style="width: 7%;text-align:left; text-indent:5rem">{{$c->nm_rek}}</td>
                                <td style="width: 7%;text-align:left; text-indent:5rem">-</td>
                                <td style="width: 7%;text-align:right">{{number_format($c->debet)}}</td>
                                <td style="width: 7%;text-align:right">{{number_format($c->kredit)}}</td>
                            </tr>
                        <?php
                            $totalDebet += $c->debet;
                            $totalKredit += $c->kredit;
                        } ?>
                        <tr style="background-color: #ddd;">
                            <td colspan="3" style="text-align: right;">Total of : {{$b->head->trx}}</td>
                            <td style="text-align: right;">{{number_format($totalDebet)}}</td>
                            <td style="text-align: right;">{{number_format($totalKredit)}}</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
<script type="text/javascript">
    // window.onafterprint = window.close;
    window.print();
</script>