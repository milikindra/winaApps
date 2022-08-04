<!DOCTYPE html>
<html>

<head>
    <title>
        SO : {{$so->head[0]->NO_BUKTI}}
    </title>

    <style>
        @page {
            margin-top: 2rem;
            margin-bottom: 4rem;
        }

        @media print {
            .home-page-footer {
                display: none;
            }

            footer {
                display: block;
                position: fixed;
                bottom: 0;
            }

            header {
                display: none;
                position: fixed;
                top: 0;
            }

            /* a[href]:after {
                display: none;
                visibility: hidden;
            } */

            a[href]:after {
                content: " ("attr(href) ")";
            }

        }


        body {
            margin: 10px 20px;
            -webkit-print-color-adjust: exact !important;
            /* margin: 0; */
            font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }

        /* 
        .tableBorder {
            border-spacing: 0;
            border: 1px;
            border-collapse: collapse;
        } */

        .table {
            display: table;
            height: 100px;
            width: 100%;
            table-layout: fixed;
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
        }


        /* .tableBorder td {
            border-spacing: 0;
            padding: 1px;
            border: 1px solid #000;
            font-size: 10px;
        } */

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

        .form-control:disabled,
        .form-control[readonly] {
            background-color: #fff;
        }

        .column {
            float: left;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>

<body style="font-size: 11px;">
    <div style="padding:0px; box-sizing: border-box; position: relative;">
        <div class="container-fluid">
            <table class="table tableBorder" style="width: 100%; height:auto; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th height="2rem" style="width: 5%;"><span></span></th>
                        <th height="2rem" style="width: 20%;"><span></span></th>
                        <th height="2rem" style="width: 25%;"><span></span></th>
                        <th height="2rem" style="width: 15%;"><span></span></th>
                        <th height="2rem" style="width: 5%;"><span></span></th>
                        <th height="2rem" style="width: 25%;"><span></span></th>
                        <th height="2rem" style="width: 10%;"><span></span></th>
                    </tr>
                    <tr>
                        <th colspan="2"><img src="{{ asset('images/apps/logo.png')}}" style="max-width: 80%;"></th>
                        <th></th>
                        <th></th>
                        <th rowspan="6"></th>
                        <th colspan="2" style="border-bottom: 1px solid #000; border-collapse: collapse; vertical-align: bottom; text-align: left;">
                            <span style="padding: 0px; font-weight: bold; font-size: 21px;">Sales Order</span>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4" style="text-align: left;padding-left:2rem;border:1px solid #000; height:auto">Customer</th>
                        <th rowspan="5" colspan="2" style="vertical-align: top; text-align: left;">
                            <div class="row">
                                <div class="column" style="width: 25%;">SO</div>
                                <div class="column" style="width: 75%;">: <span style="font-weight: normal;">{{$so->head[0]->NO_BUKTI}}</span></div>
                            </div>
                            <div class="row">
                                <div class="column" style="width: 25%;">Date</div>
                                <div class="column" style="width: 75%;">: <span style="font-weight: normal;">{{date_format(date_create($so->head[0]->TGL_BUKTI),'d-m-Y')}}</span></div>
                            </div>
                            <div class="row">
                                <div class="column" style="width: 25%;">PO</div>
                                <div class="column" style="width: 75%;">: <span style="font-weight: normal;">{{$so->head[0]->PO_CUST}}</span></div>
                            </div>
                            <div class="row">
                                <div class="column" style="width: 25%;">Due Date</div>
                                <div class="column" style="width: 75%;">: <span style="font-weight: normal;">{{date_format(date_create($so->head[0]->tgl_due),'d-m-Y')}}</span></div>
                            </div>
                            <div class="row">
                                <div class="column" style="width: 25%;">Term</div>
                                <div class="column" style="width: 75%;">: <span style="font-weight: normal;">{{$so->head[0]->TEMPO}} days</span></div>
                            </div>
                            <div class="row">
                                <div class="column" style="width: 25%;">Salesman</div>
                                <div class="column" style="width: 75%;">: <span style="font-weight: normal;">{{$so->head[0]->ID_SALES}}</span></div>
                            </div>
                            <div class="row">
                                <div class="column" style="width: 25%;">Quotation</div>
                                <div class="column" style="width: 75%;">: <span style="font-weight: normal;">{{$so->head[0]->no_ref}}</span></div>
                            </div>
                            <div class="row">
                                <div class="column" style="width: 25%;">Dept.</div>
                                <div class="column" style="width: 75%;">: <span style="font-weight: normal;">{{$so->head[0]->Dept}}</span></div>
                            </div>
                            <div class="row">
                                <div class="column" style="width: 25%;">BU</div>
                                <div class="column" style="width: 75%;">: <span style="font-weight: normal;">{{$so->head[0]->DIVISI}}</span></div>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4" style="text-align: left;padding-left:1rem;border:1px solid #000;">
                            <div style="font-weight: normal;">
                                {{$so->head[0]->NM_CUST}}<br />
                                <?= str_replace(array("\r\n", "\n"), '<br/>', $so->head[0]->ALAMAT1)  ?>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4" height="2rem"></th>
                    </tr>
                    <tr>
                        <th colspan="4" style="text-align: left; padding-left:2rem;border:1px solid #000;">
                            Ship To
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4" style="text-align: left; padding-left:1rem;border:1px solid #000;">
                            <div style="font-weight: normal;"><?= str_replace(array("\r\n", "\n"), '<br/>', $so->head[0]->alamatkirim) ?></div>
                        </th>
                    </tr>
                    <tr>
                        <th height="2rem" style="width: 5%;"><span></span></th>
                        <th height="2rem" style="width: 20%;"><span></span></th>
                        <th height="2rem" style="width: 25%;"><span></span></th>
                        <th height="2rem" style="width: 15%;"><span></span></th>
                        <th height="2rem" style="width: 5%;"><span></span></th>
                        <th height="2rem" style="width: 25%;"><span></span></th>
                        <th height="2rem" style="width: 10%;"><span></span></th>
                    </tr>
                    <tr>
                        <th style="border: 1px solid #000;">No</th>
                        <th style="border: 1px solid #000;">Item No</th>
                        <th style="border: 1px solid #000;" colspan="4">Description</th>
                        <th style="border: 1px solid #000;">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach($so->detail as $det)
                    <tr style="vertical-align: top;">
                        <td style="border: 1px solid #ccc; text-align:right;">{{$i}}.</td>
                        <td style="border: 1px solid #ccc;">{{$det->NO_STOCK}}</td>
                        <td style="border: 1px solid #ccc;" colspan="4"><?= str_replace(array("\r\n", "\n"), '<br/>', $det->NM_STOCK) ?></td>
                        <td style="border: 1px solid #ccc;text-align:center;">{{number_format($det->QTY,0)}} {{$det->SAT}}</td>
                    </tr>
                    <?php $i++ ?>
                    @endforeach
                    <tr style="border: none;">
                        <td style="height: 1rem;"><span></span></td>
                        <td><span></span></td>
                        <td><span></span></td>
                        <td><span></span></td>
                        <td><span></span></td>
                        <td><span></span></td>
                        <td><span></span></td>
                    </tr>
                    <tr style="text-align: left;">
                        <td style="border: 1px solid #000;padding-left:1rem; height:auto; font-weight: bold;" colspan="2">
                            Add Spec :
                        </td>
                        <td colspan="5"><span><br /></span></td>

                    </tr>
                    <tr>
                        <td style="border: 1px solid #000;padding-left:0.5rem;" colspan="7">
                            <div style="min-height:2rem">
                                <?= str_replace(array("\r\n", "\n"), '<br/>', $so->head[0]->KETERANGAN) ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7"><span><br /></span></td>
                    </tr>
                    <tr>
                        <td colspan="7">
                            <table width="100%">
                                <tr>
                                    <td width="30%">Sales,
                                        <br />
                                        <br />
                                        <br />
                                        <br />
                                        {{ucwords(strtolower($so->head[0]->NM_SALES))}}<br />
                                        Date :
                                    </td>
                                    <td width="40%">Sales Manager,
                                        <br />
                                        <br />
                                        <br />
                                        <br />
                                        @foreach($topManagement as $tm2)
                                        @if($tm2->code=='TM2')
                                        {{ucwords(strtolower($tm2->full_name))}}
                                        @endif
                                        @endforeach<br />
                                        Date :
                                    </td>
                                    <td width="30%">Processed By,
                                        <br />
                                        <br />
                                        <br />
                                        <br />
                                        @foreach($topManagement as $tm6)
                                        @if($tm6->code=='TM6')
                                        {{ucwords(strtolower($tm6->full_name))}}
                                        @endif
                                        @endforeach<br />
                                        Date :
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div id="content">
                <div id="pageFooter">
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