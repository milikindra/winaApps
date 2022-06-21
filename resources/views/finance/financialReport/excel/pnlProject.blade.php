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
                        <th style="text-align: center;  border: 1px solid #000000;">Description</th>
                        <th style="text-align: center;  border: 1px solid #000000;" colspan="2">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($body as $b)
                    @if($b->uraian !='')
                    @if($b->tipe == "X")
                    <tr>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black;" width="7%"><strong>{{$b->uraian}}</strong></td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:right" width="7%"></td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:right" width="7%"></td>
                    </tr>
                    @elseif($b->tipe == "T")
                    <tr>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black;" width="7%"><strong>{{$b->uraian}}</strong></td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:right" width="7%"><strong>{{accDollars($b->nilai)}}</strong></td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:right" width="7%"><strong>{{accDollars($b->prosentase)}}</strong>%</td>
                    </tr>
                    @else
                    <tr>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black;" width="7%">{{$b->uraian}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:right" width="7%">{{accDollars($b->nilai)}}</td>
                        <td style="font-family: helvetica,sans-serif;font-size: 10px; border: thin solid black; text-align:right" width="7%">{{accDollars($b->prosentase)}}%</td>
                    </tr>
                    @endif
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