<!DOCTYPE html>
<html>
<link rel="stylesheet" href="{{ asset('plugins\jquery-ui\jquery-ui.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins\jquery-ui\jquery-ui.theme.min.css')}}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">

<link rel="stylesheet" href="{{ asset('dist/css/adminlte.css')}}" />
<link rel="stylesheet" href="{{ asset('dist/css/custom.css')}}" />

<style>
</style>

<head>
    <title>
        Report Helper Transmital Receipt
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
            border: 0px;
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
        }

        .tableBorder th {
            padding: 3px;
            border-spacing: 0;
            border: 0.5px solid #ddd;
            text-align: center;
        }

        .tableBorder td {
            border-spacing: 0;
            padding: 8px;
            border: 0.5px solid #ddd;
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
        <h4 style="font-family: helvetica,sans-serif;text-align: center;margin-top: 0px;margin-bottom: 5px;">TRANSMITAL/TANDA TERIMA DOKUMEN</h4>
        <div style="display: inline-block; clear: both; position: static; margin-bottom: 0px; width: 100%;">
            <h6 style="font-family: helvetica,sans-serif;text-align: center;margin-top: 0px;margin-bottom: 5px;"></h6>
        </div>
        <div style="display: inline-block; clear: both; position: static; margin-bottom: 0px; width: 100%;">
            <h6 style="font-family: helvetica,sans-serif;text-align: center;margin-top: 0px;margin-bottom: 5px;"></h6>
        </div>
        <div class="container-fluid">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Customer</label>
                <div class="col-sm-4">
                    <label>: {{$val['trNmCustomer']}}</label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-4">
                    <label>: {{$val['trAddress']}}</label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">To</label>
                <div class="col-sm-4">
                    <label>: {{$val['trTo']}}</label>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <table class="table" id="tr" style="width: 100%;">
                <thead>
                    <tr>
                        <th width="5%" style="text-align: center;  border: 1px solid #000000;">No.</th>
                        <th width="40%" style="text-align: center;  border: 1px solid #000000;">Document</th>
                        <th style="text-align: center;  border: 1px solid #000000;">Description</th>
                    </tr>
                </thead>
                <?php
                $no = 0;
                foreach ($val['row'] as $block) {
                    $no++;
                ?>
                    <tbody style=" border: 1px solid #000000;">
                        <tr>
                            <td style="text-align: right;">{{$no}}</td>
                            <td style="border-left:1px solid #000"> {{$block[0][0]}}</td>
                            <td style="border-left:1px solid #000"> {{$block[0][1]}}</td>
                        </tr>

                        <?php
                        foreach (array_slice($block, 1) as $row) {
                        ?>
                            <tr>
                                <td></td>
                                <td style="border-left:1px solid #000">{{$row[0]}}</td>
                                <td style="border-left:1px solid #000">{{$row[1]}}</td>
                            </tr>
                        <?php } ?>

                        <tr style="height: 1px;" height="1px">
                            <td colspan="3" style="border-bottom: 1px solid #000; padding:0px"></td>
                        </tr>
                    </tbody>
                <?php } ?>
            </table>
        </div>
        <div class="container-fluid">
            <div class="form-group row justify-content-md-center">
                <div class="col-sm-8">
                    <input class="custom-control-input custom-control-input-dark custom-control-input-outline" type="checkbox" id="trReturnCb">
                    <label for="trReturnCb" class="custom-control-label">PLEASE RETURN DUPLICATE COPY THIS TRANSMITAL WITH SIGNATURE </label>
                </div>
            </div>
            <div class="form-group row justify-content-md-center">
                <div class="col-sm-8 form-inline">
                    <input class="custom-control-input custom-control-input-dark custom-control-input-outline" type="checkbox" id="trEmailCb">
                    <label for="trEmailCb" class="custom-control-label">Email to : </label>
                    <input type="email" class="form-control form-control-border" name="trEmailCb" style="width: 40%;" id="trEmailCb" value="fiance-ar@viktori-automation.com">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Received By</label>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-border" name="trReceivedName" id="trReceivedName">
                </div>
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-border" name="trSenderdName" id="trSenderdName" value="{{$val['trSenderdName']}}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Date</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-border" name="trReceiveDate" id="trReceiveDate">
                </div>
                <label class="col-sm-2 col-form-label">Date</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control form-control-border" name="trSenderdName" id="trSenderdName" value="{{date_format(date_create($val['trReceiveDate']),'Y-m-d')}}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Signature</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-border" name="trReceivedName" id="trReceivedName">
                </div>
                <label class="col-sm-2 col-form-label">Signature</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-border" name="trReceivedName" id="trReceivedName">
                </div>
            </div>
        </div>
    </div>

</body>

</html>
<script type="text/javascript">
    // window.onafterprint = window.close;
    // window.print();
</script>