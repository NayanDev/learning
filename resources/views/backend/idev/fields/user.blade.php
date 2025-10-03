@php
$prefix_repeatable = (isset($repeatable))? true : false;
$select_id = (isset($field['name']))?$field['name']:'id_'.$key;
$select_name = (isset($field['name']))?$field['name']:'name_'.$key;
$preffix_method = (isset($method))? $method."_": "";
@endphp
<div class="{{(isset($field['class']))?$field['class']:'form-group'}}">
    <label>{{(isset($field['label']))?$field['label']:'Label '.$key}}
        @if(isset($field['required']) && $field['required'])
        <small class="text-danger">*</small>
        @endif
    </label>
    <select 
        id="{{$preffix_method}}{{$select_id}}" 
        name="{{$select_name}}" 
        class="form-control idev-form support-live-select2 @if($prefix_repeatable) field-repeatable @endif"
        @if(isset($field['data-target'])) 
        data-target="{{$field['data-target']}}"
        @endif>
        <option value="">-- Select Employee --</option>
        @foreach($field['options'] as $key => $opt)
        <option value="{{$opt['value']}}" 
            @if($opt['value'] == $field['value'] || $opt['value'] == request($select_name)) selected @endif
            data-email="{{$opt['email'] ?? ''}}"
            data-name="{{$opt['name'] ?? ''}}"
        >{{$opt['text']}}</option>
        @endforeach
    </select>
</div>

@if(isset($field['filter']) || isset($field['autofill']))
@push('scripts')
<script>
$(document).ready(function() {
    // Filter functionality
    @if(isset($field['filter']))
    var currentUrl = "{{url()->current()}}";
    $('#{{$select_id}}').on('change', function() {
        if (currentUrl.includes("?")) {
            currentUrl += "&{{$select_name}}="+$(this).val();
        } else {
            currentUrl += "?{{$select_name}}="+$(this).val();
        }
        window.location.replace(currentUrl);
    });
    @endif

    // Autofill functionality
    @if(isset($field['autofill']) && $field['autofill'])
    $('#{{$preffix_method}}{{$select_id}}').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var email = selectedOption.data('email') || '';
        var name = selectedOption.data('name') || '';
        
        console.log('Selected:', {
            email: email,
            name: name
        });

        // Target specific input fields
        $('#{{$preffix_method}}name').val(name);
        $('#{{$preffix_method}}email').val(email);
    });

    // Trigger change if option is pre-selected
    if ($('#{{$preffix_method}}{{$select_id}}').val()) {
        $('#{{$preffix_method}}{{$select_id}}').trigger('change');
    }
    @endif
});
</script>
@endpush
@endif