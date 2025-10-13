<div class="{{(isset($field['class']))?$field['class']:'form-group'}}">
    <label>{{(isset($field['label']))?$field['label']:'Label '.$key}}</label>
    <div class="field-bulktable">
        <div class="row">
            <div class="col-md-6">
                <span class="total-data-{{$field['name']}}"></span>
            </div>
            <div class="col-md-3">
                <span class="total-checked-{{$field['name']}} fw-bold">0 Checked</span>
            </div>
            <div class="col-md-3">
                <input type="text" placeholder="search..." class="form-control form-control-sm search-{{$field['name']}}">
            </div>
        </div>
        <table class="table idev-table table-responsive ajx-table-{{$field['name']}}">
            <thead>
                <tr>
                    <th>
                        # <!--input type="checkbox" class="check-all-{{$field['name']}}" value="flagall" -->
                    </th>
                    @foreach($field['table_headers'] as $header)
                    <th style="white-space: nowrap;">{{$header}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div class="paginate-{{$field['name']}}"></div>
        <input type="hidden" name="{{$field['name']}}" class="json-{{$field['name']}}" value="[]">
    </div>
</div>

@push('scripts')
<script>
    var ajaxUrl = "{{$field['ajaxUrl']}}"
    var primaryKey = "{{$field['key']}}"
    var stateKey = []
    $(document).ready(function() {
        getTableContent(ajaxUrl)

        // $(".check-all-{{$field['name']}}").change(function(){
        //     $(".check-{{$field['name']}}").prop('checked', $(this).prop('checked'))
        // })

        $(".search-{{$field['name']}}").keyup(delay(function(e) {
            var dInput = this.value;
            if (dInput.length > 3 || dInput.length == 0) {
                getTableContent(ajaxUrl + "?search=" + dInput)
            }
        }, 500))
    });

    function getTableContent(ajaxUrl) {
        $.get(ajaxUrl, function(response) {
            var headers = response.header;
            var bodies = response.body;
            var mHtml = "";
            var intCurrentData = 0;
        
            // Buat header tabel
            // mHtml += "<tr>";
            // mHtml += "<td><input type='checkbox' class='check-all-{{$field['name']}}'></td>";
            // headers.forEach(function(header) {
            //     mHtml += "<td>" + header + "</td>";
            // });
            // mHtml += "</tr>";
            
            // Buat body tabel
            $.each(bodies.data, function(index, item) {
                mHtml += "<tr>";
                mHtml += "<td><input type='checkbox' class='check-{{$field['name']}}' " +
                         "data-nama='" + item.nama + "' " +
                         "value='" + item.nama + "'></td>";
                mHtml += "<td>" + item.nama + "</td>";
                mHtml += "<td>" + item.divisi + "</td>";
                mHtml += "<td>" + item.unit_kerja + "</td>";
                mHtml += "<td>" + item.nik + "</td>";
                mHtml += "</tr>";
                intCurrentData++;
            });

            var paginateLink = ""
            $.each(bodies.links, function(index, link) {
                if (link.url != null && link.label != "&laquo; Previous" && link.label != "Next &raquo;") {
                    var linkActive = link.active ? "btn-primary" : "btn-outline-primary"
                    paginateLink += "<button data-url='" + link.url + "' class='btn btn-sm btn-paginate-{{$field['name']}} " + linkActive + "' type='button'>" + link.label + "</button>"
                }
            })

            $(".paginate-{{$field['name']}}").html(paginateLink)
            $(".ajx-table-{{$field['name']}} tbody").html(mHtml)

            $(".btn-paginate-{{$field['name']}}").click(function() {
                getTableContent($(this).data('url'))
            })

            $(".ajx-table-{{$field['name']}} tbody").html(mHtml);

            // Event handler untuk checkbox
            $(".check-{{$field['name']}}").change(function() {
                var namaValue = $(this).data('nama');
                console.log('Checkbox changed, Nama:', namaValue); // Debug

                if ($(this).prop('checked')) {
                    if (!stateKey.includes(namaValue)) {
                        stateKey.push(namaValue);
                    }
                } else {
                    stateKey = stateKey.filter(item => item !== namaValue);
                }

                console.log('Current stateKey:', stateKey); // Debug
                $(".json-{{$field['name']}}").val(JSON.stringify(stateKey));
                $(".total-checked-{{$field['name']}}").text(stateKey.length + " Checked");
            });

            // Check all handler
            $(".check-all-{{$field['name']}}").change(function() {
                var isChecked = $(this).prop('checked');
                stateKey = [];
                
                if (isChecked) {
                    $(".check-{{$field['name']}}").each(function() {
                        var nama = $(this).data('nama');
                        if (!stateKey.includes(nama)) {
                            stateKey.push(nama);
                        }
                        $(this).prop('checked', true);
                    });
                } else {
                    $(".check-{{$field['name']}}").prop('checked', false);
                }

                $(".json-{{$field['name']}}").val(JSON.stringify(stateKey));
                $(".total-checked-{{$field['name']}}").text(stateKey.length + " Checked");
            });

            $(".total-data-{{$field['name']}}").text("Total : " + intCurrentData + "/" + bodies.total + " Data (s)");
        });
    }

    function removeStateKey(arr, elementToRemove) {
        return arr.filter(function(item) {
            return item !== elementToRemove;
        });
    }
</script>
@endpush