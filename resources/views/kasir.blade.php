@extends('layouts/layout')

@section('header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<style>
	td 
	{
		padding: 5px;
	}
	.p 
	{
		text-align: right;
	}
</style>
<div class="col-md-7">
	<div class="row">
		<table>
			<tr>
				<td><p class="p">Nama Tenan</p></td>
				<td><p>:</p></td>
				<td>
					<select class="form-control" id="nt">
						<option value="aku" selected="selected" hidden=""> </option>
						@foreach($tenan as $data)
							<option value="{{$data->id}}">{{$data->nama_tenan}}</option>
						@endforeach
					</select>
				</td>
			</tr>
			<tr>
				<td><p class="p">Nama Menu</p></td>
				<td><p>:</p></td>
				<td>
					<select class="form-control" id="nm">
						<option value="" selected="selected" hidden=""> </option>
					</select>
				</td>
			</tr>
			<tr>
				<td><p class="p">Harga Barang</p></td>
				<td><p>:</p></td>
				<td><input type="text" name="hb" class="form-control" disabled id="hb" ></td>
			</tr>
			<tr>
				<td><p class="p">Quantity</p></td>
				<td><p>:</p></td>
				<td><input type="number" id="qty" name="qty" class="form-control"></td>
			</tr>
		</table>
	</div>
</div>
<div class="col-md-4">
	<div class="row">
		<table>
			<tr>
				<td><p class="p">Total Harga (Rp.)</p></td>
				<td><p>:</p></td>
				<td><input type="text" name="th" id="th" class="form-control" disabled></td>
			</tr>
			<tr>
				<td><p class="p">Bayar (Rp.)</p></td>
				<td><p>:</p></td>
				<td><input type="text" name="byr" id="byr" class="form-control" value="0"></td>
			</tr>
			<tr>
				<td><p class="p">Total Kembalian (Rp.)</p></td>
				<td><p>:</p></td>
				<td><input type="text" name="tk" id="tk" class="form-control" disabled></td>
			</tr>
		</table>	
		<button class="btn btn-info" id="tambah"><span class="fas fa-plus"></span> Tambah</button>
		<button class="btn btn-success"><span class="fas fa-cash-register"></span> Bayar</button>
	</div>
</div>
@endsection

@section('content2')
<div class="panel panel-headline">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="lnr lnr-book"></span> Transaksi</h3>
	</div>
	<div class="panel-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<td>#</td>
					<td>Nama Tenan</td>
					<td>Nama Menu</td>
					<td>Harga (Rp.)</td>
					<td>Quantity</td>
					<td>Sub Total (Rp.)</td>
					<td>Aksi</td>
				</tr>
			</thead>
			<tbody id="tempat">
				
			</tbody>
		</table>
	</div>
</div>
<div id="aku"></div>
@endsection

@section('script')
<script>
	$(document).ready(function() {
		var no = 1;
		var subtot = 0;
		$('#nt').change(function(){
			var nt = $(this).children("option:selected").val();

			$.ajaxSetup({
			  headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			  },
			});

			$.ajax({
				url 	: '/cari',
				method 	: "POST",
				data 	: {tenan: nt,_token: '{{csrf_token()}}'},
			}).done(function(hasil){
				var finish 	= $.parseJSON(hasil);
				var n 		= finish.length;
				$('#nm').empty();
				$('#nm').append('<option value="" selected="selected" hidden="">')
				for (var i = 0; i < n; i++) {
					$('#nm').append("<option value="+finish[i].id+">"+finish[i].nama_menu+"</option>");
					console.log("tenan diganti");
				}
			});
		});

		$('#nm').change(function(){
			var nm = $(this).children("option:selected").val();

			$.ajaxSetup({
			  headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			  },
			});
			
			$.ajax({
				url 	: '/cari_harga',
				method 	: "POST",
				data 	: {menu: nm,_token: '{{csrf_token()}}'},
			}).done(function(hasil){
				var finish 	= $.parseJSON(hasil);
				$('#hb').val(" ");
				$('#hb').val(finish.harga);
				console.log("menu diganti "+finish.harga);
			});
		});

		$('#tambah').on('click',function(){
			var nt 	= $('#nt option:selected').text();
			var nm 	= $('#nm option:selected').text();
			var hb 	= $('#hb').val();
			var qty = $('#qty').val();
			var sb 	= hb*qty;

			$('#tempat').append(
				'<tr>'+
					'<td>'+no+'</td>'+
					'<td>'+nt+'</td>'+
					'<td>'+nm+'</td>'+
					'<td>'+hb+'</td>'+
					'<td>'+qty+'</td>'+
					'<td>'+sb+'</td>'+
					'<td><button class="d1" name="d1" id="d1"><span class="fas fa-times"></span> hapus</button></td>'+
				'</tr>'
				);
			no++;
			$.ajaxSetup({
			  headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			  },
			});

			$.ajax({
				url 	: '/cari_tenan',
				method 	: "GET",
				data 	: {_token: '{{csrf_token()}}'},
			}).done(function(hasil){
				var finish 	= $.parseJSON(hasil);
				var n 		= finish.length;
				$('#nt').empty();
				$('#nt').append('<option value="" selected="selected" hidden="">')
				for (var i = 0; i < n; i++) {
					$('#nt').append("<option value="+finish[i].id+">"+finish[i].nama_tenan+"</option>");
					console.log("tenan diganti");
				}
			});

			$('#nm').empty();
			$('#hb').val(' ');

			$('#qty').val(' ');

			var byr = $('#byr').val();
			subtot	= subtot + sb;
			var tk  = byr - subtot;
			$('#th').val(subtot);
			$('#tk').val(tk);
		});

		$('#byr').on('keyup',function(){
			var tot = $('#th').val();
			var byr = $('#byr').val();
			var tk  = byr - tot;
			$('#tk').val(tk);
		});
		
	});

	$(document).ready(function(){
		$('.d1').click(function(){
			alert("wow");
		});
	});

	//FUCK YOU
</script>
@endsection