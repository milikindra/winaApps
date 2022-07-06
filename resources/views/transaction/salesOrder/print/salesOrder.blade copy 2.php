<!DOCTYPE html>
<html>

<head>
    <title>
        SO : {{$so->head[0]->NO_BUKTI}}
    </title>

    <style>
        /* @media print {
            header {
                position: fixed;
                top: 0;
            }

            .content-block,
            p {
                page-break-inside: avoid;
            }

            html,
            body {
                width: 210mm;
                height: 297mm;
            }
        } */


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

        /* .tableBorder th {
            padding: 3px;
            border-spacing: 0;
            border: 1px solid #fff;
            background-color: #000;
            color: #fff;
            text-align: left;
            font-size: 12px;
        } */

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

        table.report-container {
            page-break-after: always;
        }

        thead.report-header {
            display: table-header-group;
        }

        tfoot.report-footer {
            display: table-footer-group;
        }

        table.report-container div.article {
            page-break-inside: avoid;
        }
    </style>
</head>

<body style="font-size: 11px;">
    <table class="report-container">
        <thead class="report-header">
            <tr>
                <th class="report-header-cell">
                    <div class="header-info">
                        <table class="table tableBorder" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th width="25%"><img src="{{ asset('images/apps/logo.png')}}" style="max-width: 80%;"></th>
                                    <th></th>
                                    <th width="10%" rowspan="6"></th>
                                    <th style="border-bottom: 1px solid #000; border-collapse: collapse; vertical-align: bottom; text-align: left;">
                                        <span style="padding: 0px; font-weight: bold; font-size: 21px;">Sales Order</span>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="2" style="text-align: left;padding-left:2rem;border:1px solid #000; height:auto">
                                        Customer
                                    </th>
                                    <th rowspan="5" width="40%" style="vertical-align: top; text-align: left;">
                                        <table width="100%">
                                            <tr>
                                                <td width="25%">SO</td>
                                                <td>: <span style="font-weight: normal;">{{$so->head[0]->NO_BUKTI}}</span></td>
                                            </tr>
                                            <tr>
                                                <td>Date</td>
                                                <td>: <span style="font-weight: normal;">{{$so->head[0]->TGL_BUKTI}}</span></td>
                                            </tr>
                                            <tr>
                                                <td>PO</td>
                                                <td>: <span style="font-weight: normal;">{{$so->head[0]->PO_CUST}}</span></td>
                                            </tr>
                                            <tr>
                                                <td>Due Date</td>
                                                <td>: <span style="font-weight: normal;">{{$so->head[0]->tgl_due}}</span></td>
                                            </tr>
                                            <tr>
                                                <td>Term</td>
                                                <td>: <span style="font-weight: normal;">{{$so->head[0]->TEMPO}} days</span></td>
                                            </tr>
                                            <tr>
                                                <td>Salesman</td>
                                                <td>: <span style="font-weight: normal;">{{$so->head[0]->ID_SALES}}</span></td>
                                            </tr>
                                            <tr>
                                                <td>Quotation</td>
                                                <td>: <span style="font-weight: normal;">{{$so->head[0]->no_ref}}</span></td>
                                            </tr>
                                            <tr>
                                                <td>Dept.</td>
                                                <td>: <span style="font-weight: normal;">{{$so->head[0]->Dept}}</span></td>
                                            </tr>
                                            <tr>
                                                <td>BU</td>
                                                <td>: <span style="font-weight: normal;">{{$so->head[0]->DIVISI}}</span></td>
                                            </tr>
                                        </table>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="2" style="text-align: left;padding-left:1rem;border:1px solid #000;">
                                        <div style="min-height: 5rem; font-weight: normal;">
                                            {{$so->head[0]->NM_CUST}}<br />
                                            <?= str_replace(array("\r\n", "\n"), '<br/>', $so->head[0]->ALAMAT1)  ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr style="border: none;">
                                    <th colspan="2" height="2rem"></th>
                                </tr>
                                <tr>
                                    <th colspan="2" style="text-align: left; padding-left:2rem;border:1px solid #000;">
                                        Ship To
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="2" style="text-align: left; vertical-align: top; padding-left:1rem;border:1px solid #000;">
                                        <div style="min-height: 5rem; font-weight: normal;"><?= str_replace(array("\r\n", "\n"), '<br/>', $so->head[0]->alamatkirim) ?></div>
                                    </th>
                                </tr>
                                <tr colspan="4" style="height: 1rem;"></tr>

                            </thead>
                        </table>
                    </div>
                </th>
            </tr>
        </thead>
        <!-- <tfoot class="report-footer">
            <tr>
                <td class="report-footer-cell">
                    <div class="footer-info">
                        footer
                    </div>
                </td>
            </tr>
        </tfoot> -->
        <tbody class="report-content">
            <tr>
                <td class="report-content-cell">
                    <div class="main">
                        <table class="table tableBorder" style="width: 100%; height:auto;">
                            <thead>
                                <tr>
                                    <th style="border: 1px solid #000;" width="5%">No</th>
                                    <th style="border: 1px solid #000;" width="25%">Item No</th>
                                    <th style="border: 1px solid #000;" width="60%">Description</th>
                                    <th style="border: 1px solid #000;" width="10%">Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($so->detail as $det)
                                <tr style="vertical-align: top;">
                                    <td style="border: 1px solid #ccc; text-align:right;">{{$i}}.</td>
                                    <td style="border: 1px solid #ccc;">{{$det->NO_STOCK}}</td>
                                    <td style="border: 1px solid #ccc;"><?= str_replace(array("\r\n", "\n"), '<br/>', $det->NM_STOCK) ?></td>
                                    <td style="border: 1px solid #ccc;text-align:center;">{{number_format($det->QTY,0)}} {{$det->SAT}}</td>
                                </tr>
                                <?php $i++ ?>
                                @endforeach
                            </tbody>
                        </table>
                        <br />
                        <table class="table tableBorder" width="100%">
                            <tr style="text-align: left; border:none">
                                <th style="border: 1px solid #000;padding-left:1rem; height:auto" width="20%">
                                    Add Spec :
                                </th>
                                <th></th>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000;padding-left:0.5rem;" colspan="2">
                                    <div style="min-height:5rem">
                                        <?= str_replace(array("\r\n", "\n"), '<br/>', $so->head[0]->KETERANGAN) ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <br />
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
                                    @foreach($topManagement as $tm3)
                                    @if($tm3->code=='TM3')
                                    {{ucwords(strtolower($tm3->full_name))}}
                                    @endif
                                    @endforeach<br />
                                    Date :
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
<script type="text/javascript">
    // window.onafterprint = window.close;
    // window.print();
</script>