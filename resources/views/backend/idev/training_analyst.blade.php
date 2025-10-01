@foreach($training_data as $item)
    @php
        $qualification = json_decode($item->qualification, true);
        $general = json_decode($item->general, true);
        $technical = json_decode($item->technic, true);
    @endphp
@endforeach

@extends("easyadmin::backend.parent")
@section("content")
@push('mtitle')
{{$title}}
@endpush
<div class="pc-container" id="section-list-{{$uri_key}}">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                @if(isset($headerLayout))
                    @include('backend.idev.parts.'.$headerLayout.'')
                @else
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                        </div>
                        {{-- @if (in_array('create', $permissions))
                        <a class="btn btn-secondary float-end text-white mx-1" data-bs-toggle="offcanvas" data-bs-target="#createForm-{{$uri_key}}">
                            Create Header
                        </a>
                        @endif --}}
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body p-3">
                        
                        <div class="table-responsive p-0">
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="table-responsive">
                                                        @if (!empty($training_data) && is_countable($training_data) && count($training_data) > 0)
                                                            <table class="table table-bordered mb-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th rowspan="3" class="text-center">Jabatan</th>
                                                                        <th rowspan="3" class="text-center">Jumlah <br> Personil</th>
                                                                        <th colspan="<?=count($qualification) + count($general) + count($technical) + 1 ?>" class="text-center">Jenis Pelatihan</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th colspan="<?=count($qualification)?>" class="text-center">Qualification</th>
                                                                        <th colspan="<?=count($general)?>" class="text-center">Pelatihan Umum</th>
                                                                        <th colspan="<?=count($technical) + 1 ?>" class="text-center">Pelatihan Khusus & Tambahan</th>
                                                                    </tr>
                                                                    <tr>
                                                                        @foreach($training_data as $item)
                                                                            @php
                                                                                $qualification = json_decode($item->qualification, true);
                                                                                $general = json_decode($item->general, true);
                                                                                $technical = json_decode($item->technic, true);
                                                                            @endphp
                                                                            @foreach($qualification as $key )
                                                                                <th class="th"><span class="vertical">{{ $key }}</span></th>
                                                                            @endforeach
                                                                            @foreach($general as $key )
                                                                                <th class="th"><span class="vertical">{{ $key }}</span></th>
                                                                            @endforeach
                                                                            @foreach($technical as $key )
                                                                                <th class="th"><span class="vertical">{{ $key }}</span></th>
                                                                            @endforeach
                                                                            <th class="th"><span class="vertical"></span></th>
                                                                        @endforeach
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="itemRows">
                                                                @foreach($training_body as $item)
                                                                @php
                                                                    $qualification = json_decode($item->qualification, true);
                                                                    $general = json_decode($item->general, true);
                                                                    $technical = json_decode($item->technic, true);
                                                                @endphp
                                                                    <tr>
                                                                        <td><input type="text" value="{{ old('position', $item->position) }}" class="form-control form-control-sm"></td>
                                                                        <td><input type="number" value="{{ old('personil', $item->personil) }}" class="form-control form-control-sm"></td>

                                                                        {{-- Qualifications --}}
                                                                        @foreach($qualification as $qual)
                                                                            <td class="text-center"><input class="form-check-input input-primary" type="checkbox" {{$qual === "true" ? 'checked' : ''}}></td>
                                                                        @endforeach
                                                                        
                                                                        {{-- Qualifications --}}
                                                                        @foreach($general as $gen)
                                                                            <td class="text-center"><input class="form-check-input input-primary" type="checkbox" {{$gen === "true" ? 'checked' : ''}}></td>
                                                                        @endforeach

                                                                        {{-- Qualifications --}}
                                                                        @foreach($technical as $tech)
                                                                            <td class="text-center"><input class="form-check-input input-primary" type="checkbox" {{$tech === "true" ? 'checked' : ''}}></td>
                                                                        @endforeach
                                                                        
                                                                            <td class="text-center">
                                                                                <button type="button" class="delete-row btn avtar avtar-s btn-link-danger btn-pc-default">
                                                                                    <i class="ti ti-trash f-20"></i>
                                                                                </button>
                                                                            </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        @else
                                                            <p>Data belum tersedia, buat header dulu dibagian kanan atas.</p>
                                                        @endif

                                                        <br>

                                                        <button id="btnAddItem" class="btn btn-light-primary d-flex align-items-center gap-2">
                                                            <i class="ti ti-plus"></i> Add new item
                                                        </button>

                                                        <hr>

                                                        <center>
                                                            <button id="btnSaveData" class="btn btn-primary"><i class="ti ti-device-floppy f-20"></i> Save Data</button>
                                                            <button class="btn btn-danger" onclick="window.location.href='{{ route('training-analyst.pdf', ['header' => request()->input('header')]) }}'"><i class="ti ti-printer f-20"></i> Print Data</button>
                                                            <button class="btn btn-success"><i class="ti ti-rocket f-20"></i> Submitted</button>
                                                        </center>

                                                        <div class="hanya-tampil-di-layar" style="margin-top:20px;">
                                                            <p>Intruksi Kerja:</p>
                                                            <br>
                                                            <p>1. Perhatikan bagian "Pelatihan Khusus dan Tambahan" terlebih dahulu.</p>
                                                            <p>2. Sunting bagian "Pelatihan Khusus dan Tambahan" sesuai dengan kebutuhan divisi masing-masing.</p>
                                                            <p>3. Isi Kolom "Jumlah Personil" sesuai dengan kebutuhan masing-masing.</p>
                                                            <p>4. Beri tanda "&#10003;" pada kolom "Qualifications" sesuai dengan kualifikasi dari pemangku jabatan.</p>
                                                            <p>5. Sesuaikan pelatihan dengan kualifikasi dari pemangku jabatan.</p>
                                                            <p>6. Beri tanda "&#10003;" pada kolom "Jenis pelatihan" untuk menandai pelatihan yang dibutuhkan berdasarkan kualifikasi dari pemangku jabatan.</p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="pc-container" id="section-preview-{{$uri_key}}" style="display:none;">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                           <b>Detail {{$title}}</b> 
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger float-end close-preview">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 content-preview"></div>
        </div>
    </div>
</div>

@push('styles')
@if(isset($import_styles))
@foreach($import_styles as $ist)
<link rel="stylesheet" href="{{$ist['source']}}">
@endforeach
@endif
@endpush

@push('scripts')
@if (in_array('create', $permissions))
<div class="offcanvas offcanvas-end @if(isset($drawerExtraClass)) {{ $drawerExtraClass }} @endif" tabindex="-1" id="createForm-{{$uri_key}}" aria-labelledby="createForm-{{$uri_key}}">
    <div class="offcanvas-header border-bottom bg-secondary p-4">
        <h5 class="text-white m-0">Create New</h5>
        <button type="button" class="btn-close text-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="form-create-{{$uri_key}}" action="{{$url_store}}" method="post">
            @csrf
            <div class="row">
                @php $method = "create"; @endphp
                @foreach($fields as $key => $field)
                @if (View::exists('backend.idev.fields.'.$field['type']))
                    @include('backend.idev.fields.'.$field['type'])
                @else
                    @include('easyadmin::backend.idev.fields.'.$field['type'])
                @endif
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group my-2">
                        <button id="btn-for-form-create-{{$uri_key}}" type="button" class="btn btn-outline-secondary" onclick="softSubmit('form-create-{{$uri_key}}', 'list-{{$uri_key}}')">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

@if(isset($import_scripts))
@foreach($import_scripts as $isc)
<script src="{{$isc['source']}}"></script>
@endforeach
@endif
<script>
    const analystHeadId = new URLSearchParams(window.location.search).get('header');

    $(document).ready(function() {
        if ($(".idev-actionbutton").children().length == 0) {
            $("#dropdownMoreTopButton").remove()
            $(".idev-actionbutton").remove()
        }
        idevTable("list-{{$uri_key}}")
        $('form input').on('keypress', function(e) {
            return e.which !== 13;
        });

        $("#btnAddItem").click(function() {
        var newRow = `
            <tr>
                <td><input name="position[]" type="text" class="form-control form-control-sm"></td>
                <td><input name="personil[]" type="number" class="form-control form-control-sm"></td>
                            
                {{-- Qualifications --}}
                @if (!empty($qualification) && is_countable($qualification))
                    @foreach($qualification as $qual)
                        <td class="text-center">
                            <input class="form-check-input input-primary" type="checkbox">
                        </td>
                    @endforeach
                @endif

                {{-- General Training --}}
                @if (!empty($general) && is_countable($general))
                    @foreach($general as $gen)
                        <td class="text-center">
                            <input class="form-check-input input-primary" type="checkbox">
                        </td>
                    @endforeach
                @endif

                {{-- Technical Training --}}
                @if (!empty($technical) && is_countable($technical))
                    @foreach($technical as $tech)
                        <td class="text-center">
                            <input class="form-check-input input-primary" type="checkbox">
                        </td>
                    @endforeach
                @endif

                    <td class="text-center">
                        <button type="button" class="delete-row btn avtar avtar-s btn-link-danger btn-pc-default">
                            <i class="ti ti-trash f-20"></i>
                        </button>
                    </td>
            </tr>
        `;
        
        $("#itemRows").append(newRow);
    });

    // Fungsi untuk menghapus baris langsung tanpa konfirmasi
    $("#itemRows").on("click", ".delete-row", function() {
        $(this).closest('tr').remove();
    });

    // Handler untuk tombol Save Data
    $("#btnSaveData").click(function() {
        var trainingData = [];
        
        // Loop setiap baris di tabel
        $("#itemRows tr").each(function() {
            var row = $(this);
            var rowData = {
                position: row.find('td:eq(0) input').val(),
                personil: row.find('td:eq(1) input').val(),
                qualification: {},
                general: {},
                technic: {}
            };

            // Ambil data qualification
            var qualIndex = 2;

            // Ambil data qualification
            @if (!empty($qualification) && is_countable($qualification))
                @foreach($qualification as $key => $val)
                    rowData.qualification['{{$key}}'] = row.find(`td:eq(${qualIndex}) input`).is(':checked');
                    qualIndex++;
                @endforeach
            @endif

            // Ambil data general training
            @if (!empty($general) && is_countable($general))
                @foreach($general as $key => $val)
                    rowData.general['{{$key}}'] = row.find(`td:eq(${qualIndex}) input`).is(':checked');
                    qualIndex++;
                @endforeach
            @endif

            // Ambil data technical training
            @if (!empty($technical) && is_countable($technical))
                @foreach($technical as $key => $val)
                    rowData.technic['{{$key}}'] = row.find(`td:eq(${qualIndex}) input`).is(':checked');
                    qualIndex++;
                @endforeach
            @endif

            trainingData.push(rowData);
        });

        // Kirim data ke server
        $.ajax({
            url: '{{ route("training-analyst.saveAll") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                analyst_head_id: analystHeadId,
                training_data: trainingData
            },
            success: function(response) {
                if(response.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat menyimpan data'
                });
            }
        });
    });



})
    $(".search-list-{{$uri_key}}").keyup(delay(function(e) {
        var dInput = this.value;
        if (dInput.length > 3 || dInput.length == 0) {
            $(".current-paginate-{{$uri_key}}").val(1)
            $(".search-list-{{$uri_key}}").val(dInput)
            updateFilter()
        }
    }, 500))

    $("#manydatas-show-{{$uri_key}}").change(function(){
        $(".current-manydatas-{{$uri_key}}").val($(this).val())
        idevTable("list-{{$uri_key}}")
    });

    function updateFilter() {
        var queryParam = $("#form-filter-list-{{$uri_key}}").serialize();
        var currentHrefPdf = $("#export-pdf").attr('data-base-url')
        var currentHrefExcel = $("#export-excel").attr('data-base-url')

        $("#export-pdf").attr('href', currentHrefPdf + "?" + queryParam)
        $("#export-excel").attr('href', currentHrefExcel + "?" + queryParam)
        idevTable("list-{{$uri_key}}")
    }
</script>
@foreach($actionButtonViews as $key => $abv)
@include($abv)
@endforeach
@endpush
@endsection