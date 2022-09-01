<!DOCTYPE html>
<html>

<head>
    <script>
        function subst() {
            var vars = {};
            var query_strings_from_url = document.location.search.substring(1).split('&');
            for (var query_string in query_strings_from_url) {
                if (query_strings_from_url.hasOwnProperty(query_string)) {
                    var temp_var = query_strings_from_url[query_string].split('=', 2);
                    vars[temp_var[0]] = decodeURI(temp_var[1]);
                }
            }
            var css_selector_classes = ['page', 'frompage', 'topage', 'webpage', 'section', 'subsection', 'date', 'isodate', 'time', 'title', 'doctitle', 'sitepage', 'sitepages'];
            for (var css_class in css_selector_classes) {
                if (css_selector_classes.hasOwnProperty(css_class)) {
                    var element = document.getElementsByClassName(css_selector_classes[css_class]);
                    for (var j = 0; j < element.length; ++j) {
                        element[j].textContent = vars[css_selector_classes[css_class]];
                    }
                }
            }
        }
    </script>
    <title>
        SI : {{$si->head[0]->NO_BUKTI}}
    </title>

    <style>
        @media print {
            @page {
                size: auto;
                /* margin: 20mm 0 10mm 0; */
                /* margin-top: 100cm;
                margin-right: 1rem;
                margin-right: 1rem;
                margin-bottom: 3rem; */
            }

            body {
                display: table;
                table-layout: fixed;
                /* padding-top: 2.5cm; */
                /* padding-bottom: 2.5cm; */
                height: auto;
            }

            table {
                page-break-before: auto
            }

            div {
                page-break-before: auto
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto
            }

            td {
                page-break-inside: avoid;
                page-break-after: auto
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group
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
            /* margin-top: 20px; */
            /* margin-bottom: 20px; */
            /* margin-left: 20px; */
            /* margin-right: 20px; */
            -webkit-print-color-adjust: exact !important;
            font-family: "sans-serif", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }

        .table {
            display: table;
            /* height: 100px; */
            width: 100%;
        }

        tbody {
            height: auto;
            min-height: 200px;
            display: contents
        }

        .footer {
            font-family: sans-serif;
            font-size: 8px;
            position: fixed;
            left: 62%;
            bottom: -45px;
            right: 0;
            height: 80px;
        }


        .column {
            float: left;
        }

        /* .row:after {
            content: "";
            display: table;
            clear: both;
        } */
    </style>
</head>

<body style="font-size: 12px;">
    <div style="padding:0px; box-sizing: border-box; position: relative;">
        <div class="container-fluid">
            <table class="table tableBorder" id="tb" style="width: 100%; height:auto; border-collapse: collapse;">
                <thead>
                    <!-- <tr>
                        <th style="width: 6%;"><span></span></th>
                        <th style="width: 5%;"><span></span></th>
                        <th style="width: 20%;"><span></span></th>
                        <th style="width: 20%;"><span></span></th>
                        <th style="width: 10%;"><span></span></th>
                        <th style="width: 12%;"><span></span></th>
                        <th style="width: 12%;"><span></span></th>
                        <th style="width: 15%;"><span></span></th>
                    </tr> -->
                    <tr>
                        <th colspan="3" style="text-align:left; vertical-align: top; font-size:14px;">
                            <!-- <div class="column" style="width: 100%;"><span style="font-weight: bold;">{{strtoupper($si->company[0]->name)}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">{{$si->company[0]->address1}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">{{$si->company[0]->address2}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">{{$si->company[0]->city." - ".$si->company[0]->postal_code." - ".strtoupper($si->company[0]->country)}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">Phone {{$si->company[0]->phone}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">Fax {{$si->company[0]->fax}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">Email : {{$si->company[0]->email}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">{{$si->company[0]->tax_id}}</span></div> -->
                        </th>
                        <th colspan="3" style="vertical-align: bottom;">
                        </th>
                        <th colspan="2" style="vertical-align: top;"><img src="{{ asset('images/apps/logo.png')}}" style="max-width: 100%;"></th>
                    </tr>
                    <tr>
                        <th colspan="3" style="text-align:left; vertical-align: top; font-size:14px;">
                        </th>
                        <th colspan="3" style="vertical-align: bottom;">
                            <div class="column" style="width: 100%;"><span style="font-weight: bold; font-size: 18px">SALES INVOICE</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold; font-size: 14px">{{$si->head[0]->no_bukti2}}</span></div>
                        </th>
                    </tr>
                    <tr>
                        <th style="width: 6%;"><span></span></th>
                        <th style="width: 5%;"><span></span></th>
                        <th style="width: 10%;"><span></span></th>
                        <th style="width: 20%;"><span></span></th>
                        <th style="width: 15%;"><span></span></th>
                        <th style="width: 15%;"><span></span></th>
                        <th style="width: 10%;"><span></span></th>
                        <th style="width: 10%;"><span></span></th>
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
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">: {{$si->so[0]->PO_CUST}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">: {{$si->do}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">: {{date_format(date_create($si->head[0]->tgl_due),"d/m/Y")}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: normal;">: {{$si->head[0]->NM_SALES}}</span></div>
                        </th>
                    </tr>
                    <tr>
                        <th style="font-size: 4px;">&nbsp;</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
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
                    $j = 10;
                    ?>
                    @foreach($si->detail as $det)
                    @if(empty($det->kode_group))
                    <tr style="vertical-align: top; font-weight:normal;">
                        <td style="border: 0.5px solid #000; ;text-align:right;border-bottom: 0px;border-top:0px;">{{$i}}.</td>
                        <td style="border: 0.5px solid #000;border-bottom: 0px; border-top:0px;" colspan="3"><?= str_replace(array("\r\n", "\n"), '<br/>', $det->NM_STOCK) ?></td>
                        <td style="border: 0.5px solid #000;text-align:center;border-bottom: 0px;border-top:0px;">{{number_format($det->QTY,0)}} {{$det->SAT}}</td>
                        <td style="border: 0.5px solid #000;text-align:right;border-bottom: 0px;border-top:0px; padding-right:10px;">{{number_format($det->HARGA,2)}}</td>
                        <td style="border: 0.5px solid #000;text-align:right;border-bottom: 0px;border-top:0px; padding-right:10px;">{{number_format($det->JMLDISKON,2)}}</td>
                        <td style="border: 0.5px solid #000;text-align:right;border-bottom: 0px;border-top:0px; padding-right:10px;">{{number_format(($det->HARGA*$det->QTY)-$det->JMLDISKON,2)}} </td>
                    </tr>
                    <tr>
                        <td style="font-size: 4px;border: 0.5px solid #000;border-bottom: 0px;border-top:0px;">&nbsp;</td>
                        <td style="border: 0.5px solid #000;border-bottom: 0px; border-top:0px;" colspan="3"></td>
                        <td style="border: 0.5px solid #000;border-bottom: 0px;border-top:0px;"></td>
                        <td style="border: 0.5px solid #000;border-bottom: 0px;border-top:0px; "></td>
                        <td style="border: 0.5px solid #000;border-bottom: 0px;border-top:0px; "></td>
                        <td style="border: 0.5px solid #000;border-bottom: 0px;border-top:0px; "></td>
                    </tr>
                    <?php
                    $i++;
                    $j--; ?>
                    @endif
                    @endforeach
                </tbody>
                <tfoot>
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
                        <td colspan="5" style="text-align: left; vertical-align: top;"><b>Say : #</b>
                            <?php
                            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                            echo ucwords($f->format($si->head[0]->total_rp));
                            ?>
                        </td>
                        <td colspan="2" style="text-align: right; font-weight:bold;">
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">Total Ammount : IDR</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">Down Payment : IDR</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">Discount : IDR</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">TOTAL INV : IDR</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">VAT : IDR</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">GRAND TOTAL : IDR</span></div>
                        </td>
                        <td style="text-align: right; font-weight:bold;padding-right:10px">
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;"> {{number_format($si->detail[0]->totdetail,2)}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;"> {{$si->head[0]->isUM=="Y"?0:number_format($si->head[0]->uangmuka,2)}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;"> {{number_format($si->head[0]->rp_disch,2)}}</span></div>
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;"> {{number_format($si->head[0]->totdpp_rp,2)}}</span></div>
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
                                <span style="font-weight: normal;"><?php print_r(str_replace(array("\r\n", "\n"), '<br/>', $si->company_bank[0]->$bank1)) ?></span>
                            </div>
                            <div class="column" style="width: 45%;  padding-left:5px;">
                                <span style="font-weight: normal;"><?php print_r(str_replace(array("\r\n", "\n"), '<br/>', $si->company_bank[0]->$bank2)) ?></span>
                            </div>
                        </td>
                        <td colspan="2" style="text-align: left; vertical-align:midle; padding-left:5px">
                            <div class="column" style="width: 100%;"><span style="font-weight: bold;">Finance,</span></div>
                            <br />
                            <br />
                            <br />
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
                </tfoot>
            </table>
            <div id="content">
                <div id="pageFooter">
                </div>
            </div>
        </div>
    </div>

</body>

</html>
<script src="{{asset('plugins/html2pdf/html2pdf.bundle.min.js')}}"></script>
<script type="text/javascript">
    var element = document.getElementById('tb');
    var opt = {
        margin: [30, 0, 30, 0],
        filename: 'a.pdf',
        image: {
            type: 'pdf',
            quality: 0.98
        },
        html2canvas: {
            scale: 2
        },
        jsPDF: {
            unit: 'pt',
            format: 'a4',
            orientation: 'portrait'
        },
        pageBreak: {
            mode: 'css',
            after: '.break-page'
        }
    };

    // New Promise-based usage:
    // html2pdf().set(opt).from(element).save();
    window.onafterprint = window.close;
    window.print();
</script>