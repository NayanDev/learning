@extends("easyadmin::backend.parent")
@section("content")
@push('mtitle')
{{$title}}
@endpush

<!-- Include Signature Pad Styles -->
@push('styles')
<style>
.signature-container {
    margin-top: 15px;
}
.signature-method-selector {
    margin-bottom: 15px;
}
.signature-pad {
    border: 2px solid #ddd;
    border-radius: 8px;
    background: white;
    cursor: crosshair;
    width: 100%
}
.signature-actions {
    margin-top: 10px;
    text-align: center;
}
.signature-actions .btn {
    margin: 0 5px;
}
.current-signature {
    max-width: 150px;
    max-height: 80px;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
}
.signature-preview {
    margin-top: 10px;
    text-align: center;
}
.upload-zone {
    border: 2px dashed #ddd;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    background: #f9f9f9;
}
</style>
@endpush

<div class="pc-container">
  <div class="pc-content">

    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h4 class="page-title">My Account</h4>
            <p class="text-muted">Update your profile and signature</p>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-6 col-md-8 col-12">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="card-title mb-0">Profile Information</h5>
          </div>
          <div class="card-body p-3">
            <form id="form-maccount" action="{{url('update-profile')}}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="row">
                @php $method = "create"; @endphp
                @foreach($fields as $key => $field)
                  @if($field['name'] == 'signature')
                    <!-- Custom Signature Field -->
                    <div class="{{ $field['class'] ?? 'col-md-12 my-2' }}">
                      <label class="form-label fw-bold">{{ $field['label'] }}</label>
                      
                      <!-- Current Signature Display -->
                      @if(!empty($field['value']))
                        <div class="current-signature-display mb-3">
                          <small class="text-muted">Current Signature:</small>
                          <br>
                          <img src="{{ $field['value'] }}" alt="Current Signature" class="current-signature">
                        </div>
                      @endif
                      
                      <!-- Signature Creation Options -->
                      <div class="signature-container">
                        <div class="signature-method-selector">
                          <div class="d-flex justify-content-center gap-3">
                            <label class="form-check-label d-flex align-items-center">
                              <input type="radio" name="signature_method" value="draw" class="form-check-input me-2" checked> 
                              <span>✏️ Draw Signature</span>
                            </label>
                            <label class="form-check-label d-flex align-items-center">
                              <input type="radio" name="signature_method" value="upload" class="form-check-input me-2"> 
                              <span>📁 Upload Image</span>
                            </label>
                          </div>
                        </div>
                        
                        <!-- Draw Signature Section -->
                        <div id="draw-signature-section">
                          <div class="text-center mb-2">
                            <small class="text-muted">Draw your signature in the box below</small>
                          </div>
                          <canvas id="signature-pad" class="signature-pad mx-auto d-block" width="400" height="200"></canvas>
                          <div class="signature-actions">
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearSignature()">
                              <i class="ti ti-refresh"></i> Clear
                            </button>
                            <button type="button" class="btn btn-sm btn-primary" onclick="saveSignature()">
                              <i class="ti ti-device-floppy"></i> Save as SVG
                            </button>
                            <button type="button" class="btn btn-sm btn-info" onclick="previewSignature()">
                              <i class="ti ti-eye"></i> Preview
                            </button>
                          </div>
                          <div id="signature-status" class="mt-2 text-center"></div>
                          <div id="signature-preview-draw" class="signature-preview"></div>
                        </div>
                        
                        <!-- Upload Signature Section -->
                        <div id="upload-signature-section" style="display: none;">
                          <div class="upload-zone">
                            <input type="file" name="signature_file" class="form-control mb-2" accept="image/*" onchange="previewUploadedSignature(this)">
                            <small class="text-muted">
                              <i class="ti ti-info-circle"></i> 
                              Upload PNG, JPG, or GIF (max 2MB)
                            </small>
                          </div>
                          <div id="upload-preview" class="signature-preview"></div>
                        </div>
                      </div>
                      
                      <!-- Hidden input to store signature data -->
                      <input type="hidden" name="signature_data" id="signature-data">
                    </div>
                  @else
                    @include('easyadmin::backend.idev.fields.'.$field['type'])
                  @endif
                @endforeach
              </div>
              <hr>
              <div class="d-flex justify-content-end">
                <button type="button" id="btn-for-form-maccount" class="btn btn-primary" onclick="softSubmit('form-maccount','list')">
                  <i class="ti ti-device-floppy"></i> Update Profile
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<!-- Signature Pad CDN -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

<script>
// Initialize Signature Pad
let signaturePad;
let isSignatureSaved = false;

document.addEventListener('DOMContentLoaded', function() {
    initializeSignaturePad();
    setupEventListeners();
});

function initializeSignaturePad() {
    const canvas = document.getElementById('signature-pad');
    if (!canvas) return;
    
    signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)',
        penColor: 'rgb(0, 0, 0)',
        velocityFilterWeight: 0.7,
        minWidth: 0.5,
        maxWidth: 2.5,
        throttle: 16,
        minDistance: 5,
    });
    
    // Listen for signature changes
    signaturePad.addEventListener("afterUpdateStroke", function() {
        isSignatureSaved = false;
        updateSignatureStatus();
    });
    
    resizeCanvas();
}

function setupEventListeners() {
    // Handle signature method change
    const signatureMethodInputs = document.querySelectorAll('input[name="signature_method"]');
    signatureMethodInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.value === 'draw') {
                document.getElementById('draw-signature-section').style.display = 'block';
                document.getElementById('upload-signature-section').style.display = 'none';
            } else {
                document.getElementById('draw-signature-section').style.display = 'none';
                document.getElementById('upload-signature-section').style.display = 'block';
            }
        });
    });
    
    // Resize canvas on window resize
    window.addEventListener("resize", resizeCanvas);
}

function resizeCanvas() {
    const canvas = document.getElementById('signature-pad');
    if (!canvas || !signaturePad) return;
    
    const ratio = Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}

function clearSignature() {
    if (signaturePad) {
        signaturePad.clear();
        document.getElementById('signature-data').value = '';
        document.getElementById('signature-preview-draw').innerHTML = '';
        isSignatureSaved = false;
        updateSignatureStatus();
    }
}

function previewSignature() {
    if (!signaturePad || signaturePad.isEmpty()) {
        showNotification("Please draw a signature first.", "warning");
        return;
    }
    
    const previewDiv = document.getElementById('signature-preview-draw');
    
    try {
        // Generate SVG preview
        const svgData = signaturePad.toSVG();
        previewDiv.innerHTML = `
            <div class="mt-3">
                <small class="text-muted">SVG Preview:</small><br>
                <div class="border rounded p-2 bg-white" style="max-width: 300px; margin: 10px auto;">
                    ${svgData}
                </div>
                <small class="text-success">✓ Vector format (scalable)</small>
            </div>
        `;
    } catch (error) {
        // Fallback to PNG preview
        const dataURL = signaturePad.toDataURL('image/png');
        previewDiv.innerHTML = `
            <div class="mt-3">
                <small class="text-muted">PNG Preview:</small><br>
                <img src="${dataURL}" alt="Signature Preview" class="current-signature">
                <br><small class="text-info">⚠️ Raster format (fixed size)</small>
            </div>
        `;
    }
}

function saveSignature() {
    if (!signaturePad || signaturePad.isEmpty()) {
        showNotification("Please draw a signature first.", "warning");
        return;
    }
    
    // Get signature data as SVG (preferred format)
    try {
        const svgData = signaturePad.toSVG();
        const svgBase64 = 'data:image/svg+xml;base64,' + btoa(svgData);
        document.getElementById('signature-data').value = svgBase64;
        isSignatureSaved = true;
        
        updateSignatureStatus();
        showNotification("Signature saved as SVG format!", "success");
    } catch (error) {
        // Fallback to PNG if SVG fails
        console.warn('SVG generation failed, using PNG fallback:', error);
        const dataURL = signaturePad.toDataURL('image/png');
        document.getElementById('signature-data').value = dataURL;
        isSignatureSaved = true;
        
        updateSignatureStatus();
        showNotification("Signature saved as PNG format!", "success");
    }
}

function updateSignatureStatus() {
    const statusDiv = document.getElementById('signature-status');
    if (!statusDiv) return;
    
    if (signaturePad && signaturePad.isEmpty()) {
        statusDiv.innerHTML = '<small class="text-muted">Canvas is empty</small>';
    } else if (isSignatureSaved) {
        const signatureData = document.getElementById('signature-data').value;
        const format = signatureData.includes('svg+xml') ? 'SVG' : 'PNG';
        const formatClass = format === 'SVG' ? 'success' : 'info';
        statusDiv.innerHTML = `<small class="text-${formatClass}"><i class="ti ti-check"></i> Signature saved as ${format}</small>`;
    } else {
        statusDiv.innerHTML = '<small class="text-warning"><i class="ti ti-alert-triangle"></i> Please save your signature</small>';
    }
}

function previewUploadedSignature(input) {
    const preview = document.getElementById('upload-preview');
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <div>
                    <small class="text-muted">Preview:</small><br>
                    <img src="${e.target.result}" alt="Signature Preview" class="current-signature">
                </div>
            `;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 3000);
}

// Override form submission to validate signature first
document.addEventListener('DOMContentLoaded', function() {
    const originalSoftSubmit = window.softSubmit;
    
    window.softSubmit = function(formId, reloadList, callback = false) {
        // Only validate for profile form
        if (formId === 'form-maccount') {
            const signatureMethod = document.querySelector('input[name="signature_method"]:checked').value;
            
            if (signatureMethod === 'draw') {
                if (!signaturePad.isEmpty() && !isSignatureSaved) {
                    showNotification("Please save your signature first by clicking 'Save as SVG' button.", "warning");
                    return;
                }
            } else if (signatureMethod === 'upload') {
                const fileInput = document.querySelector('input[name="signature_file"]');
                if (fileInput.files.length === 0) {
                    showNotification("Please select a signature file to upload.", "warning");
                    return;
                }
            }
        }
        
        // Call original softSubmit function
        return originalSoftSubmit.call(this, formId, reloadList, callback);
    };
});
</script>
@endpush

@endsection