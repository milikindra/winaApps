<?php
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=Data Posisi Stock.xlsx");
?>
<table>
    <thead>
        <tr>
            <th colspan="6" style="font-size: 16; font-weight: bold;">PT. Viktori Provindo Automation</th>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="6" style="font-weight: bold;">Report Posisi Stock</th>
        </tr>
        <tr>
            <th colspan="6" style="font-weight: bold;">Gudang {{$lokasi}}</th>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="6" style="font-weight: bold;">{{ $edate }}</th>
        </tr>
    </thead>
    <tr></tr>
    <thead>
        <tr>
            <th style="background-color: #b3baff; font-weight: bold; border: 1px solid #000000;">Kode</th>
            <th style="background-color: #b3baff; font-weight: bold; border: 1px solid #000000;">Nama Barang</th>
            <th style="background-color: #b3baff; font-weight: bold; border: 1px solid #000000;">Satuan</th>
            <th style="background-color: #b3baff; font-weight: bold; border: 1px solid #000000;">Qty</th>
            <th style="background-color: #b3baff; font-weight: bold; border: 1px solid #000000;">Total</th>
            <th style="background-color: #b3baff; font-weight: bold; border: 1px solid #000000;">Harga Rata-rata</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        $total_rata = 0;

        foreach ($posisiStock as $posisi) {
            $total += $posisi->jml_pok;
            $total_rata += $posisi->rata;
        ?>
            <tr>
                <td style="border: 1px solid #000000;">{{$posisi->no_stock }}</td>
                <td style="border: 1px solid #000000;">{{$posisi->nm_stock}}</td>
                <td style="border: 1px solid #000000;">{{$posisi->sat}}</td>
                <td style="border: 1px solid #000000;">{{$posisi->qty}}</td>
                <td style="border: 1px solid #000000;">{{$posisi->jml_pok}}</td>
                <td style="border: 1px solid #000000;">{{$posisi->rata}}</td>
            </tr>
        <?php } ?>
        <tr>
            <td style="border: 1px solid #000000;" colspan="4"><b>Total</b></td>
            <td style="border: 1px solid #000000;">{{$total}}</td>
            <td style="border: 1px solid #000000;">{{$total_rata}}</td>
        </tr>
    </tbody>
</table>