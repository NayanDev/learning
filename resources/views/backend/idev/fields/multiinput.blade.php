@php 
$prefix_repeatable = (isset($repeatable))? true : false;
$preffix_method = (isset($method))? $method."_": "";

$unique_wrapper_id = 'repeatable-wrapper-' . Str::slug($field['name']);
@endphp
<div id="{{ $unique_wrapper_id }}" class="{{(isset($field['class']))?$field['class']:'form-group'}}">
    <label>{{(isset($field['label']))?$field['label']:'Label '.$key}}</label>
    <div class="{{$preffix_method}}repeatable-sections">
        @php 
        $field_count = 0;
        $enable_action = $field['enable_action'];
        $row_count = sizeof($field['html_fields']);
        $initial_row_id = $preffix_method . 'repeatable-0';
        @endphp
       
        <div id="{{ $initial_row_id }}" class="row {{$preffix_method}}field-sections">

            @foreach($field['html_fields'] as $key2 => $child_fields)
            @php
            $field = $child_fields;
            $repeatable = true;
            $field['name'] = $field['name']."[]";
            @endphp
            @if (View::exists('backend.idev.fields.'.$field['type']))
                @include('backend.idev.fields.'.$field['type'])
            @else
                @include('easyadmin::backend.idev.fields.'.$field['type'])
            @endif
            @endforeach

            @if($enable_action)
            <div class="col-md-1 remove-section">
                <button type='button' class='btn btn-sm btn-circle btn-danger my-4 text-white' onclick="remove('{{ $initial_row_id }}')">
                    <i class='ti ti-minus' data-toggle='tooltip' data-placement='top' title='Remove'> </i>
                </button>
            </div>
            @endif
        </div>
    </div>
    
    @if($enable_action)
    <div class="row">
        <div class="col-md-4">
            {{-- 3. Perbarui fungsi add() untuk meneruskan ID unik wrapper dan prefix --}}
            <button type="button" class="btn btn-sm btn-secondary my-2 text-white" onclick="add('{{ $unique_wrapper_id }}', '{{ $preffix_method }}')">
                <i class="fa fa-plus" data-toggle="tooltip" data-placement="top" title="Add"> </i> +
            </button>
        </div>
    </div>
    @endif
</div>
@push('styles')
    <style>
        .btn-circle{
            border-radius: 50%;
        }
    </style>
@endpush
@push('scripts')
<script>
    // Fungsi add sekarang menerima ID wrapper unik
    function add(wrapperId, preffixMethod) {
        // Targetkan elemen HANYA di dalam wrapper yang benar
        var lastSection = $('#' + wrapperId + ' .' + preffixMethod + 'field-sections:last');
        var clonedRow = lastSection.clone();

        // Reset nilai input pada baris yang baru
        clonedRow.find('input, select, textarea').val('');
        clonedRow.find('input[type=checkbox], input[type=radio]').prop('checked', false);

        // Buat ID unik untuk baris baru
        var epochSeconds = Math.floor(Date.now() / 1000);
        var newRowId = preffixMethod + 'repeatable-' + epochSeconds;
        clonedRow.attr('id', newRowId);
        
        // Perbarui tombol remove di baris baru
        var removeButtonHtml = "<button type='button' class='btn btn-sm btn-circle btn-danger my-4 text-white' onclick='remove(\"" + newRowId + "\")'>" +
                               "<i class='ti ti-minus' data-toggle='tooltip' data-placement='top' title='Remove'> </i>" +
                               "</button>";
        clonedRow.find('.remove-section').html(removeButtonHtml);

        // Tambahkan baris baru ke dalam wrapper yang benar
        $('#' + wrapperId + ' .' + preffixMethod + 'repeatable-sections').append(clonedRow);
    }
    
    // Fungsi remove sekarang lebih sederhana, hanya butuh ID baris yang akan dihapus
    function remove(rowId) {
        $("#" + rowId).remove();
    }
</script>
@endpush