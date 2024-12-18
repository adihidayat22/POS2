@extends('layouts.master')

@section('title')
    Transaksi Penjualan
@endsection

@push('css')
    <style>
        .tampil-bayar {
            font-size: 5em;
            text-align: center;
            height: 100px;
        }

        .tampil-terbilang {
            padding: 10px;
            background: #f0f0f0;
        }

        .table-penjualan tbody tr:last-child {
            display: none;
        }

        @media(max-width: 768px) {
            .tampil-bayar {
                font-size: 3em;
                height: 70px;
                padding-top: 5px;
            }
        }

        .switch_4 {
            margin: 0 !important
        }

        .input_wrapper {
            width: 80px;
            height: 35px;
            position: relative;
            cursor: pointer;
        }

        .input_wrapper input[type="checkbox"] {
            width: 80px;
            height: 35px;
            cursor: pointer;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background: #315e7f;
            border-radius: 2px;
            position: relative;
            outline: 0;
            -webkit-transition: all .2s;
            transition: all .2s;
        }

        .input_wrapper input[type="checkbox"]:after {
            position: absolute;
            content: "";
            top: 3px;
            left: 3px;
            width: 34px;
            height: 30px;
            background: #dfeaec;
            z-index: 2;
            border-radius: 2px;
            -webkit-transition: all .35s;
            transition: all .35s;
        }

        .input_wrapper svg {
            position: absolute;
            /* top: 50%; */
            -webkit-transform-origin: 50% 50%;
            transform-origin: 50% 50%;
            fill: #fff;
            -webkit-transition: all .35s;
            transition: all .35s;
            z-index: 1;
        }

        .input_wrapper .is_checked {
            width: 28px;
            left: 8%;
            top: 10%;
            /* -webkit-transform: translateX(0) translateY(-53%) scale(1);
                                                                                        transform: translateX(0) translateY(-53%) scale(1); */
        }

        .input_wrapper .is_unchecked {
            width: 28px;
            right: 10%;
            top: 50%;
            -webkit-transform: translateX(0) translateY(-53%) scale(1);
            transform: translateX(0) translateY(-53%) scale(1);
        }

        /* Checked State */
        .input_wrapper input[type="checkbox"]:checked {
            background: #23da87;
        }

        .input_wrapper input[type="checkbox"]:checked:after {
            left: calc(100% - 37px);
        }
    </style>
@endpush

@section('breadcrumb')
    @parent
    <li class="active">Transaksi Penjaualn</li>
@endsection

@section('content')
    <div class="alert alert-warning alert-dismissible" style="display: none;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="icon fa fa-warning"></i> Produk Tidak Ditemukan !
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-body">

                    <form class="form-produk">
                        @csrf
                        <div class="form-group row">
                            {{-- <label for="kode_produk" class="col-lg-2">Kode Produk</label> --}}
                            <div class="col-lg-8">
                                <div class="input-group">
                                    <input type="hidden" name="id_penjualan" id="id_penjualan" value="{{ $id_penjualan }}">
                                    <input type="hidden" name="id_produk" id="id_produk">
                                    <input class="form-control" id="barcode_search" name="barcode_search" type="text"
                                        placeholder="Cari Barcode atau Nama">
                                    <span class="input-group-btn">
                                        {{-- <button onclick="tampilProduk()" class="btn btn-info btn-flat" type="button"><i
                                                class="fa fa-arrow-right"></i></button> --}}
                                        <div class="switch_box box_4">
                                            <div class="input_wrapper">
                                                <input type="checkbox" class="switch_4" checked>

                                                <svg class="is_checked" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
                                                    <path fill="#fff"
                                                        d="M1 21v-5h2v3h3v2zm17 0v-2h3v-3h2v5zM4 18V6h2v12zm3 0V6h1v12zm3 0V6h2v12zm3 0V6h3v12zm4 0V6h1v12zm2 0V6h1v12zM1 8V3h5v2H3v3zm20 0V5h-3V3h5v5z" />
                                                </svg>
                                                <svg class="is_unchecked" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
                                                    <path fill="#fff"
                                                        d="M4 19q-.825 0-1.412-.587T2 17V7q0-.825.588-1.412T4 5h16q.825 0 1.413.588T22 7v10q0 .825-.587 1.413T20 19zm4-3h8v-2H8zm-3-3h2v-2H5zm3 0h2v-2H8zm3 0h2v-2h-2zm3 0h2v-2h-2zm3 0h2v-2h-2zM5 10h2V8H5zm3 0h2V8H8zm3 0h2V8h-2zm3 0h2V8h-2zm3 0h2V8h-2z" />
                                                </svg>
                                            </div>
                                    </span>

                                </div>
                            </div>
                        </div>
                </div>
                </form>

                <table class="table table-stiped table-bordered table-penjualan">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th width="15%">Jumlah</th>
                        <th>Diskon</th>
                        <th>Subtotal</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="tampil-bayar bg-primary"></div>
                        <div class="tampil-terbilang"></div>
                    </div>
                    <div class="col-lg-4">
                        <form action="{{ route('transaksi.simpan') }}" class="form-penjualan" method="post">
                            @csrf
                            <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}">
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total_item">
                            <input type="hidden" name="bayar" id="bayar">
                            <input type="hidden" name="id_member" id="id_member" value="{{ $memberSelected->id_member }}">

                            <div class="form-group row">
                                <label for="totalrp" class="col-lg-2 control-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kode_member" class="col-lg-2 control-label">Member</label>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="kode_member"
                                            value="{{ $memberSelected->kode_member }}">
                                        <span class="input-group-btn">
                                            <button onclick="tampilMember()" class="btn btn-info btn-flat" type="button"><i
                                                    class="fa fa-arrow-right"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diskon" class="col-lg-2 control-label">Diskon</label>
                                <div class="col-lg-8">
                                    <input type="number" name="diskon" id="diskon" class="form-control"
                                        value="{{ !empty($memberSelected->id_member) ? $diskon : 0 }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bayar" class="col-lg-2 control-label">Bayar</label>
                                <div class="col-lg-8">
                                    <input type="text" id="bayarrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diterima" class="col-lg-2 control-label">Diterima</label>
                                <div class="col-lg-8">
                                    <input type="number" id="diterima" class="form-control" name="diterima"
                                        value="{{ $penjualan->diterima ?? 0 }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kembali" class="col-lg-2 control-label">Kembali</label>
                                <div class="col-lg-8">
                                    <input type="text" id="kembali" name="kembali" class="form-control"
                                        value="0" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan"><i
                        class="fa fa-floppy-o"></i> Simpan Transaksi</button>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="modal_struck" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body" id="content_struck"></div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" OnClick="save_transaction()"><span
                            class="fa fa-print"></span>Simpan</button>
                    <button type="button" class="btn btn-success" OnClick="print_transaction()"><span
                            class="fa fa-print"></span>Cetak dan Simpan</button>
                </div>
            </div>
        </div>

        @includeIf('penjualan_detail.produk')
        @includeIf('penjualan_detail.member')
    @endsection
    @push('scripts')
        <script>
            let table, table2;

            $(function() {
                $('body').addClass('sidebar-collapse');
                $("input[type='checkbox']").prop('checked', true);

                function numberWithCommas(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

                function isEmpty(value) {
                    return value && Object.keys(value).length === 0;
                }

                console.log(new Date()); // Date Tue Nov 29 2022 18:18:10 GMT+0200 (South Africa Standard Time)
                console.log(isEmpty(new Date())); // true

                $('#barcode_search').focus();
                $('input[type=checkbox]').change(
                    function() {
                        if (this.checked) {
                            $("input[type='checkbox']").prop('checked', true);
                            $("#barcode_search").on("input", function() {
                                if ($('#barcode_search').val().length === 7 && this.checked) {
                                    findProductByBarcode($('#barcode_search').val())
                                }
                            });
                        } else {
                            $("input[type='checkbox']").prop('checked', false);
                            listening_serch_product();
                        }
                        $('#barcode_search').focus();
                    }
                );
                if ($("input[type='checkbox']").is(':checked') === true) {
                    $("#barcode_search").on("input", function() {
                        if ($('#barcode_search').val().length === 7) {
                            findProductByBarcode($('#barcode_search').val())
                        }
                    });
                } else {
                    listening_serch_product();
                }


                function findProductByBarcode(barcode) {
                    if ($("input[type='checkbox']").is(':checked') === true) {
                        $.ajax({
                            url: "/produk/find_by_barcode",
                            type: "GET",
                            data: {
                                kode_produk: barcode
                            },
                            success: function(data) {
                                $('#barcode_search').val('');
                                if (isEmpty(data)) {
                                    $('.alert').fadeIn();
                                    setTimeout(() => {
                                        $('.alert').fadeOut();
                                    }, 3000);
                                } else {
                                    pilihProduk(data.id_produk, data.kode_produk);
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert('Error adding data');
                            }
                        });
                    } else {
                        return false
                    }
                }

                function listening_serch_product(params) {
                    $("#barcode_search").autocomplete({
                            minLength: 1,
                            delay: 500,
                            source: function(request, response) {
                                jQuery.ajax({
                                    url: "/produk/search_produk",
                                    data: {
                                        keyword: request.term
                                    },
                                    dataType: "json",
                                    success: function(data) {
                                        response(data);
                                    }
                                })
                            },
                            select: function(e, ui) {
                                pilihProduk(ui.item.id_produk, ui.item.kode_produk);
                                $("#barcode_search").val('');
                                return false;
                            }
                        })
                        .data("ui-autocomplete")._renderItem = function(ul, item) {
                            return $("<li>")
                                .append("<a style='display: flex;'><div style='width: 100px;'>" + item.kode_produk +
                                    "</div> <div style='width: 400px;'>" + item.nama_produk +
                                    "</div><div style='width: 120px;'>Stok : " + item.stok +
                                    "</div><div style='width: 180px;'>Rp. " + numberWithCommas(item.harga_jual) +
                                    "</div></a>")
                                .appendTo(ul);
                        };
                }

                table = $('.table-penjualan').DataTable({
                        responsive: true,
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        ajax: {
                            url: '{{ route('transaksi.data', $id_penjualan) }}',
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                searchable: false,
                                sortable: false
                            },
                            {
                                data: 'kode_produk'
                            },
                            {
                                data: 'nama_produk'
                            },
                            {
                                data: 'harga_jual'
                            },
                            {
                                data: 'jumlah'
                            },
                            {
                                data: 'diskon'
                            },
                            {
                                data: 'subtotal'
                            },
                            {
                                data: 'aksi',
                                searchable: false,
                                sortable: false
                            },
                        ],
                        dom: 'Brt',
                        bSort: false,
                        paginate: false
                    })
                    .on('draw.dt', function() {
                        loadForm($('#diskon').val());
                        setTimeout(() => {
                            $('#diterima').trigger('input');
                        }, 300);
                    });
                table2 = $('.table-produk').DataTable();

                $(document).on('input', '.quantity', function() {
                    let id = $(this).data('id');
                    let jumlah = parseInt($(this).val());

                    if (jumlah < 1) {
                        $(this).val(1);
                        alert('Jumlah tidak boleh kurang dari 1');
                        return;
                    }
                    if (jumlah > 10000) {
                        $(this).val(10000);
                        alert('Jumlah tidak boleh lebih dari 10000');
                        return;
                    }

                    $.post(`{{ url('/transaksi') }}/${id}`, {
                            '_token': $('[name=csrf-token]').attr('content'),
                            '_method': 'put',
                            'jumlah': jumlah
                        })
                        .done(response => {
                            $(this).on('mouseout', function() {
                                table.ajax.reload(() => loadForm($('#diskon').val()));
                            });
                        })
                        .fail(errors => {
                            alert('Tidak dapat menyimpan data');
                            return;
                        });
                });

                $(document).on('input', '#diskon', function() {
                    if ($(this).val() == "") {
                        $(this).val(0).select();
                    }

                    loadForm($(this).val());
                });

                $('#diterima').on('input', function() {
                    if ($(this).val() == "") {
                        $(this).val(0).select();
                    }

                    loadForm($('#diskon').val(), $(this).val());
                }).focus(function() {
                    $(this).select();
                });

                $('.btn-simpan').on('click', function() {
                    $('.form-penjualan').submit();
                });
            });

            function tampilProduk() {
                $('#modal-produk').modal('show');
            }

            function hideProduk() {
                $('#modal-produk').modal('hide');
            }

            function pilihProduk(id, kode) {
                $('#id_produk').val(id);
                $('#kode_produk').val(kode);
                hideProduk();
                tambahProduk();
            }

            function tambahProduk() {
                $.post('{{ route('transaksi.store') }}', $('.form-produk').serialize())
                    .done(response => {
                        $('#kode_produk').focus();
                        table.ajax.reload(() => loadForm($('#diskon').val()));
                    })
                    .fail(errors => {
                        alert('Tidak dapat menyimpan data');
                        return;
                    });
            }

            function tampilMember() {
                $('#modal-member').modal('show');
            }

            function pilihMember(id, kode) {
                $('#id_member').val(id);
                $('#kode_member').val(kode);
                $('#diskon').val('{{ $diskon }}');
                loadForm($('#diskon').val());
                $('#diterima').val(0).focus().select();
                hideMember();
            }

            function hideMember() {
                $('#modal-member').modal('hide');
            }

            function deleteData(url) {
                if (confirm('Yakin ingin menghapus data terpilih?')) {
                    $.post(url, {
                            '_token': $('[name=csrf-token]').attr('content'),
                            '_method': 'delete'
                        })
                        .done((response) => {
                            table.ajax.reload(() => loadForm($('#diskon').val()));
                        })
                        .fail((errors) => {
                            alert('Tidak dapat menghapus data');
                            return;
                        });
                }
            }

            function loadForm(diskon = 0, diterima = 0) {
                $('#total').val($('.total').text());
                $('#total_item').val($('.total_item').text());

                $.get(`{{ url('/transaksi/loadform') }}/${diskon}/${$('.total').text()}/${diterima}`)
                    .done(response => {
                        $('#totalrp').val('Rp. ' + response.totalrp);
                        $('#bayarrp').val('Rp. ' + response.bayarrp);
                        $('#bayar').val(response.bayar);
                        $('.tampil-bayar').text('Bayar: Rp. ' + response.bayarrp);
                        $('.tampil-terbilang').text(response.terbilang);

                        $('#kembali').val('Rp.' + response.kembalirp);
                        if ($('#diterima').val() != 0) {
                            $('.tampil-bayar').text('Kembali: Rp. ' + response.kembalirp);
                            $('.tampil-terbilang').text(response.kembali_terbilang);
                        }
                    })
                    .fail(errors => {
                        alert('Tidak dapat menampilkan data');
                        return;
                    })
            }
        </script>
    @endpush
