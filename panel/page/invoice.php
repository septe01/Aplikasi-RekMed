<?php 
$id = $_GET['id'];
$list = $DB_con->prepare("SELECT * FROM tbl_pembayaran where nomer_perawatan = '$id'");
$list->execute();
$row =$list->fetch();

$kper  = $row['kode_periksa'];
$pas    = $DB_con->prepare("SELECT * FROM tbl_periksa tbp, tbl_pasien mp
    where tbp.kode_pasien = mp.kode_pasien
    and tbp.kode_periksa = '$kper'");
$pas->execute();
$pasi =$pas->fetch();

$jadi = $DB_con->prepare("SELECT * 
    FROM det_perawatan dr, tbl_pembayaran mp WHERE 
    mp.nomer_perawatan = dr.nomer_perawatan 
    and mp.nomer_perawatan = '$id'
    order by det_type ASC ");

    $jadi->execute();

?>

    
    <div class="row">
        <div class="col-xl-12 contentprint">
            <!-- Begin Invoice -->
            <div class="invoice has-shadow">
                <!-- Begin Invoice COntainer -->
                <div class="invoice-container">
                    <!-- Begin Invoice Top -->
                    <div class="invoice-top">
                        <div class="row d-flex align-items-center">
                            <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                             <h2>Bukti Pembayaran</h2>
                             <span>No. <?php echo $row['nomer_pembayaran'];?></span>
                         </div>
                         <div class="col-xl-6 col-md-6 col-sm-6 col-6 d-flex justify-content-end">
                            <div class="actions dark print">
                                <a href="#" onclick="window.print();" class="dropdown-item"> 
                                    <i class="la la-print"></i>Print
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Invoice Top -->
                <!-- Begin Invoice Header -->
                <div class="invoice-header" style="margin-bottom: -35px">
        <div class="row d-flex align-items-center">
           <div class="col-xl-5 col-md-5 col-sm-6 d-flex justify-content-xl-start justify-content-md-center justify-content-center">
                  <div class="details">
                    
                   <ul>
                      <li class="company-name">Klinik Bunda Mulya</li>
                      <li>Jl.Somantri No.11 Mekar Mulya, Parung Panjang</li>
                      <li>Bogor - Jawa Barat</li>
                      <li>Telp.(021) 5978058  Fax.(021) 5977758</li>
                  </ul>
              </div>
          </div>
          <div class="col-xl-6 col-md-6 col-sm-6 col-6 d-flex justify-content-end">
             <div class="client-details">
                 <ul>
                  <li class="title">Untuk</li>
                  <li><?php echo $pasi['nama_pasien'];?></li>
                  <li><?php echo $pasi['alamat_pasien'];?></li>
                  <li>Telp: <?php echo $pasi['telepon'];?></li>
              </ul>
          </div>
      </div>
  </div>
</div>
<!-- End Invoice Header -->
<div class="invoice-date d-flex justify-content-xl-end justify-content-end" style="margin-bottom: -35px">
    <span><?php echo date('Y-m-d', strtotime($row['tanggal_keluar']));?></span>
</div>
<!-- Begin Table -->
<div class="col-xl-12 desc-tables table-sm">
 <div class="table-responsive table-sm">
  <table class="table table-sm">
      <thead>
          <tr>
              <th class="text-left">Keterangan</th>
              <th></th>
              <th class="text-center">Harga (Rp.)</th>
          </tr>
      </thead>
      <thead>
          <tr>
              <td class="text-left">Biaya Periksa</td>
              <td>Detail</td>
               <td></td>
          </tr>
          <tr>
            <td></td>
            <td>              
            <?php
                $detobt = $DB_con->prepare("SELECT * FROM
                                det_obat trobt,
                                tbl_obat tobt
                                WHERE
                                trobt.kode_obat = tobt.kode_obat
                                AND trobt.kode_periksa = '$kper'
                                ");
                      $detobt->execute();
                      $obts = "";
                      while ($rows = $detobt->fetch(PDO::FETCH_ASSOC)) {
                          $obts .= $rows['nama_obat']." ".$rows['catatan']."<br><br> ";
                      }     
                    echo $obts;
                    // echo '<br>';
                    echo 'Dokter, alat dan tindakan';
             ?>
            </td>
            <td class="text-right"><?php echo number_format($row['total_periksa']);?></td>
          </tr>
      </thead>
      <thead>
        <tr>
              <td class="text-left">Biaya Perawatan</td>
              <td class="text-left">Detail</td>
              <td></td>
          
        </tr>
        <?php while ($rows=$jadi->fetch(PDO::FETCH_ASSOC)){?>
              <?php 
                  if($rows['det_text'] == " "):?>
                    <tr style="display: none;">
                      <td></td>
                      <td>-</td>
                      <td>-</td>
                    </tr>                    
                  <?php else: ?>
                    <tr>
                      <td></td>
                      <td class="text-left"><?php echo ucfirst($rows['det_type']).' '.$rows['det_text']; ?></td>
                      <td class="text-right"><?php echo number_format($rows['det_harga']);?></td>
                    </tr>                    
        <?php 
            endif;
          }
          ?>
      </thead>
  <tfoot>
      <tr>
          <td></td>
          <td class="text-right">Subtotal</td>
          <td class="text-right"><?php echo number_format($row['total_perawatan']);?></td>
      </tr>
      <tr>
          <td></td>
          <td class="text-right">Dibayar</td>
          <td class="text-right"><?php echo number_format($row['bayar_perawatan']);?></td>
      </tr>
      <?php 

          $total = $row['total_perawatan'];
          $bayar = $row['bayar_perawatan'];

          if($total > $bayar){
       ?>

            <tr>
                <td></td>
                <td class="text-right">Kurang</td>
                <td class="text-right"> - <?php echo number_format($row['total_perawatan']-$row['bayar_perawatan']);?></td>
            </tr>
                  <?php 
                    }elseif($total == $bayar){

                   ?>
            <tr>
                <td></td>
                <td class="text-right">Lunas</td>
                <td class="text-right"></td>
            </tr>
                  <?php 
                    }elseif($total < $bayar){
                      $hsl = number_format($row['total_perawatan']-$row['bayar_perawatan']);
                      $kembali = ltrim($hsl,'-');
                   ?>
            <tr>
                <td></td>
                <td class="text-right">Kembali</td>
                <td class="text-right"><?php echo $kembali; ?></td>
            </tr>

       <?php 
          }

        ?>

  </tfoot>
</table>
</div>
</div>
<!-- End Table -->
</div>
<!-- End Invoice Container -->
<!-- Begin Invoice Footer -->
<div class="invoice-footer" style="margin-top: -13px">
    <!-- Begin Invoice Container -->
    <div class="invoice-container">
        <div class="" style="text-align: center;">
            <div class="thx">
                <i class="la la-heart"></i><span>Terima Kasih, Semoga Lekas Sembuh</span>
            </div>
        </div>
    </div>
    <!-- End Invoice Container -->
</div>
<!-- End Invoice Footer -->
</div>
<!-- End Invoice -->
</div>
</div>