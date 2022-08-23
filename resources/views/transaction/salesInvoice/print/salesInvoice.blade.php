<!DOCTYPE html>
<html>

<head>
    <title>
        SI : {{$si->head[0]->NO_BUKTI}}
    </title>

    <style>
        @page {
            margin-top: 1.5rem;
            margin-right: 2rem;
            margin-bottom: 1.5rem;
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
            margin-top: 10px;
            margin-bottom: 10px;
            margin-left: 20px;
            margin-right: 20px;
            -webkit-print-color-adjust: exact !important;
            /* margin: 0; */
            font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }

        /* 
        .tableBorder {
            border-spacing: 0;
            border: 0.5px;
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
            padding: 0.5px;
            border: 0.5px solid #000;
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

<body style="font-size: 12px;">
    <div style="padding:0px; box-sizing: border-box; position: relative;">
        <div class="container-fluid">
            <table class="table tableBorder" style="width: 100%; height:auto; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th height="2rem" style="width: 5%;"><span></span></th>
                        <th height="2rem" style="width: 5%;"><span></span></th>
                        <th height="2rem" style="width: 20%;"><span></span></th>
                        <th height="2rem" style="width: 20%;"><span></span></th>
                        <th height="2rem" style="width: 10%;"><span></span></th>
                        <th height="2rem" style="width: 12%;"><span></span></th>
                        <th height="2rem" style="width: 13%;"><span></span></th>
                        <th height="2rem" style="width: 15%;"><span></span></th>
                    </tr>
                    <tr>
                        <th colspan="3" style="text-align:left; vertical-align: top; font-size:12px;">
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">{{strtoupper($si->company[0]->name)}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">{{$si->company[0]->address1}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">{{$si->company[0]->address2}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">{{$si->company[0]->city." - ".$si->company[0]->postal_code." - ".strtoupper($si->company[0]->country)}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">Phone {{$si->company[0]->phone}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">Fax {{$si->company[0]->fax}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">Email : {{$si->company[0]->email}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">{{$si->company[0]->tax_id}}</span></div>
                        </th>
                        <th colspan="3" style="vertical-align: bottom;">
                            <div class="column" style="width: 100%;"><span style="font-weight: bold; font-size: 18px">SALES INVOICE</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold; font-size: 14px">{{$si->head[0]->no_bukti2}}</span></div>
                        </th>
                        <th colspan="2" style="vertical-align: top;"><img src="{{ asset('images/apps/logo.png')}}" style="max-width: 100%;"></th>
                    </tr>
                    <tr>
                        <th height="2rem"><span></span></th>
                        <th height="2rem"><span></span></th>
                        <th height="2rem"><span></span></th>
                        <th height="2rem"><span></span></th>
                        <th height="2rem"><span></span></th>
                        <th height="2rem"><span></span></th>
                        <th height="2rem"><span></span></th>
                        <th height="2rem"><span></span></th>
                    </tr>
                    <tr>
                        <th colspan="2" style="text-align:left; vertical-align: top; font-size:12px;">
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">CUSTOMER :</span></div>
                        </th>
                        <th colspan="3" style="text-align:left; vertical-align: top; font-size:12px;">
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">{{strtoupper($si->head[0]->NM_CUST)}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">{{strtoupper($si->head[0]->alamatkirim)}}</span></div>
                        </th>
                        <th style="text-align:left; vertical-align: top; font-size:12px;">
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">Date </span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">Currency </span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">Your PO No. </span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">Our DO No. </span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">Due Date </span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">Sales </span></div>
                        </th>
                        <th colspan="2" style="text-align:left; vertical-align: top; font-size:12px;">
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">: {{date_format(date_create($si->head[0]->TGL_BUKTI),"d/m/Y")}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">: {{$si->head[0]->curr}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">: {{$si->detail[0]->PO_CUST}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">: {{$si->do}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">: {{date_format(date_create($si->head[0]->tgl_due),"d/m/Y")}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">: {{$si->detail[0]->NM_SALES}}</span></div>
                        </th>
                    </tr>
                    <tr>
                        <th height="2rem"><span></span></th>
                        <th height="2rem"><span></span></th>
                        <th height="2rem"><span></span></th>
                        <th height="2rem"><span></span></th>
                        <th height="2rem"><span></span></th>
                        <th height="2rem"><span></span></th>
                        <th height="2rem"><span></span></th>
                        <th height="2rem"><span></span></th>
                    </tr>
                    <tr>
                        <th style="border: 0.5px solid #000;"><span style="font-weight: bold;">No</span></th>
                        <th colspan="3" style="border: 0.5px solid #000;"><span style="font-weight: bold;">Item Description</span></th>
                        <th style="border: 0.5px solid #000;"><span style="font-weight: bold;">Qty</span></th>
                        <th style="border: 0.5px solid #000;"><span style="font-weight: bold;">Unit Price</span></th>
                        <th style="border: 0.5px solid #000;"><span style="font-weight: bold;">Disc</span></th>
                        <th style="border: 0.5px solid #000;"><span style="font-weight: bold;">Amount</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $j = 15;
                    ?>
                    @foreach($si->detail as $det)
                    @if(empty($det->kode_group))
                    <tr style="vertical-align: top; font-weight:bold;">
                        <td style="border: 0.5px solid #000; ;text-align:right;border-bottom: 0px;border-top:0px;">{{$i}}.</td>
                        <td style="border: 0.5px solid #000;border-bottom: 0px; border-top:0px;" colspan="3"><?= str_replace(array("\r\n", "\n"), '<br/>', $det->NM_STOCK) ?></td>
                        <td style="border: 0.5px solid #000;text-align:center;border-bottom: 0px;border-top:0px;">{{number_format($det->QTY,0)}} {{$det->SAT}}</td>
                        <td style="border: 0.5px solid #000;text-align:right;border-bottom: 0px;border-top:0px; padding-right:10px;">{{number_format($det->HARGA,2)}}</td>
                        <td style="border: 0.5px solid #000;text-align:right;border-bottom: 0px;border-top:0px; padding-right:10px;">{{number_format($det->JMLDISKON,2)}}</td>
                        <td style="border: 0.5px solid #000;text-align:right;border-bottom: 0px;border-top:0px; padding-right:10px;">{{number_format($det->JUMLAHNETTO,2)}} </td>
                    </tr>
                    <?php
                    $i++;
                    $j--; ?>
                    @endif
                    @endforeach
                    <?php for ($k = 0; $k < $j; $k++) { ?><tr>
                            <td style="border: 0.5px solid #000; ;text-align:right;border-bottom: 0px;border-top:0px;">&nbsp;</td>
                            <td style="border: 0.5px solid #000;border-bottom: 0px; border-top:0px;" colspan="3"></td>
                            <td style="border: 0.5px solid #000;text-align:center;border-bottom: 0px;border-top:0px;"></td>
                            <td style="border: 0.5px solid #000;text-align:right;border-bottom: 0px;border-top:0px; padding-right:10px;"></td>
                            <td style="border: 0.5px solid #000;text-align:right;border-bottom: 0px;border-top:0px; padding-right:10px;"></td>
                            <td style="border: 0.5px solid #000;text-align:right;border-bottom: 0px;border-top:0px; padding-right:10px;"></td>
                        </tr>
                    <?php } ?>
                    <tr style="border: none; border-top: 0.5px solid #000">
                        <td height="2rem"><span></span></td>
                        <td height="2rem"><span></span></td>
                        <td height="2rem"><span></span></td>
                        <td height="2rem"><span></span></td>
                        <td height="2rem"><span></span></td>
                        <td height="2rem"><span></span></td>
                        <td height="2rem"><span></span></td>
                        <td height="2rem"><span></span></td>
                    </tr>
                    <tr style="text-align: left;">
                        <td colspan="5" style="text-align: left; vertical-align: top; font-weight:bold">Say : #
                            <?php
                            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                            echo $f->format($si->head[0]->total_rp);
                            ?>
                        </td>
                        <td colspan="2" style="text-align: right; font-weight:bold;">
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">Total Ammount : IDR</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">Down Payment : IDR</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">Discount : IDR</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">VAT : IDR</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">TOTAL INV : IDR</span></div>
                        </td>
                        <td style="text-align: right; font-weight:bold;padding-right:10px">
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;"> {{number_format($si->detail[0]->totdpp_rp,2)}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;"> {{number_format($si->head[0]->totdpp_rp,2)}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;"> {{number_format($si->head[0]->rp_disch,2)}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;"> {{number_format($si->head[0]->totppn_rp,2)}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;"> {{number_format($si->head[0]->total_rp,2)}}</span></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="100%" height="2rem"><span></span></td>
                    </tr>
                    <tr>
                        <td colspan="6" style="height:auto; vertical-align: top;">
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">Remark</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">For payment, please transfer FULL AMOUNT to one the following account : </span><br /><br /></div>
                            <div class="column" style="width: 50%;">
                                <?php
                                $bank1 = "bank1" . $format;
                                $bank2 = "bank2" . $format;
                                ?>
                                <span style="font-weight: bold;"><?php print_r(str_replace(array("\r\n", "\n"), '<br/>', $si->company_bank[0]->$bank1)) ?></span>
                            </div>
                            <div class="column" style="width: 50%;">
                                <span style="font-weight: bold;"><?php print_r(str_replace(array("\r\n", "\n"), '<br/>', $si->company_bank[0]->$bank2)) ?></span>
                            </div>
                        </td>
                        <td colspan="2" style="text-align: left; vertical-align:midle; padding-left: 5rem;">
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">Finance,</span></div>
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            @foreach($topManagement as $tm4)
                            @if($tm4->code=='TM4')
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">{{ucwords(strtolower($tm4->full_name))}}</span></div>
                            @endif
                            @endforeach
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