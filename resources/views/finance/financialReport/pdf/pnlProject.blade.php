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
                        <th style="text-align: center;" width="70%">Description</th>
                        <th style="text-align: center;" colspan="2">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($body as $b)
                    @if($b->uraian !='')
                    @if($b->tipe == "T")
                    <tr style="background-color: #ddd;">
                        @else
                    <tr>
                        @endif
                        @if($b->tipe == "X")
                        <td style="width: 70%; border-right:none;"><strong>{{$b->uraian}}</strong></td>
                        <td style="width: 20%; text-align:right;border-left:none;border-right:none;"></td>
                        <td style="width: 10%; text-align:right;border-left:none;"></td>
                        @else
                        @if($b->tipe == "T")
                        <td style="width: 70%; border-right:none;"><strong>{{$b->uraian}}</strong></td>
                        <td style="width: 20%; text-align:right;border-left:none;border-right:none;"><strong>{{accDollars($b->nilai)}}</strong></td>
                        <td style="width: 10%; text-align:right;border-left:none;"><strong>{{accDollars($b->prosentase)}}%</strong></td>
                        @else
                        <td style="width: 70%; border-right:none;">{{$b->uraian}}</td>
                        @if($b->nilai == null)
                        <td style="width: 20%; border-left:none;border-right:none;"></td>
                        @else
                        <td style="width: 20%; text-align:right;border-left:none;border-right:none;">{{accDollars($b->nilai)}}</td>
                        @endif
                        @if($b->prosentase == null)
                        <td style="width: 10%; border-left:none;"></td>
                        @else
                        <td style="width: 10%; text-align:right;border-left:none;">{{accDollars($b->prosentase)}}%</td>
                        @endif
                        @endif
                        @endif
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
    // window.onafterprint = window.close;
    // window.print();
</script>