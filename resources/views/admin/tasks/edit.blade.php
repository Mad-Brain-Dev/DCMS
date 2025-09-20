@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div id="success" class="text-success"></div>
                <div class="card">
                    <div class="card-body">
                        @if ($installment->update_type == "general_update")
                        <form enctype="multipart/form-data" action="{{ route("admin.tasks.update", $task->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Take Image Button -->
                            {{--                        <label class="form-label">Gn Case Update</label>--}}
                            <button id="takeImageBtn" class="btn btn-dark mb-3" type="button">Upload Or Select File</button>

                            <!-- Preview container -->
                            <div id="previewContainer" class="mb-3 d-flex flex-wrap"></div>

                            <!-- Hidden file input for fallback -->
                            <input type="file" name="gn_updates[]" id="hiddenGnUpdates" multiple style="display:none;">
                            @error('gn_updates')
                            <p class="error">{{ $message }}</p>
                            @enderror

{{--                            <div class="mb-3">--}}
{{--                                    <label class="form-label">Gn Case Update</label>--}}
{{--                                    <input type="file" name="gn_updates[]" multiple class="form-control">--}}
{{--                                    @error('gn_updates')--}}
{{--                                        <p class="error">{{ $message }}</p>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
                            <div class="mb-3">
                                <label class="form-label">Amount Paid</label>
                                <input type="number" step="0.01" min="0" max="10000000000000" name="amount_paid"
                                    placeholder="Enter Paid Amount Here" value="{{ $installment->amount_paid }}" class="form-control">
                                @error('amount_paid')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Payment Method</label>
                                <select class="form-select" aria-label="Default select example" name="payment_method">
                                    <option selected>Select One Payment Method</option>
                                    <option value="Cash" {{ old('payment_method', $installment->payment_method ?? '') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Check" {{ old('payment_method', $installment->payment_method ?? '') == 'Check' ? 'selected' : '' }}>Check</option>
                                    <option value="Online" {{ old('payment_method', $installment->payment_method ?? '') == 'Online' ? 'selected' : '' }}>Online</option>
                                </select>
                                @error('payment_method')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Whom To Assign</label>
                                <select class="form-select" aria-label="Default select example" name="assign_type">
                                    <option selected>Select One</option>
                                    <option value="Admin" {{ old('assign_type', $installment->assign_type ?? '') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="Accounts" {{ old('assign_type', $installment->assign_type ?? '') == 'Accounts' ? 'selected' : '' }}>Accounts</option>
                                    <option value="Noone">Don't assign to anyone</option>
                                </select>
                                @error('assign_type')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Collected By</label>
                                <select class="form-select select2" id="collected_by_2" name="collected_by_id" aria-label="Default select example">
                                    <option selected disabled>Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('collected_by_id', $installment->collected_by_id ?? '') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('collected_by_id')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date of Payment</label>
                                <input type="date" value="{{ old('date_of_payment', \Carbon\Carbon::parse($installment->date_of_payment)->format('Y-m-d')) }}" name="payment_date" class="form-control">
                                @error('payment_date')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Next Payment Amount</label>
                                <input type="number" step="0.01" min="0" max="10000000000000"
                                value="{{ number_format($installment->next_payment_amount, 2, '.', ',') }}"
                                    name="next_payment_amount" class="form-control" placeholder="Enter Next Payment Amount"
                                    id="next_payment_amount">
                                @error('next_payment_amount')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Next Payment Date</label>
                                <input type="date" name="next_payment_date" value="{{ old('next_payment_date', \Carbon\Carbon::parse($installment->next_payment_date)->format('Y-m-d')) }}" class="form-control"
                                    placeholder="Enter Next Payment Date">
                                @error('next_payment_date')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Field Visit Date</label>
                                <input type="date" name="fv_date" value="{{ old('fv_date', \Carbon\Carbon::parse($installment->fv_date)->format('Y-m-d')) }}" class="form-control">
                                @error('fv_date')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gn Summary</label>
                                <textarea name="gn_summary" class="form-control" id="" rows="2">{{ $general_case_update->gn_summary }}</textarea>
                                @error('gn_summary')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Remarks</label>
                                <input type="text" name="remarks" value="{{ $general_case_update->remarks }}" class="form-control" placeholder="Enter Remarks Here">
                                @error('remarks')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id"> --}}

                            <div class="row">
                                <div class="mb-3 text-end">
                                    <a href="" class="btn btn-light">Cancel</a>
                                    <button class="btn btn-primary waves-effect waves-lightml-2 " type="submit">
                                        <i class="fa fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </form>

                            <!-- Pop-up modal -->
                            <div class="modal fade" id="openPopUpModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Open Camera or Upload Image</h5>
                                            <button id="closePopUpBtn" type="button" class="close" data-bs-dismiss="modal"><span>×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <button id="openCameraBtn" class="btn btn-warning" type="button">Open Camera</button>
                                            <h4 class="text-warning mt-3">OR</h4>
                                            <div class="btn btn-secondary mt-2">
                                                <span>Browse</span>
                                                <input id="fileInput" type="file" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="cancelPopUpBtn" type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Camera modal -->
                            <div class="modal fade" id="openCameraModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Take A Snap</h5>
                                            <button id="closeCameraBtn" type="button" class="close" data-bs-dismiss="modal"><span>×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <video id="videoElement" autoplay playsinline style="width:100%; max-height:400px;"></video>
                                            <canvas id="canvasElement" style="display:none;"></canvas>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="switchCameraBtn" class="btn btn-warning">Switch Camera</button>
                                            <button id="captureBtn" class="btn btn-info">Capture</button>
                                            <button id="cancelCameraBtn" type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--                    camera modal end--}}
                        @else
                        <form enctype="multipart/form-data" action="{{ route("admin.tasks.update", $task->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Take Image Button -->
                            {{--                        <label class="form-label">Gn Case Update</label>--}}
                            <button id="takeFvBtn" class="btn btn-dark mb-3" type="button">Upload Or Select File</button>

                            <!-- Preview container -->
                            <div id="previewFvContainer" class="mb-3 d-flex flex-wrap"></div>

                            <!-- Hidden file input for fallback -->
                            <input type="file" name="fv_updates[]" id="hiddenFvUpdates" multiple style="display:none;">
                            @error('gn_updates')
                            <p class="error">{{ $message }}</p>
                            @enderror

{{--                            <div class="mb-3">--}}
{{--                                <label class="form-label">FV Update</label>--}}
{{--                                <input type="file" name="fv_updates[]" class="form-control" multiple>--}}
{{--                                @error('fv_updates')--}}
{{--                                    <p class="error">{{ $message }}</p>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
                            <div class="mb-3">
                                <label class="form-label">Amount Paid</label>
                                <input type="number" step="0.01" min="0" max="10000000000000" name="amount_paid"
                                    placeholder="Enter Paid Amount Here" value="{{ number_format($installment->amount_paid, 2, '.', ',') }}" class="form-control">
                                @error('amount_paid')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Payment Method</label>
                                <select class="form-select" aria-label="Default select example" name="payment_method">
                                    <option selected>Select One Payment Method</option>
                                    <option value="Cash" {{ old('payment_method', $installment->payment_method ?? '') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Check" {{ old('payment_method', $installment->payment_method ?? '') == 'Check' ? 'selected' : '' }}>Check</option>
                                    <option value="Online" {{ old('payment_method', $installment->payment_method ?? '') == 'Online' ? 'selected' : '' }}>Online</option>
                                </select>
                                @error('payment_method')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Whom To Assign</label>
                                <select class="form-select" aria-label="Default select example" name="assign_type">
                                    <option selected>Select One</option>
                                    <option value="Admin" {{ old('assign_type', $installment->assign_type ?? '') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="Accounts" {{ old('assign_type', $installment->assign_type ?? '') == 'Accounts' ? 'selected' : '' }}>Accounts</option>
                                    <option value="Noone">Don't assign to anyone</option>
                                </select>
                                @error('assign_type')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Collected By</label>
                                <select class="form-select select2" id="collected_by_2" name="collected_by_id" aria-label="Default select example">
                                    <option selected disabled>Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('collected_by_id', $installment->collected_by_id ?? '') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('collected_by_id')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date of Payment</label>
                                <input type="date" name="payment_date" value="{{ old('date_of_payment', \Carbon\Carbon::parse($installment->date_of_payment)->format('Y-m-d')) }}" class="form-control">
                                @error('payment_date')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Next Payment Amount</label>
                                <input type="number" step="0.01" min="0" max="10000000000000"
                                    name="next_payment_amount" class="form-control" value="{{ number_format($installment->next_payment_amount, 2, '.', ',') }}" placeholder="Enter Next Payment Amount"
                                    id="next_payment_amount">
                                @error('next_payment_amount')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Next Payment Date</label>
                                <input type="date" name="next_payment_date" class="form-control"
                                value="{{ old('date_of_payment', \Carbon\Carbon::parse($installment->next_payment_date)->format('Y-m-d')) }}"  placeholder="Enter Interest Start Date">
                                @error('next_payment_date')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Field Visit Date</label>
                                <input type="date" name="fv_date" value="{{ old('date_of_payment', \Carbon\Carbon::parse($installment->fv_date)->format('Y-m-d')) }}" class="form-control">
                                @error('fv_date')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">FV Summary</label>
                                <textarea name="fv_summary" class="form-control" id="" rows="2">{{ $fv_case_update->fv_summary }}</textarea>
                                @error('fv_summary')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Remarks</label>
                                <input type="text" name="remarks" class="form-control" value="{{ $fv_case_update->remarks }}" placeholder="Enter Remarks Here">
                                @error('remarks')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id"> --}}

                            <div class="row">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <div class="div">
                                            <a href=""
                                                class="btn btn-light">Cancel</a>
                                            <button class="btn btn-primary waves-effect waves-lightml-2 " type="submit">
                                                <i class="fa fa-save"></i> Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>


                            <!-- Upload / Camera Popup Modal -->
                            <div class="modal fade" id="fvPopUpModal" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Upload File or Open Camera</h5>
                                            <button type="button" class="close" id="closeFvPopupBtn"><span>&times;</span></button>
                                        </div>
                                        {{--                                <div class="modal-body text-center">--}}
                                        {{--                                    <button type="button" id="openFvCameraBtn" class="btn btn-warning mb-2">Open Camera</button>--}}
                                        {{--                                    <h5 class="mt-2">OR</h5>--}}
                                        {{--                                    <input type="file" id="fvFileInput" multiple style="margin-top:10px;">--}}
                                        {{--                                </div>--}}
                                        {{--                                <div class="modal-footer">--}}
                                        {{--                                    <button type="button" id="cancelFvPopupBtn" class="btn btn-danger">Cancel</button>--}}
                                        {{--                                </div>--}}

                                        <div class="modal-body">
                                            <button id="openFvCameraBtn" class="btn btn-warning" type="button">Open Camera</button>
                                            <h4 class="text-warning mt-3">OR</h4>
                                            <div class="btn btn-secondary mt-2">
                                                <span>Browse</span>
                                                <input id="fvFileInput" type="file" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="cancelFvPopupBtn" type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Camera Modal -->
                            <div class="modal fade" id="fvCameraModal" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Take A Snap</h5>
                                            <button type="button" class="close" id="closeFvCameraBtn"><span>&times;</span></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <video id="fvVideoElement" autoplay playsinline style="width:100%; max-height:400px;"></video>
                                            <canvas id="fvCanvasElement" style="display:none;"></canvas>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="switchFvCameraBtn" class="btn btn-warning">Switch Camera</button>
                                            <button type="button" id="captureFvBtn" class="btn btn-info">Capture</button>
                                            <button type="button" id="cancelFvCameraBtn" class="btn btn-danger">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--                    camera modal end--}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(function () {
            let cameraStream = null;
            let currentFacingMode = 'environment';
            const form_data = []; // holds all files
            const PREVIEW_HEIGHT = 120;

            function stopCameraStream() {
                if (cameraStream) {
                    cameraStream.getTracks().forEach(track => track.stop());
                    cameraStream = null;
                }
                const video = document.getElementById('videoElement');
                if(video){ video.pause(); video.srcObject=null; }
            }

            async function startCamera() {
                stopCameraStream();
                const video = document.getElementById('videoElement');
                try {
                    cameraStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: { ideal: currentFacingMode } } });
                    video.srcObject = cameraStream;
                    await video.play();
                } catch(err) {
                    alert('Camera error: ' + err.message);
                    $('#openCameraModal').modal('hide');
                }
            }

            function snapshot() {
                const video = document.getElementById('videoElement');
                const canvas = document.getElementById('canvasElement');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

                canvas.toBlob(function(blob){
                    const file = new File([blob], "capture_" + Date.now() + ".png", {type:"image/png"});
                    form_data.push(file);
                    updateHiddenInput();
                    showPreview(file);
                }, 'image/png');

                stopCameraStream();
                $('#openCameraModal').modal('hide');
            }

            function updateHiddenInput() {
                const dt = new DataTransfer();
                form_data.forEach(f => dt.items.add(f));
                $('#hiddenGnUpdates')[0].files = dt.files;
            }

            function showPreview(file){
                const $wrapper = $('<div>').addClass('position-relative mr-2 mb-2').css({
                    width:'120px', height:PREVIEW_HEIGHT+'px', textAlign:'center', margin:'5px'
                });
                const isImage = file.type.startsWith('image/');
                let $content;

                if(isImage){
                    const reader = new FileReader();
                    reader.onload = function(e){
                        $content = $('<img>').attr('src', e.target.result)
                            .css({height:PREVIEW_HEIGHT+'px', width:'auto', maxWidth:'100%', border:'1px solid #ccc', borderRadius:'4px'});
                        $wrapper.append($content);
                    };
                    reader.readAsDataURL(file);
                } else {
                    $content = $('<div>').text(file.name).css({
                        width:'100%', height:'100%', display:'flex', alignItems:'center', justifyContent:'center',
                        border:'1px solid #ccc', borderRadius:'4px', background:'#f8f9fa', fontSize:'12px', padding:'5px', wordBreak:'break-word'
                    });
                    $wrapper.append($content);
                }

                const $removeBtn = $('<button type="button" class="btn btn-sm btn-danger" style="position:absolute; top:2px; right:2px; z-index:10;">×</button>');
                $removeBtn.on('click', function(){
                    const index = $wrapper.index();
                    form_data.splice(index,1);
                    updateHiddenInput();
                    $wrapper.remove();
                });

                $wrapper.append($removeBtn);
                $('#previewContainer').append($wrapper);
            }

            function uploadFiles(files){
                Array.from(files).forEach(file => {
                    form_data.push(file);
                    showPreview(file);
                });
                updateHiddenInput();
                $('#fileInput').val('');
                $('#openPopUpModal').modal('hide');
            }

            // --- Events ---
            $('#takeImageBtn').on('click', () => $('#openPopUpModal').modal('show'));
            $('#closePopUpBtn, #cancelPopUpBtn').on('click', () => $('#openPopUpModal').modal('hide'));
            $('#openCameraBtn').on('click', () => {
                $('#openPopUpModal').modal('hide');
                $('#openCameraModal').modal('show');
                startCamera();
            });
            $('#closeCameraBtn, #cancelCameraBtn').on('click', stopCameraStream);
            $('#switchCameraBtn').on('click', () => { currentFacingMode = currentFacingMode==='user'?'environment':'user'; startCamera(); });
            $('#captureBtn').on('click', snapshot);
            $('#fileInput').on('change', function(e){ uploadFiles(e.target.files); });

            $('#openCameraModal').on('hidden.bs.modal', stopCameraStream);
        });
    </script>

    {{--    FV Update script--}}

    <script>
        $(function(){
            const fvFiles = [];
            let cameraStream = null;
            let currentFacingMode = 'environment';
            const PREVIEW_HEIGHT = 120;

            // --- Helpers ---
            function updateHiddenFvInput(){
                const dt = new DataTransfer();
                fvFiles.forEach(f => dt.items.add(f));
                $('#hiddenFvUpdates')[0].files = dt.files;
            }

            function showFvPreview(file){
                const $wrapper = $('<div>').css({position:'relative', margin:'5px', width:'120px', height:PREVIEW_HEIGHT+'px', textAlign:'center'});
                const isImage = file.type.startsWith('image/');
                let $content;

                if(isImage){
                    const reader = new FileReader();
                    reader.onload = e => {
                        $content = $('<img>').attr('src', e.target.result).css({height:PREVIEW_HEIGHT+'px', width:'auto', maxWidth:'100%', border:'1px solid #ccc', borderRadius:'4px'});
                        $wrapper.append($content);
                    };
                    reader.readAsDataURL(file);
                } else {
                    $content = $('<div>').text(file.name).css({
                        width:'100%', height:'100%', display:'flex', alignItems:'center', justifyContent:'center',
                        border:'1px solid #ccc', borderRadius:'4px', background:'#f8f9fa', fontSize:'12px', padding:'5px', wordBreak:'break-word'
                    });
                    $wrapper.append($content);
                }

                const $removeBtn = $('<button type="button" class="btn btn-sm btn-danger" style="position:absolute; top:2px; right:2px; z-index:10;">×</button>');
                $removeBtn.on('click', function(){
                    const index = $wrapper.index();
                    fvFiles.splice(index,1);
                    updateHiddenFvInput();
                    $wrapper.remove();
                });

                $wrapper.append($removeBtn);
                $('#previewFvContainer').append($wrapper);
            }

            function handleFvFiles(files){
                Array.from(files).forEach(file=>{
                    fvFiles.push(file);
                    showFvPreview(file);
                });
                updateHiddenFvInput();
            }

            // --- Camera ---
            async function startFvCamera(){
                stopFvCamera();
                const video = document.getElementById('fvVideoElement');
                try {
                    cameraStream = await navigator.mediaDevices.getUserMedia({video:{facingMode:{ideal:currentFacingMode}}});
                    video.srcObject = cameraStream;
                    await video.play();
                } catch(err){
                    alert('Camera error: '+err.message);
                    $('#fvCameraModal').modal('hide');
                }
            }

            function stopFvCamera(){
                if(cameraStream){
                    cameraStream.getTracks().forEach(track=>track.stop());
                    cameraStream=null;
                }
            }

            function captureFvSnapshot(){
                const video = document.getElementById('fvVideoElement');
                const canvas = document.getElementById('fvCanvasElement');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video,0,0,canvas.width,canvas.height);
                canvas.toBlob(function(blob){
                    const file = new File([blob], "capture_"+Date.now()+".png", {type:"image/png"});
                    fvFiles.push(file);
                    showFvPreview(file);
                    updateHiddenFvInput();
                },'image/png');
                $('#fvCameraModal').modal('hide');
                stopFvCamera();
            }

            // --- Events ---
            $('#takeFvBtn').on('click', ()=>$('#fvPopUpModal').modal('show'));
            $('#closeFvPopupBtn, #cancelFvPopupBtn').on('click', ()=>$('#fvPopUpModal').modal('hide'));

            $('#fvFileInput').on('change', function(e){
                handleFvFiles(e.target.files);
                $(this).val('');
                $('#fvPopUpModal').modal('hide');
            });

            $('#openFvCameraBtn').on('click', ()=>{
                $('#fvPopUpModal').modal('hide');
                $('#fvCameraModal').modal('show');
                startFvCamera();
            });

            $('#captureFvBtn').on('click', captureFvSnapshot);
            $('#switchFvCameraBtn').on('click', ()=>{
                currentFacingMode = currentFacingMode === 'user' ? 'environment' : 'user';
                startFvCamera();
            });

            $('#closeFvCameraBtn, #cancelFvCameraBtn').on('click', ()=>{
                stopFvCamera();
                $('#fvCameraModal').modal('hide');
            });

            $('#fvCameraModal').on('hidden.bs.modal', stopFvCamera);
        });
    </script>
@endpush
