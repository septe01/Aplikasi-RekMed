
$(document).ready(function() {
	
	$('#alert').show(function() {
		var tipe = $('#alert').data('tipe');
		var err = $('#alert').data('text');
		var judul = $('#alert').data('judul');

		// console.log(err+' '+judul);
		var invoice = 'http://localhost/bundamulya/panel/home.php?page=invoice&&id='+judul;

		

		if(err === 'usser'){
			Swal.fire({
			  title: 'Selamat !',
			  text: "Data berhasil di ubah silahkan logout dan login kembali.",
			  type: 'success',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Ok.'
			}).then((result) => {
			  if (result.value) {
			    document.location.href='../logout.php?logout=true';
			  }
			});

		}else if(err === 'bayar'){
			Swal.fire({
			  title: 'Selamat !',
			  text: "Pembayaran sudah berhasil.. \n Cetak Invoice ?",
			  type: 'success',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Ok.'
			}).then((result) => {
			  if (result.value) {
			    window.open(invoice,'_blank');
			  }
			});

		}else if(err === 'ubayar'){
			Swal.fire({
			  title: 'Selamat !',
			  text: "Pembayaran berhasil di ubah.. \n Cetak Invoice ?",
			  type: 'success',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Ok.'
			}).then((result) => {
			  if (result.value) {
			    window.open(invoice,'_blank');
			  }
			});

		}else if(tipe === 'success'){
			// toast method
				const Toast = Swal.mixin({
				  toast: true,
				  position: 'top-end',
				  showConfirmButton: true,
				  timer: 3000
				});

				Toast.fire({
				  // title: judul,
				  text : err,
				  type : tipe
				});
		
		}else{
			Swal.fire({
			  title: judul,
			  text : err,
			  type : tipe,
			  animation: false,
			  customClass: 'animated fadeInDown'
			});
		}
	});



// <!-- datepicker -->
        $( "#fini" ).datepicker({dateFormat: 'yy-mm-dd'});
          $( "#fini" ).datepicker( "option", "showAnim", 'slideDown' );

        $( "#ffin" ).datepicker({dateFormat: 'yy-mm-dd'});
          $( "#ffin" ).datepicker( "option", "showAnim", 'slideDown' );

 // <!-- sum coldatatables -->
    $('#mylap').DataTable( { 
    	
    	dom: 'Blfrtip',
    	
    	buttons: [
            { extend: 'copyHtml5', footer: true, title: 'Klinik Bunda Mulya', messageTop: 'Laporan keuangan.' },
            { extend: 'excelHtml5', footer: true, title: 'Klinik Bunda Mulya', messageTop: 'Laporan keuangan.'   },
            { extend: 'pdfHtml5', footer: true, title: 'Klinik Bunda Mulya', messageTop: 'Laporan keuangan.' },
            { extend: 'print', footer: true, title: 'Klinik Bunda Mulya', messageTop: 'Laporan keuangan.' }
          ],
        
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[*\$,\D]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 3 ).footer() ).html(

                'Rp. '+numberWithCommas(pageTotal) +'<br>  ( Rp. '+ numberWithCommas(total) +' Alltotal)'

            );
        }
    });


// <!-- daterange -->
		$('#fini, #ffin').change(function() {
			
			 $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {

                var date = $("#fini").datepicker("getDate");
                var min = $.datepicker.formatDate("yy-mm-dd 24:00:00", date);
                console.log(min);
                var date = $("#ffin").datepicker("getDate");
                var max = $.datepicker.formatDate("yy-mm-dd 24:00:00", date);
                console.log(min);
                // temukan kolom yang mana
                var startDate = (data[2]);
                if (min == null && max == null) { return true; }
                if (min == null && startDate <= max) { return true;}
                if(max == null && startDate >= min) {return true;}
                if (startDate <= max && startDate >= min) { return true; }
                return false;
            }
            );


                $("#fini").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
                $("#ffin").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
                var table = $('#mylap').DataTable();

                // Event listener to the two range filtering inputs to redraw on input
                $('#fini, #ffin').change(function () {
                    table.draw();
                });

		});

	 	// <!-- // fungsi format number -->
		function numberWithCommas(x) {
		    var parts = x.toString().split(".");
		    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		    return parts.join(".");
		}

		// get image

		function getImg(data, type, full, meta){
			return '<img src="../main/assets/img/logo.png" alt="logo">';
		}
// <!-- shorting data in datatable -->
		$('#mylap').data({
			"order": [[0,"desc"]]
		});

		$('#mylap_length label').addClass('ml-2');
		$('tfoot tr th:nth-child(2)').text('Total :');
		// var x = replace(/[\$,]/g, '')*1 ;
		// replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "")*1
		// console.log();

		$('#laporans').DataTable();


		// $('.laporanuang').addClass('hidden');

		// ->>>>> Pasien
		$('#mylappas').DataTable( { 
    	
    	dom: 'Blfrtip',
    	
    	buttons: [
            { extend: 'copyHtml5', footer: true, title: 'Klinik Bunda Mulya', messageTop: 'Laporan Pasien.' },
            { extend: 'excelHtml5', footer: true, title: 'Klinik Bunda Mulya', messageTop: 'Laporan Pasien.'   },
            { extend: 'pdfHtml5', footer: true, title: 'Klinik Bunda Mulya', messageTop: 'Laporan Pasien.' },
            { extend: 'print', footer: true, title: 'Klinik Bunda Mulya', messageTop: 'Laporan Pasien.' }
          ]                
    });

	$('#fspas, #fepas').change(function() {
			let x = $(this).val();
			 $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {

                var date = $("#fspas").datepicker("getDate");
                var min = $.datepicker.formatDate("yy-mm-dd 24:00:00", date);
                console.log(min);
                var date = $("#fepas").datepicker("getDate");
                var max = $.datepicker.formatDate("yy-mm-dd 24:00:00", date);
                console.log(min);
                // temukan kolom yang mana
                var startDate = (data[7]);
                if (min == null && max == null) { return true; }
                if (min == null && startDate <= max) { return true;}
                if(max == null && startDate >= min) {return true;}
                if (startDate <= max && startDate >= min) { return true; }
                return false;
            }
            );


                $("#fspas").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
                $("#fepas").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
                var table = $('#mylappas').DataTable();

                // Event listener to the two range filtering inputs to redraw on input
                $('#fspas, #fepas').change(function () {
                    table.draw();
                });

		});

	// <!-- datepicker -->
        $( "#fspas" ).datepicker({dateFormat: 'yy-mm-dd'});
          $( "#fspas" ).datepicker( "option", "showAnim", 'slideDown' );

        $( "#fepas" ).datepicker({dateFormat: 'yy-mm-dd'});
          $( "#fepas" ).datepicker( "option", "showAnim", 'slideDown' );


});



$.ajax({
			url: "class/chart_pasien.php",
			type: "POST",
			data: "",
			success: function(result) {
				 var resultObj = JSON.parse(result);
				 $('.thn').text(resultObj[2]);
				 Morris.Bar({
				  element: 'myfirstchart',
				  data: [
				    { y: 'Jan', laki: resultObj[0][0], perempuan: resultObj[1][0] },
				    { y: 'Feb', laki: resultObj[0][1], perempuan: resultObj[1][1] },
				    { y: 'Mar', laki: resultObj[0][2], perempuan: resultObj[1][2] },
				    { y: 'Apr', laki: resultObj[0][3], perempuan: resultObj[1][3] },
				    { y: 'Mei', laki: resultObj[0][4], perempuan: resultObj[1][4] },
				    { y: 'Jun', laki: resultObj[0][5], perempuan: resultObj[1][5] },
				    { y: 'Jul', laki: resultObj[0][6], perempuan: resultObj[1][6] },
				    { y: 'Agu', laki: resultObj[0][7], perempuan: resultObj[1][7] },
				    { y: 'Sep', laki: resultObj[0][8], perempuan: resultObj[1][8] },
				    { y: 'Okt', laki: resultObj[0][9], perempuan: resultObj[1][9] },
				    { y: 'Nov', laki: resultObj[0][10], perempuan: resultObj[1][10] },
				    { y: 'Des', laki: resultObj[0][11], perempuan: resultObj[1][11] }
				  ],
				  xkey: 'y',
				  ykeys: ['laki', 'perempuan'],
				  labels: ['Laki-Laki', 'Perempuan']
				});
			}
		});

$.ajax({
			url: "class/chart_perawatan.php",
			type: "POST",
			data: "",
			success: function(result) {
				 var resultObj = JSON.parse(result);
				 $('.thntwo').text(resultObj[1]);
				 console.log(resultObj[0][5]);
				  new Morris.Line({
				  element: 'mytwochart',
				  data: [
				    { year: resultObj[1]+'-01', value: resultObj[0][0] },
				    { year: resultObj[1]+'-02', value: resultObj[0][1] },
				    { year: resultObj[1]+'-03', value: resultObj[0][2] },
				    { year: resultObj[1]+'-04', value: resultObj[0][3] },
				    { year: resultObj[1]+'-05', value: resultObj[0][4] },
				    { year: resultObj[1]+'-06', value: resultObj[0][5] },
				    { year: resultObj[1]+'-07', value: resultObj[0][6] },
				    { year: resultObj[1]+'-08', value: resultObj[0][7] },
				    { year: resultObj[1]+'-09', value: resultObj[0][8] },
				    { year: resultObj[1]+'-10', value: resultObj[0][9] },
				    { year: resultObj[1]+'-11', value: resultObj[0][10] },
				    { year: resultObj[1]+'-12', value: resultObj[0][11] }
				  ],
				  xkey: 'year',
				  ykeys: ['value'],
				  labels: ['Pasien']
				});
			}
		});


 
