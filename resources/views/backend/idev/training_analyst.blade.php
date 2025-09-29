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
                        @if (in_array('create', $permissions))
                        <a class="btn btn-secondary float-end text-white mx-1" data-bs-toggle="offcanvas" data-bs-target="#createForm-{{$uri_key}}">
                            Create Header
                        </a>
                        @endif
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
                            
<!-- [ Main Content ] start -->
<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <div class="table-responsive">
              <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th class="text-center" rowspan="2">Jabatan</th>
                        <th class="text-center" rowspan="2">Jumlah <br> Personil</th>
                        <th class="text-center" colspan="5">Qualifications</th>
                        <th class="text-center" colspan="4">Pelatihan Umum</th>
                        <th class="text-center" colspan="7">Pelatihan Khusus & Tambahan</th>
                    </tr>
                  <tr>
                    <th class="vertical">SMA</th>
                    <th class="vertical">D3</th>
                    <th class="vertical">Apoteker/S.APT</th>
                    <th class="vertical">Magister</th>
                    <th class="vertical">Doktor</th>
                    <th class="vertical">K3</th>
                    <th class="vertical">APD & APAR</th>
                    <th class="vertical">Sanitasi & Higiene</th>
                    <th class="vertical">GDP 2023</th>
                    <th class="vertical">Leadership</th>
                    <th class="vertical">Tanggap Darurat</th>
                    <th class="vertical">Material Handling</th>
                    <th class="vertical">Warehouse System</th>
                    <th class="vertical">Penggunaan Forklift Forklift Forklift</th>
                    <th class="vertical">Skill Khusus</th>
                    <th class="text-center"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><input type="text" class="form-control form-control-sm"></td>
                    <td><input type="number" class="form-control form-control-sm"></td>
                    <td><input class="form-check-input input-primary" type="checkbox"></td>
                    <td><input class="form-check-input input-primary" type="checkbox"></td>
                    <td><input class="form-check-input input-primary" type="checkbox"></td>
                    <td><input class="form-check-input input-primary" type="checkbox"></td>
                    <td><input class="form-check-input input-primary" type="checkbox"></td>
                    <td><input class="form-check-input input-primary" type="checkbox"></td>
                    <td><input class="form-check-input input-primary" type="checkbox"></td>
                    <td><input class="form-check-input input-primary" type="checkbox"></td>
                    <td><input class="form-check-input input-primary" type="checkbox"></td>
                    <td><input class="form-check-input input-primary" type="checkbox"></td>
                    <td><input class="form-check-input input-primary" type="checkbox"></td>
                    <td><input class="form-check-input input-primary" type="checkbox"></td>
                    <td><input class="form-check-input input-primary" type="checkbox"></td>
                    <td><input class="form-check-input input-primary" type="checkbox"></td>
                    <td><input class="form-check-input input-primary" type="checkbox"></td>
                    <td class="text-center">
                      <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default"><i
                          class="ti ti-trash f-20"></i></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="text-start">
              <hr class="mb-4 mt-0 border-secondary border-opacity-50">
              <button class="btn btn-light-primary d-flex align-items-center gap-2"><i class="ti ti-plus"></i> Add new
                item</button>
                <br>
  <center>
    <button class="btn btn-primary">Save Data</button>
    <button class="btn btn-danger">Print Data</button>
    <button class="btn btn-success">Submitted</button>
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
    $(document).ready(function() {
        if ($(".idev-actionbutton").children().length == 0) {
            $("#dropdownMoreTopButton").remove()
            $(".idev-actionbutton").remove()
        }
        idevTable("list-{{$uri_key}}")
        $('form input').on('keypress', function(e) {
            return e.which !== 13;
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