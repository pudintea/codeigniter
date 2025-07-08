<?php

$data = $this->Jenjang_model->getDataPerJenjang();
$total = $this->Jenjang_model->getDataTotal();

// Siapkan array kosong
$pivot = [
    'L'      => [],
    'P'      => [],
    'Jumlah' => []
];

// Looping untuk membentuk tabel pivot
foreach ($data as $row) {
    $pivot['L'][$row->nama] = $row->jml_murid_laki_laki;
    $pivot['P'][$row->nama] = $row->jml_murid_perempuan;
    $pivot['Jumlah'][$row->nama] = $row->jumlah;
}

// Tambahkan TOTAL ke akhir
$pivot['L']['TOTAL'] = $total->jml_murid_laki_laki;
$pivot['P']['TOTAL'] = $total->jml_murid_perempuan;
$pivot['Jumlah']['TOTAL'] = $total->jumlah;

// Kirim ke view
$data['pivot'] = $pivot;


// ============= VIEWS =====================

<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th></th>
            <th>TK</th>
            <th>SD</th>
            <th>SMP</th>
            <th>SMA</th>
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>L</th>
            <td><?= $pivot['L']['TK'] ?></td>
            <td><?= $pivot['L']['SD'] ?></td>
            <td><?= $pivot['L']['SMP'] ?></td>
            <td><?= $pivot['L']['SMA'] ?></td>
            <td><?= $pivot['L']['TOTAL'] ?></td>
        </tr>
        <tr>
            <th>P</th>
            <td><?= $pivot['P']['TK'] ?></td>
            <td><?= $pivot['P']['SD'] ?></td>
            <td><?= $pivot['P']['SMP'] ?></td>
            <td><?= $pivot['P']['SMA'] ?></td>
            <td><?= $pivot['P']['TOTAL'] ?></td>
        </tr>
        <tr>
            <th>Jumlah</th>
            <td><?= $pivot['Jumlah']['TK'] ?></td>
            <td><?= $pivot['Jumlah']['SD'] ?></td>
            <td><?= $pivot['Jumlah']['SMP'] ?></td>
            <td><?= $pivot['Jumlah']['SMA'] ?></td>
            <td><?= $pivot['Jumlah']['TOTAL'] ?></td>
        </tr>
    </tbody>
</table>



// ======================== PUDIN.ALAZHAR@GMAIL.COM =================
