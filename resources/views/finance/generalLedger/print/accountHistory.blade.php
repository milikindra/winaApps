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
                        @foreach($head as $h)
                        <th style="text-align: center;  border: 1px solid #000000;">{{$h}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($body as $b)
                    <tr>
                        <td style="width: 7%;">{{$b->no_rek}}</td>
                        <td style="width: 18%;">{{$b->nm_rek}}</td>
                        <td style="width: 10%;">{{$b->no_bukti}}</td>
                        <td style="width: 10%;">{{date_format(date_create($b->tgl_bukti), 'd-m-Y') }}</td>
                        <td style="width: 10%;">{{$b->no_SO}}</td>
                        <td style="width: 10%;">{{$b->id_kyw}}</td>
                        <td style="width: 10%;">{{$b->uraian}}</td>
                        <td style="width: 5%; text-align:right">{{number_format($b->debet)}}</td>
                        <td style="width: 5%; text-align:right">{{number_format($b->kredit)}}</td>
                        <td style="width: 10%; text-align:right">{{number_format($b->saldo)}}</td>
                        <td style="width: 5%; text-align:right">{{number_format($b->debet_us)}}</td>
                        <td style="width: 5%; text-align:right">{{number_format($b->kredit_us)}}</td>
                        <td style="width: 10%; text-align:right">{{number_format($b->saldo_valas)}}</td>
                        <td style="word-wrap: break-word">{{wordwrap($b->dept,10,'<br>\n')}}</td>
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
    window.print();
</script>