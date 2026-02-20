@extends('layouts.master')
@section('content')
    <!-- STICKY WRAPPER -->
    <div id="caseStickyWrapper">
        <div class="row">
            <div class="col-md-12">
                <!-- CASE SUMMARY CARD -->
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <span>Case No. : {{ $case->case_sku }}</span> <br>
                                <span>Client Name : {{ $case->client->name }} </span> <br>
                                <span>Current Status : {{ getCaseStatus($case->current_status) }}</span> <br>
                                <span>Next Payment Date :
                                                                            @if (empty($installment->next_payment_date))
                                        <span>N/A</span>
                                    @else
                                        {{ date('m-d-Y', strtotime($installment->next_payment_date)) }}
                                    @endif
                                                                        </span>
                            </div>
                            <div class="col-md-3">
                                        <span>Total Amount Owed : $ {{ number_format($case->total_amount_owed, 2, '.', ',') }}
                                </span> <br>
                                <span>Total Paid : $ {{totalPaid($case->id)}}</span><br>
                                <span>Current Balance : $ {{ totalBalance($case->id) }}</span><br>
                                <span>Next Payment Amount :

                                                                            @if (empty($installment->next_payment_amount))
                                        <span>N/A</span>
                                    @else
                                        $ {{ number_format($installment->next_payment_amount, 2, '.', ',') }}
                                    @endif

                                                                        </span>

                            </div>
                            <div class="col-md-6">
                                <span><span class="text-decoration-underline">Case Remarks :</span> {{ $case->remarks }} </span> <br>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <!-- TABS NAV -->
                <div class="">
                    <ul class="nav nav-pills nav-fill mb-3 update-tabs" id="updateTabs" role="tablist">

                        <!-- ALL DEBTORS (DEFAULT TAB) -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active"
                                    id="debtors-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#all-debtors"
                                    type="button"
                                    role="tab"
                                    aria-controls="all-debtors"
                                    aria-selected="true">
                                <i class="fas fa-users me-1"></i>
                                All Debtors
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link"
                                    id="general-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#general-updates"
                                    type="button"
                                    role="tab"
                                    aria-controls="general-updates">
                                <i class="fas fa-layer-group me-1"></i>
                                General Updates
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link"
                                    id="payment-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#payment-updates"
                                    type="button"
                                    role="tab"
                                    aria-controls="payment-updates">
                                <i class="fas fa-credit-card me-1"></i>
                                Payment Updates
                            </button>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB CONTENT (NOT FIXED) -->
    <div id="tabContentWrapper">
        <div class="tab-content" id="updateTabsContent">

            <!-- ALL DEBTORS TAB -->
            <div class="tab-pane fade show active"
                 id="all-debtors"
                 role="tabpanel"
                 aria-labelledby="debtors-tab">

                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center table-outer-border p-2 bg-soft-lime text-lime">
                            All Debtors
                        </h5>

                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Total paid by this DB</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($case->debtors as $debtor)
                                    <tr>
                                        <td>{{ $debtor->name }}</td>
                                        <td>{{ $debtor->phone }}</td>
                                        <td>{{ $debtor->email }}</td>
                                        <td>{{ $debtor->address }}</td>
                                        <td>{{ $debtor->installments->sum('amount_paid') ?? 0 }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>

            {{-- GENERAL UPDATES TAB --}}
            <div class="tab-pane fade"
                 id="general-updates"
                 role="tabpanel"
                 aria-labelledby="general-tab">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">

                                <h5 class="text-center table-outer-border p-2 bg-soft-lime text-lime">
                                    General Updates
                                </h5>

                                <div id="timeline">

                                    @php
                                        $groupedUpdates = $gn_updates->groupBy(function ($item) {
                                            return \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:i');
                                        });
                                    @endphp

                                    @foreach ($groupedUpdates as $time => $updates)
                                        <div class="timeline-group general-group">

                                            {{-- HEADER (TIME + GROUP ACTIONS) --}}
                                            <div class="d-flex justify-content-between align-items-center mb-2">

                                                <div class="timeline-time text-primary">
                                                    {{ \Carbon\Carbon::parse($time)->format('m-d-Y, h:i a') }}
                                                </div>

                                                {{-- GROUP ACTIONS (EDIT / DELETE FULL GENERAL UPDATE) --}}
                                                @if(Auth::user()->user_type == \App\Models\User::USER_TYPE_ADMIN && $task->status == 'not_complete')
                                                    <div class="payment-actions">
                                                        <a href="{{ route('admin.tasks.edit', $task->id) }}"
                                                           class="action-icon edit"
                                                           title="Edit this general update">
                                                            <i class="fas fa-pen"></i>
                                                        </a>

                                                        <form action="{{ route('admin.tasks.destroy', $task->id) }}"
                                                              method="POST"
                                                              class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="action-icon delete"
                                                                    title="Delete this general update"
                                                                    onclick="return confirm('Are you sure you want to delete this general update?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- FILE GRID --}}
                                            <div class="timeline-grid">
                                                @foreach ($updates as $gn_update)
                                                    @php
                                                        $file = $gn_update->gn_update;
                                                        $ext = $file ? strtolower(pathinfo($file, PATHINFO_EXTENSION)) : null;
                                                    @endphp

                                                    <div class="timeline-item gn-thumb"
                                                         data-id="{{ $gn_update->id }}">

                                                        @if ($file)
                                                            @if ($ext === 'pdf')
                                                                <div class="file-thumb pdf-thumb">
                                                                    <i class="far fa-file-pdf"></i>
                                                                    <span>PDF</span>
                                                                </div>
                                                            @else
                                                                <img src="{{ asset('/documents/' . $file) }}" />
                                                            @endif
                                                        @else
                                                            <div class="file-thumb empty-thumb">
                                                                <small>No file</small>
                                                            </div>
                                                        @endif

                                                    </div>
                                                @endforeach
                                            </div>

                                            {{-- DETAILS --}}
                                            <div class="mt-3">
                                                <h6 class="text-primary">
                                                    Summary:
                                                    <span class="text-muted">
                                    {{ $updates->first()->gn_summary }}
                                </span>
                                                </h6>
                                            </div>

                                            <hr>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- PAYMENT UPDATES TAB --}}
            <div class="tab-pane fade"
                 id="payment-updates"
                 role="tabpanel"
                 aria-labelledby="payment-tab">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">

                                <h5 class="text-center table-outer-border p-2 bg-soft-lime text-lime">
                                    Payment Updates
                                </h5>

                                <div id="fv-timeline">

                                    @php
                                        $groupedFvUpdates = $fv_updates->groupBy(function ($item) {
                                            return \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:i');
                                        });
                                    @endphp

                                    @foreach ($groupedFvUpdates as $time => $updates)
                                        <div class="timeline-group payment-group">

                                            {{-- HEADER (TIME + ACTIONS) --}}
                                            <div class="d-flex justify-content-between align-items-center mb-2">

                                                <div class="timeline-time text-primary">
                                                    {{ \Carbon\Carbon::parse($time)->format('m-d-Y, h:i a') }}
                                                </div>

                                                {{-- GROUP ACTIONS (EDIT / DELETE FULL PAYMENT UPDATE) --}}
                                                @if(Auth::user()->user_type == \App\Models\User::USER_TYPE_ADMIN && $task->status == 'not_complete')
                                                    <div class="payment-actions">
                                                        <a href="{{ route('admin.tasks.edit', $task->id) }}"
                                                           class="action-icon edit btn btn-sm btn-outline-primary"
                                                           title="Edit this payment update">
                                                            <i class="fas fa-pen"></i>
                                                        </a>

                                                        <form action="{{ route('admin.tasks.destroy', $task->id) }}"
                                                              method="POST"
                                                              class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="action-icon delete"
                                                                    title="Delete this payment update"
                                                                    onclick="return confirm('Are you sure you want to delete this payment update?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- FILE GRID --}}
                                            <div class="timeline-grid">
                                                @foreach ($updates as $fv_update)
                                                    @php
                                                        $file = $fv_update->fv_update;
                                                        $ext = $file ? strtolower(pathinfo($file, PATHINFO_EXTENSION)) : null;
                                                    @endphp

                                                    <div class="timeline-item fv-thumb"
                                                         data-id="{{ $fv_update->id }}">

                                                        @if ($file)
                                                            @if ($ext === 'pdf')
                                                                <div class="file-thumb pdf-thumb">
                                                                    <i class="far fa-file-pdf"></i>
                                                                    <span>PDF</span>
                                                                </div>
                                                            @else
                                                                <img src="{{ asset('/documents/' . $file) }}" />
                                                            @endif
                                                        @else
                                                            <div class="file-thumb empty-thumb">
                                                                <small>No file</small>
                                                            </div>
                                                        @endif

                                                    </div>
                                                @endforeach
                                            </div>

                                            {{-- DETAILS --}}
                                            <div class="mt-3">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <h6 class="text-primary">
                                                            Amount Paid:
                                                            <span class="text-muted">
                                                                        {{ $updates->first()->installment->amount_paid}}
                                                                    </span>
                                                        </h6>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6 class="text-primary">
                                                            Payment Method:
                                                            <span class="text-muted">
                                                                        {{ $updates->first()->installment->payment_method}}
                                                                    </span>
                                                        </h6>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6 class="text-primary">
                                                            Collected by:
                                                            <span class="text-muted">
                                                                        {{user_fullname($updates->first()->installment->user)}}
                                                                    </span>
                                                        </h6>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6 class="text-primary">
                                                            Date of payment:
                                                            <span class="text-muted">
                                                                        {{ $updates->first()->installment->date_of_payment ? date('m-d-Y', strtotime($updates->first()->installment->date_of_payment)) : 'N/A' }}
                                                                    </span>
                                                        </h6>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6 class="text-primary">
                                                            Next payment Date:
                                                            <span class="text-muted">
                                                                                {{ $updates->first()->installment->next_payment_date ? date('m-d-Y', strtotime($updates->first()->installment->next_payment_date)) : 'N/A' }}
                                                                            </span>
                                                            @php
                                                                $dateStatus = $updates->first()->installment->nextPaymentDateStatus();
                                                            @endphp
                                                            <span class="badge bg-{{ $dateStatus['class'] }} status-badge"
                                                                  data-bs-toggle="tooltip"
                                                                  data-bs-placement="top"
                                                                  title="{{ $dateStatus['tooltip'] }}">
                                                                                {{ $dateStatus['label'] }}
                                                                            </span>
                                                        </h6>
                                                        <small class="text-muted d-block mt-1">
                                                            Timing status is based on the next recorded payment date.
                                                        </small>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6 class="text-primary">
                                                            Next Payment Amount:
                                                            <span class="text-muted">
                                                                                {{ $updates->first()->installment->next_payment_amount ?? 'N/A' }}
                                                                            </span>
                                                            @php
                                                                $status = $updates->first()->installment->paymentStatus();
                                                            @endphp
                                                            <span class="badge bg-{{ $status['class'] }} status-badge"
                                                                  data-bs-toggle="tooltip"
                                                                  data-bs-placement="top"
                                                                  title="{{ $status['tooltip'] }}">
                                                                                {{ $status['label'] }}
                                                                            </span>
                                                        </h6>
                                                        <small class="text-muted d-block mt-1">
                                                            Status is Based on the next recorded payment.
                                                        </small>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <h6 class="text-primary">
                                                            Remarks:
                                                            <span class="text-muted">
                                                                        {{ $updates->first()->remarks }}
                                                                    </span>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    {{--    GN update camera modal start--}}
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
    {{--    GN update camera modal end--}}
    {{--    GN update file modal start start--}}
    <!-- Modal for General Update -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">General Update</h5>
                </div>
                <div class="modal-body text-center">
                    <!-- Image preview -->
                    <img id="gn_image_preview" src="" alt="GN Update"
                         style="max-width:100%; max-height:400px; height:auto; margin:auto; display:block;">

                    <!-- PDF preview -->
                    <iframe id="gn_pdf_preview" src="" width="100%" height="400" style="display:none;"></iframe>

                    <!-- Unsupported file -->
                    <div id="gn_file_preview" style="display:none;">
                        <p>Preview not available. <a id="gn_file_link" href="" target="_blank">Download file</a></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeGnModalBtn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--    GN update file modal start end--}}
    {{--    payment camera modals start--}}
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
    {{--    payment camera modals end--}}
    {{--    payment update modal start--}}
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Update</h5>
                </div>
                <div class="modal-body text-center">
                    <!-- Image preview -->
                    <img id="fv_image_preview" src="" alt="FV Update"
                         style="max-width:100%; max-height:400px; height:auto; display:none; margin:auto; display:block;">

                    <!-- PDF preview -->
                    <iframe id="fv_pdf_preview" src="" width="100%" height="400" style="display:none;"></iframe>

                    <!-- Unsupported file -->
                    <div id="fv_file_preview" style="display:none;">
                        <p>Preview not available. <a id="fv_file_link" href="" target="_blank">Download file</a></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeFvModalBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--    payment update modal end--}}
    <div class="row" hidden="hidden">
        <div class="col-md-12 parent-fixed">
            <div class="fixed-content">
                {{-- add id="fixedDiv" in row if want fix div--}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <span>Case No. : {{ $case->case_sku }}</span> <br>
                                        <span>Client Name : {{ $case->client->name }} </span> <br>
                                        <span>Current Status : {{ $case->current_status }}</span> <br>
                                        <span>Next Payment Date :
                                                                            @if (empty($installment->next_payment_date))
                                                <span>N/A</span>
                                            @else
                                                {{ date('m-d-Y', strtotime($installment->next_payment_date)) }}
                                            @endif
                                                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <span>Total Amount Owed : $ {{ number_format($case->total_amount_owed, 2, '.', ',') }}
                                </span> <br>
                                        <span>Total Paid : $ {{totalPaid($case->id)}}</span><br>
                                        <span>Current Balance : $ {{ totalBalance($case->id) }}</span><br>
                                        <span>Next Payment Amount :

                                                                            @if (empty($installment->next_payment_amount))
                                                <span>N/A</span>
                                            @else
                                                $ {{ number_format($installment->next_payment_amount, 2, '.', ',') }}
                                            @endif

                                                                        </span>

                                    </div>
                                    <div class="col-md-6">
                                        <span><span class="text-decoration-underline">Case Remarks :</span> {{ $case->remarks }} </span> <br>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- tabs--}}
                    <div class="col-md-12">
                        <div class="">
                            <ul class="nav nav-pills nav-fill mb-3 update-tabs" id="updateTabs" role="tablist">

                                <!-- ALL DEBTORS (DEFAULT TAB) -->
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active"
                                            id="debtors-tab"
                                            data-bs-toggle="pill"
                                            data-bs-target="#all-debtors"
                                            type="button"
                                            role="tab"
                                            aria-controls="all-debtors"
                                            aria-selected="true">
                                        <i class="fas fa-users me-1"></i>
                                        All Debtors
                                    </button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link"
                                            id="general-tab"
                                            data-bs-toggle="pill"
                                            data-bs-target="#general-updates"
                                            type="button"
                                            role="tab"
                                            aria-controls="general-updates">
                                        <i class="fas fa-layer-group me-1"></i>
                                        General Updates
                                    </button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link"
                                            id="payment-tab"
                                            data-bs-toggle="pill"
                                            data-bs-target="#payment-updates"
                                            type="button"
                                            role="tab"
                                            aria-controls="payment-updates">
                                        <i class="fas fa-credit-card me-1"></i>
                                        Payment Updates
                                    </button>
                                </li>

                            </ul>
                        </div>
                        <div class="tab-content" id="updateTabsContent">

                            <!-- ALL DEBTORS TAB -->
                            <div class="tab-pane fade show active"
                                 id="all-debtors"
                                 role="tabpanel"
                                 aria-labelledby="debtors-tab">

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-center table-outer-border p-2 bg-soft-lime text-lime">
                                            All Debtors
                                        </h5>

                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Email</th>
                                                    <th>Address</th>
                                                    <th>Total paid by this DB</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($case->debtors as $debtor)
                                                    <tr>
                                                        <td>{{ $debtor->name }}</td>
                                                        <td>{{ $debtor->phone }}</td>
                                                        <td>{{ $debtor->email }}</td>
                                                        <td>{{ $debtor->address }}</td>
                                                        <td>{{ $debtor->installments->sum('amount_paid') ?? 0 }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            {{-- GENERAL UPDATES TAB --}}
                            <div class="tab-pane fade show active"
                                 id="general-updates"
                                 role="tabpanel"
                                 aria-labelledby="general-tab">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div id="success" class="text-success"></div>
                                        <div class="card">
                                            <div class="card-header text-center">General Update</div>
                                            <div class="card-body">
                                                <form enctype="multipart/form-data" action="{{ route('general.case.create') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">

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
                                                    {{--                        <div class="mb-3">--}}
                                                    {{--                            <label class="form-label">Gn Case Update</label>--}}
                                                    {{--                            <input type="file" name="gn_updates[]" multiple class="form-control">--}}
                                                    {{--                            @error('gn_updates')--}}
                                                    {{--                                <p class="error">{{ $message }}</p>--}}
                                                    {{--                            @enderror--}}
                                                    {{--                        </div>--}}
                                                    {{--                        <div class="mb-3">--}}
                                                    {{--                            <label class="form-label">Amount Paid</label>--}}
                                                    {{--                            <input type="number" step="0.01" min="0" max="10000000000000" name="amount_paid" value="{{ old('amount_paid') }}"--}}
                                                    {{--                                placeholder="Enter Paid Amount Here" class="form-control">--}}
                                                    {{--                            @error('amount_paid')--}}
                                                    {{--                                <p class="error">{{ $message }}</p>--}}
                                                    {{--                            @enderror--}}
                                                    {{--                        </div>--}}
                                                    <input type="hidden" name="update_type" value="general_update">
                                                    {{-- @if ($case->legal_cost - $case->legal_cost_received != 0)
                                                        <div class="mb-3">
                                                            <label class="form-label">Legal Cost</label>
                                                            <input type="number" name="legal_cost" value="{{ $case->legal_cost }}"
                                                                class="form-control">
                                                            @error('legal_cost')
                                                                <p class="error">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    @endif --}}
                                                    {{--                        <div class="mb-3">--}}
                                                    {{--                            <label class="form-label">Payment Method</label>--}}
                                                    {{--                            <select class="form-select" aria-label="Default select example" name="payment_method">--}}
                                                    {{--                                <option value="" {{ old('payment_method') ? '' : 'selected' }}>Select One Payment Method</option>--}}
                                                    {{--                                <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>--}}
                                                    {{--                                <option value="Check" {{ old('payment_method') == 'Check' ? 'selected' : '' }}>Check</option>--}}
                                                    {{--                                <option value="Online" {{ old('payment_method') == 'Online' ? 'selected' : '' }}>Online</option>--}}
                                                    {{--                            </select>--}}
                                                    {{--                            @error('payment_method')--}}
                                                    {{--                                <div style="color: red;">{{ $message }}</div>--}}
                                                    {{--                            @enderror--}}
                                                    {{--                        </div>--}}
                                                    <div class="mb-3" hidden="hidden">
                                                        <label class="form-label">Whom To Assign</label>
                                                        <select class="form-select" aria-label="Default select example" name="assign_type">
                                                            <option value="" {{ old('assign_type') == '' ? 'selected' : '' }}>Select One</option>
                                                            <option value="Admin" {{ old('assign_type') == 'Admin' ? 'selected' : '' }} selected>Admin</option>
                                                            <option value="Accounts" {{ old('assign_type') == 'Accounts' ? 'selected' : '' }}>Accounts</option>
                                                            <option value="Noone" {{ old('assign_type') == 'Noone' ? 'selected' : '' }}>Don't assign to anyone</option>
                                                        </select>

                                                        @error('assign_type')
                                                        <p class="error">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3" hidden="hidden">
                                                        <label class="form-label">Collected By</label>
                                                        <input class="form-control" name="collected_by_id" value="{{auth()->user()->id}}">
                                                        {{--                            <select class="form-select select2" id="collected_by_2" name="collected_by_id" aria-label="Default select example">--}}
                                                        {{--                                <option value="" {{ old('collected_by_id') == '' ? 'selected' : '' }} disabled>Select Employee</option>--}}
                                                        {{--                                @foreach ($employees as $employee)--}}
                                                        {{--                                    <option value="{{ $employee->id }}" {{ old('collected_by_id') == $employee->id ? 'selected' : '' }}>--}}
                                                        {{--                                        {{ $employee->name }}--}}
                                                        {{--                                    </option>--}}
                                                        {{--                                @endforeach--}}
                                                        {{--                            </select>--}}
                                                        @error('collected_by_id')
                                                        <p class="error">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    {{--                        <div class="mb-3">--}}
                                                    {{--                            <label class="form-label">Date of payment</label>--}}
                                                    {{--                            <input type="date" value="{{ old("payment_date") }}" name="payment_date" class="form-control">--}}
                                                    {{--                            @error('payment_date')--}}
                                                    {{--                                <p class="error">{{ $message }}</p>--}}
                                                    {{--                            @enderror--}}
                                                    {{--                        </div>--}}
                                                    {{--                        <div class="mb-3">--}}
                                                    {{--                            <label class="form-label">Next Payment Amount</label>--}}
                                                    {{--                            <input type="number" step="0.01" min="0" max="10000000000000"--}}
                                                    {{--                                name="next_payment_amount" value="{{ old('next_payment_amount') }}" class="form-control" placeholder="Enter Next Payment Amount"--}}
                                                    {{--                                id="next_payment_amount">--}}
                                                    {{--                            @error('next_payment_amount')--}}
                                                    {{--                                <p class="error">{{ $message }}</p>--}}
                                                    {{--                            @enderror--}}
                                                    {{--                        </div>--}}
                                                    {{--                        <div class="mb-3">--}}
                                                    {{--                            <label class="form-label">Next Payment Date</label>--}}
                                                    {{--                            <input type="date" value="{{ old("next_payment_date") }}" name="next_payment_date" class="form-control"--}}
                                                    {{--                                placeholder="Enter Next Payment Date">--}}
                                                    {{--                            @error('next_payment_date')--}}
                                                    {{--                                <p class="error">{{ $message }}</p>--}}
                                                    {{--                            @enderror--}}
                                                    {{--                        </div>--}}
                                                    <div class="mb-3">
                                                        <label class="form-label">Update Date</label>
                                                        <input type="date" value="{{ old("fv_date") }}" name="fv_date" class="form-control">
                                                        @error('fv_date')
                                                        <p class="error">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Gn Summary</label>
                                                        <textarea name="gn_summary" class="form-control" id="" rows="2">{{ old("gn_summary") }}</textarea>
                                                        @error('gn_summary')
                                                        <p class="error">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    {{--                        <div class="mb-3">--}}
                                                    {{--                            <label class="form-label">Remarks</label>--}}
                                                    {{--                            <input type="text" name="remarks" value="{{ old('remarks') }}" class="form-control" placeholder="Enter Remarks Here">--}}
                                                    {{--                            @error('remarks')--}}
                                                    {{--                                <p class="error">{{ $message }}</p>--}}
                                                    {{--                            @enderror--}}
                                                    {{--                        </div>--}}
                                                    <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">

                                                    <div class="row">
                                                        <div class="mb-3 text-end">
                                                            <a href="{{ route('admin.cases.show', $case->id) }}" class="btn btn-light">Cancel</a>
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
                                            </div>
                                        </div>
                                    </div>
                                    {{--        <div class="col-md-8">--}}
                                    {{--            <div class="card">--}}
                                    {{--                <div class="card-body">--}}
                                    {{--                    <h5>General updates</h5>--}}
                                    {{--                    <div id="content">--}}
                                    {{--                        <ul class="timeline">--}}
                                    {{--                            @foreach ($gn_updates as $gn_update)--}}
                                    {{--                                <li class="event"--}}
                                    {{--                                    data-date="{{ date('m-d-Y', strtotime($gn_update->created_at)) }}, {{ date('h:i a', strtotime($gn_update->created_at)) }} ">--}}
                                    {{--                                    <div>--}}
                                    {{--                                        @php--}}
                                    {{--                                            $extension = substr($gn_update->gn_update, -3);--}}
                                    {{--                                        @endphp--}}
                                    {{--                                        @if ($gn_update->gn_update != null)--}}
                                    {{--                                            @if ($extension == 'pdf')--}}
                                    {{--                                                <iframe style="overflow: hidden"--}}
                                    {{--                                                    src="{{ asset('/documents/' . $gn_update->gn_update) }}"--}}
                                    {{--                                                    width="100" height="100"></iframe>--}}
                                    {{--                                            @else--}}
                                    {{--                                                <img src="{{ asset('/documents/' . $gn_update->gn_update) }}"--}}
                                    {{--                                                    width="100" height="100" />--}}
                                    {{--                                            @endif--}}
                                    {{--                                        @else--}}
                                    {{--                                            <div class="d-flex align-items-center justify-content-center"--}}
                                    {{--                                                style="background: rgb(168, 168, 168); height: 100px; width: 100px; color: #ffffff; border-radius: 4px">--}}
                                    {{--                                                <small>No file to show</small>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        @endif--}}

                                    {{--                                    </div>--}}
                                    {{--                                    <h6 class="mt-2">Field Visited at:--}}
                                    {{--                                        {{ $gn_update->fv_date == null ? 'N/A' : date('m-d-Y', strtotime($gn_update->fv_date)) }}--}}
                                    {{--                                    </h6>--}}
                                    {{--                                    <span class="d-block">{{ $gn_update->gn_summary }}</span>--}}
                                    {{--                                    <div class="d-flex">--}}
                                    {{--                                        <a href="#" class="btn  btn-primary mt-2 viewFVUpdate" data-toggle="modal"--}}
                                    {{--                                            data-target="#exampleModal">--}}
                                    {{--                                            <span class="gn_id d-none">{{ $gn_update->id }}</span>--}}
                                    {{--                                            <i class="far fa-eye"></i> View--}}
                                    {{--                                        </a>--}}

                                    {{--                                        @if(Auth::user()->user_type == \App\Models\User::USER_TYPE_EMPLOYEE && $task->status == 'not_complete')--}}
                                    {{--                                            <a class="btn btn-warning mt-2" style="margin-left: 5px;" href="{{ route('admin.tasks.edit', $task->id) }}">Edit</a>--}}
                                    {{--                                            <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST">--}}
                                    {{--                                                @csrf--}}
                                    {{--                                                @method('DELETE')--}}
                                    {{--                                                <button class="btn btn-danger mt-2 ml-2" style="margin-left: 5px;" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>--}}
                                    {{--                                            </form>--}}
                                    {{--                                        @endif--}}
                                    {{--                                    </div>--}}
                                    {{--                                </li>--}}
                                    {{--                            @endforeach--}}
                                    {{--                        </ul>--}}
                                    {{--                    </div>--}}
                                    {{--                </div>--}}
                                    {{--            </div>--}}
                                    {{--        </div>--}}

                                    <div class="col-md-8">
                                        <div class="card">
                                            <div class="card-body">

                                                <h5 class="text-center table-outer-border p-2 bg-soft-lime text-lime">
                                                    General Updates
                                                </h5>

                                                <div id="timeline">

                                                    @php
                                                        $groupedUpdates = $gn_updates->groupBy(function ($item) {
                                                            return \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:i');
                                                        });
                                                    @endphp

                                                    @foreach ($groupedUpdates as $time => $updates)
                                                        <div class="timeline-group general-group">

                                                            {{-- HEADER (TIME + GROUP ACTIONS) --}}
                                                            <div class="d-flex justify-content-between align-items-center mb-2">

                                                                <div class="timeline-time text-primary">
                                                                    {{ \Carbon\Carbon::parse($time)->format('m-d-Y, h:i a') }}
                                                                </div>

                                                                {{-- GROUP ACTIONS (EDIT / DELETE FULL GENERAL UPDATE) --}}
                                                                @if(Auth::user()->user_type == \App\Models\User::USER_TYPE_ADMIN && $task->status == 'not_complete')
                                                                    <div class="payment-actions">
                                                                        <a href="{{ route('admin.tasks.edit', $task->id) }}"
                                                                           class="action-icon edit"
                                                                           title="Edit this general update">
                                                                            <i class="fas fa-pen"></i>
                                                                        </a>

                                                                        <form action="{{ route('admin.tasks.destroy', $task->id) }}"
                                                                              method="POST"
                                                                              class="d-inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                    class="action-icon delete"
                                                                                    title="Delete this general update"
                                                                                    onclick="return confirm('Are you sure you want to delete this general update?')">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            {{-- FILE GRID --}}
                                                            <div class="timeline-grid">
                                                                @foreach ($updates as $gn_update)
                                                                    @php
                                                                        $file = $gn_update->gn_update;
                                                                        $ext = $file ? strtolower(pathinfo($file, PATHINFO_EXTENSION)) : null;
                                                                    @endphp

                                                                    <div class="timeline-item gn-thumb"
                                                                         data-id="{{ $gn_update->id }}">

                                                                        @if ($file)
                                                                            @if ($ext === 'pdf')
                                                                                <div class="file-thumb pdf-thumb">
                                                                                    <i class="far fa-file-pdf"></i>
                                                                                    <span>PDF</span>
                                                                                </div>
                                                                            @else
                                                                                <img src="{{ asset('/documents/' . $file) }}" />
                                                                            @endif
                                                                        @else
                                                                            <div class="file-thumb empty-thumb">
                                                                                <small>No file</small>
                                                                            </div>
                                                                        @endif

                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            {{-- DETAILS --}}
                                                            <div class="mt-3">
                                                                <h6 class="text-primary">
                                                                    Summary:
                                                                    <span class="text-muted">
                                    {{ $updates->first()->gn_summary }}
                                </span>
                                                                </h6>
                                                            </div>

                                                            <hr>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal for General Update -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                         aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">General Update</h5>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <!-- Image preview -->
                                                    <img id="gn_image_preview" src="" alt="GN Update"
                                                         style="max-width:100%; max-height:400px; height:auto; margin:auto; display:block;">

                                                    <!-- PDF preview -->
                                                    <iframe id="gn_pdf_preview" src="" width="100%" height="400" style="display:none;"></iframe>

                                                    <!-- Unsupported file -->
                                                    <div id="gn_file_preview" style="display:none;">
                                                        <p>Preview not available. <a id="gn_file_link" href="" target="_blank">Download file</a></p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" id="closeGnModalBtn" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- PAYMENT UPDATES TAB --}}
                            <div class="tab-pane fade"
                                 id="payment-updates"
                                 role="tabpanel"
                                 aria-labelledby="payment-tab">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-header text-center">Payment Updates</div>
                                            <div class="card-body">
                                                <form enctype="multipart/form-data" action="{{ route('field.visit.create') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">

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

                                                    {{--                        <div class="mb-3">--}}
                                                    {{--                            <label class="form-label">FV Update</label>--}}
                                                    {{--                            <input type="file" name="fv_updates[]" class="form-control" multiple>--}}
                                                    {{--                            @error('fv_updates')--}}
                                                    {{--                                <p class="error">{{ $message }}</p>--}}
                                                    {{--                            @enderror--}}
                                                    {{--                        </div>--}}
                                                    <div class="mb-3">
                                                        <label class="form-label">Amount Paid</label>
                                                        <input type="number" step="0.01" min="0" max="10000000000000" name="amount_paid"
                                                               value="{{ old('amount_paid') }}" placeholder="Enter Paid Amount Here" class="form-control">
                                                        @error('amount_paid')
                                                        <p class="error">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    {{-- @if ($case->legal_cost != 0)
                                                        <div class="mb-3">
                                                            <label class="form-label">Legal Cost</label>
                                                            <input type="number" name="legal_cost" value="{{ $case->legal_cost }}"
                                                                class="form-control">
                                                            @error('legal_cost')
                                                                <p class="error">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    @endif --}}
                                                    <div class="mb-3">
                                                        <label class="form-label">Payment Method</label>
                                                        <select class="form-select" aria-label="Default select example" name="payment_method">
                                                            <option value="" {{ old('payment_method') ? '' : 'selected' }}>Select One Payment Method</option>
                                                            <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                                            <option value="Check" {{ old('payment_method') == 'Check' ? 'selected' : '' }}>Check</option>
                                                            <option value="Online" {{ old('payment_method') == 'Online' ? 'selected' : '' }}>Online</option>
                                                        </select>
                                                        @error('payment_method')
                                                        <p class="error">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3" hidden="hidden">
                                                        <label class="form-label">Whom To Assign</label>
                                                        <select class="form-select" aria-label="Default select example" name="assign_type">
                                                            <option value="" {{ old('assign_type') == '' ? 'selected' : '' }}>Select One</option>
                                                            <option value="Admin" {{ old('assign_type') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                                            <option value="Accounts" {{ old('assign_type') == 'Accounts' ? 'selected' : '' }} selected>Accounts</option>
                                                            <option value="Noone" {{ old('assign_type') == 'Noone' ? 'selected' : '' }}>Don't assign to anyone</option>
                                                        </select>
                                                        @error('assign_type')
                                                        <p class="error">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3" hidden="hidden">
                                                        <label class="form-label">Collected By</label>
                                                        <input class="form-control" name="collected_by_id" value="{{auth()->user()->id}}">
                                                        {{--                            <select class="form-select select2" id="collected_by_2" name="collected_by_id" aria-label="Default select example">--}}
                                                        {{--                                <option value="" {{ old('collected_by_id') == '' ? 'selected' : '' }} disabled>Select Employee</option>--}}
                                                        {{--                                @foreach ($employees as $employee)--}}
                                                        {{--                                    <option value="{{ $employee->id }}" {{ old('collected_by_id') == $employee->id ? 'selected' : '' }}>--}}
                                                        {{--                                        {{ $employee->name }}--}}
                                                        {{--                                    </option>--}}
                                                        {{--                                @endforeach--}}
                                                        {{--                            </select>--}}
                                                        @error('collected_by_id')
                                                        <p class="error">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Date of Payment</label>
                                                        <input type="date" value="{{ old("payment_date") }}" name="payment_date" class="form-control">
                                                        @error('payment_date')
                                                        <p class="error">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Next Payment Amount</label>
                                                        <input type="number" step="0.01" min="0" max="10000000000000"
                                                               name="next_payment_amount" value="{{ old('next_payment_amount') }}" class="form-control" placeholder="Enter Next Payment Amount"
                                                               id="next_payment_amount">
                                                        @error('next_payment_amount')
                                                        <p class="error">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Next Payment Date</label>
                                                        <input type="date" value="{{ old("next_payment_date") }}" name="next_payment_date" class="form-control"
                                                               placeholder="Enter Interest Start Date">
                                                        @error('next_payment_date')
                                                        <p class="error">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label d-block">Under instalment</label>
                                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                            <label class="btn btn-secondary active">
                                                                <input type="radio" name="underInstallment" id="yes" autocomplete="off" checked> Yes
                                                            </label>
                                                            <label class="btn btn-secondary">
                                                                <input type="radio" name="underInstallment" id="no" autocomplete="off"> No
                                                            </label>
                                                        </div>
                                                    </div>
                                                    {{--                        <div class="mb-3">--}}
                                                    {{--                            <label class="form-label">Field Visit Date</label>--}}
                                                    {{--                            <input type="date" value="{{ old("fv_date") }}" name="fv_date" class="form-control">--}}
                                                    {{--                            @error('fv_date')--}}
                                                    {{--                                <p class="error">{{ $message }}</p>--}}
                                                    {{--                            @enderror--}}
                                                    {{--                        </div>--}}
                                                    <input type="hidden" name="update_type" value="field_visit_update">
                                                    <div class="mb-3" hidden="hidden">
                                                        <label class="form-label">FV Summary</label>
                                                        <textarea name="fv_summary" class="form-control" id="" rows="2">{{ old("fv_summary") }}</textarea>
                                                        @error('fv_summary')
                                                        <p class="error">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Remarks</label>
                                                        <input type="text" name="remarks" value="{{ old("remarks") }}" class="form-control" placeholder="Enter Remarks Here">
                                                        @error('remarks')
                                                        <p class="error">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">

                                                    <div class="row">
                                                        <div class="mb-3">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="div">
                                                                    <a href="{{ route('admin.cases.show', $case->id) }}"
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
                                            </div>
                                        </div>
                                    </div>
                                    {{--        <div class="col-md-8">--}}
                                    {{--            <div class="card">--}}
                                    {{--                <div class="card-body">--}}
                                    {{--                    <h5>Field Visit Updates</h5>--}}
                                    {{--                    <div id="content">--}}
                                    {{--                        <ul class="timeline">--}}
                                    {{--                            @foreach ($fv_updates as $fv_update)--}}
                                    {{--                                <li class="event"--}}
                                    {{--                                    data-date="{{ date('m-d-Y', strtotime($fv_update->created_at)) }}, {{ date('h:i a', strtotime($fv_update->created_at)) }} ">--}}


                                    {{--                                    @php--}}
                                    {{--                                        $extension = substr($fv_update->fv_update, -3);--}}
                                    {{--                                    @endphp--}}
                                    {{--                                    @if ($fv_update->fv_update != null)--}}
                                    {{--                                        @if ($extension == 'pdf')--}}
                                    {{--                                            <iframe style="overflow: hidden"--}}
                                    {{--                                                src="{{ asset('/documents/' . $fv_update->fv_update) }}" width="100"--}}
                                    {{--                                                height="100"></iframe>--}}
                                    {{--                                        @else--}}
                                    {{--                                            <img src="{{ asset('/documents/' . $fv_update->fv_update) }}" width="100"--}}
                                    {{--                                                height="100" />--}}
                                    {{--                                        @endif--}}
                                    {{--                                    @else--}}
                                    {{--                                        <div class="d-flex align-items-center justify-content-center"--}}
                                    {{--                                            style="background: rgb(168, 168, 168); height: 100px; width: 100px; color: #ffffff; border-radius: 4px">--}}
                                    {{--                                            <small>No file to show</small>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    @endif--}}
                                    {{--                                    <h6 class="mt-2">Date of payment:--}}
                                    {{--                                        {{ $fv_update->fv_date == null ? 'N/A' : date('m-d-Y', strtotime($fv_update->fv_date)) }}--}}
                                    {{--                                    </h6>--}}
                                    {{--                                    <span class="d-block">{{ $fv_update->fv_summary }}</span>--}}
                                    {{--                                    <div class="d-flex">--}}
                                    {{--                                        <a href="#" class="btn  btn-primary mt-2 viewFVUpdate2" data-toggle="modal"--}}
                                    {{--                                            data-target="#exampleModal2">--}}
                                    {{--                                            <span class="fv_id d-none">{{ $fv_update->id }}</span>--}}
                                    {{--                                            <i class="far fa-eye"></i> View--}}
                                    {{--                                        </a>--}}

                                    {{--                                        @if(Auth::user()->user_type == \App\Models\User::USER_TYPE_EMPLOYEE && $task->status == 'not_complete')--}}
                                    {{--                                            <a class="btn btn-warning mt-2" style="margin-left: 5px;" href="{{ route('admin.tasks.edit', $task->id) }}">Edit</a>--}}
                                    {{--                                            <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST">--}}
                                    {{--                                                @csrf--}}
                                    {{--                                                @method('DELETE')--}}
                                    {{--                                                <button class="btn btn-danger mt-2 ml-2" style="margin-left: 5px;" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>--}}
                                    {{--                                            </form>--}}
                                    {{--                                        @endif--}}
                                    {{--                                    </div>--}}
                                    {{--                                </li>--}}
                                    {{--                            @endforeach--}}
                                    {{--                        </ul>--}}
                                    {{--                    </div>--}}
                                    {{--                </div>--}}
                                    {{--            </div>--}}
                                    {{--        </div>--}}
                                    <div class="col-md-8">
                                        <div class="card">
                                            <div class="card-body">

                                                <h5 class="text-center table-outer-border p-2 bg-soft-lime text-lime">
                                                    Payment Updates
                                                </h5>

                                                <div id="fv-timeline">

                                                    @php
                                                        $groupedFvUpdates = $fv_updates->groupBy(function ($item) {
                                                            return \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:i');
                                                        });
                                                    @endphp

                                                    @foreach ($groupedFvUpdates as $time => $updates)
                                                        <div class="timeline-group payment-group">

                                                            {{-- HEADER (TIME + ACTIONS) --}}
                                                            <div class="d-flex justify-content-between align-items-center mb-2">

                                                                <div class="timeline-time text-primary">
                                                                    {{ \Carbon\Carbon::parse($time)->format('m-d-Y, h:i a') }}
                                                                </div>

                                                                {{-- GROUP ACTIONS (EDIT / DELETE FULL PAYMENT UPDATE) --}}
                                                                @if(Auth::user()->user_type == \App\Models\User::USER_TYPE_ADMIN && $task->status == 'not_complete')
                                                                    <div class="payment-actions">
                                                                        <a href="{{ route('admin.tasks.edit', $task->id) }}"
                                                                           class="action-icon edit btn btn-sm btn-outline-primary"
                                                                           title="Edit this payment update">
                                                                            <i class="fas fa-pen"></i>
                                                                        </a>

                                                                        <form action="{{ route('admin.tasks.destroy', $task->id) }}"
                                                                              method="POST"
                                                                              class="d-inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                    class="action-icon delete"
                                                                                    title="Delete this payment update"
                                                                                    onclick="return confirm('Are you sure you want to delete this payment update?')">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            {{-- FILE GRID --}}
                                                            <div class="timeline-grid">
                                                                @foreach ($updates as $fv_update)
                                                                    @php
                                                                        $file = $fv_update->fv_update;
                                                                        $ext = $file ? strtolower(pathinfo($file, PATHINFO_EXTENSION)) : null;
                                                                    @endphp

                                                                    <div class="timeline-item fv-thumb"
                                                                         data-id="{{ $fv_update->id }}">

                                                                        @if ($file)
                                                                            @if ($ext === 'pdf')
                                                                                <div class="file-thumb pdf-thumb">
                                                                                    <i class="far fa-file-pdf"></i>
                                                                                    <span>PDF</span>
                                                                                </div>
                                                                            @else
                                                                                <img src="{{ asset('/documents/' . $file) }}" />
                                                                            @endif
                                                                        @else
                                                                            <div class="file-thumb empty-thumb">
                                                                                <small>No file</small>
                                                                            </div>
                                                                        @endif

                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            {{-- DETAILS --}}
                                                            <div class="mt-3">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <h6 class="text-primary">
                                                                            Amount Paid:
                                                                            <span class="text-muted">
                                                                        {{ $updates->first()->installment->amount_paid}}
                                                                    </span>
                                                                        </h6>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <h6 class="text-primary">
                                                                            Payment Method:
                                                                            <span class="text-muted">
                                                                        {{ $updates->first()->installment->payment_method}}
                                                                    </span>
                                                                        </h6>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <h6 class="text-primary">
                                                                            Collected by:
                                                                            <span class="text-muted">
                                                                        {{user_fullname($updates->first()->installment->user)}}
                                                                    </span>
                                                                        </h6>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <h6 class="text-primary">
                                                                            Date of payment:
                                                                            <span class="text-muted">
                                                                        {{ $updates->first()->installment->date_of_payment ? date('m-d-Y', strtotime($updates->first()->installment->date_of_payment)) : 'N/A' }}
                                                                    </span>
                                                                        </h6>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <h6 class="text-primary">
                                                                            Next payment Date:
                                                                            <span class="text-muted">
                                                                                {{ $updates->first()->installment->next_payment_date ? date('m-d-Y', strtotime($updates->first()->installment->next_payment_date)) : 'N/A' }}
                                                                            </span>
                                                                            @php
                                                                                $dateStatus = $updates->first()->installment->nextPaymentDateStatus();
                                                                            @endphp
                                                                            <span class="badge bg-{{ $dateStatus['class'] }} status-badge"
                                                                                  data-bs-toggle="tooltip"
                                                                                  data-bs-placement="top"
                                                                                  title="{{ $dateStatus['tooltip'] }}">
                                                                                {{ $dateStatus['label'] }}
                                                                            </span>
                                                                        </h6>
                                                                        <small class="text-muted d-block mt-1">
                                                                            Timing status is based on the next recorded payment date.
                                                                        </small>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <h6 class="text-primary">
                                                                            Next Payment Amount:
                                                                            <span class="text-muted">
                                                                                {{ $updates->first()->installment->next_payment_amount ?? 'N/A' }}
                                                                            </span>
                                                                            @php
                                                                                $status = $updates->first()->installment->paymentStatus();
                                                                            @endphp
                                                                            <span class="badge bg-{{ $status['class'] }} status-badge"
                                                                                  data-bs-toggle="tooltip"
                                                                                  data-bs-placement="top"
                                                                                  title="{{ $status['tooltip'] }}">
                                                                                {{ $status['label'] }}
                                                                            </span>
                                                                        </h6>
                                                                        <small class="text-muted d-block mt-1">
                                                                            Status is Based on the next recorded payment.
                                                                        </small>


                                                                        {{--                                                                        <h6 class="text-primary mt-1">--}}
                                                                        {{--                                                                            Payment Status:--}}
                                                                        {{--                                                                            <span class="badge bg-{{ $status['class'] }}">--}}
                                                                        {{--                                                                                {{ $status['label'] }}--}}
                                                                        {{--                                                                            </span>--}}
                                                                        {{--                                                                        </h6>--}}
                                                                        {{-- DEBUG BOX --}}
                                                                        {{--                                                                        @if(isset($status['debug']))--}}
                                                                        {{--                                                                            <div class="mt-2 p-2 bg-light border small">--}}
                                                                        {{--                                                                                <strong>DEBUG</strong><br>--}}
                                                                        {{--                                                                                Current ID: {{ $status['debug']['current_id'] }}<br>--}}
                                                                        {{--                                                                                Current Time: {{ $status['debug']['current_time'] }}<br>--}}
                                                                        {{--                                                                                Expected: {{ $status['debug']['expected'] }}<br>--}}
                                                                        {{--                                                                                Next ID: {{ $status['debug']['next_id'] ?? 'NULL' }}<br>--}}
                                                                        {{--                                                                                Next Time: {{ $status['debug']['next_time'] ?? 'NULL' }}<br>--}}
                                                                        {{--                                                                                Next Paid: {{ $status['debug']['next_paid'] ?? 'NULL' }}--}}
                                                                        {{--                                                                            </div>--}}
                                                                        {{--                                                                        @endif--}}
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <h6 class="text-primary">
                                                                            Remarks:
                                                                            <span class="text-muted">
                                                                        {{ $updates->first()->remarks }}
                                                                    </span>
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <hr>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal for FV Update -->
                                    {{--        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"--}}
                                    {{--            aria-hidden="true">--}}
                                    {{--            <div class="modal-dialog" role="document">--}}
                                    {{--                <div class="modal-content">--}}
                                    {{--                    <div class="modal-header">--}}
                                    {{--                        <h5 class="modal-title" id="exampleModalLabel">Feild Visit Update</h5>--}}
                                    {{--                    </div>--}}
                                    {{--                    <div class="modal-body">--}}
                                    {{--                        <iframe id="fv_update" src="" class="mt-2" width="100%" height="400">--}}
                                    {{--                        </iframe>--}}
                                    {{--                    </div>--}}
                                    {{--                    <div class="modal-footer">--}}
                                    {{--                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
                                    {{--                    </div>--}}
                                    {{--                </div>--}}
                                    {{--            </div>--}}
                                    {{--        </div>--}}

                                    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                         aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Payment Update</h5>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <!-- Image preview -->
                                                    <img id="fv_image_preview" src="" alt="FV Update"
                                                         style="max-width:100%; max-height:400px; height:auto; display:none; margin:auto; display:block;">

                                                    <!-- PDF preview -->
                                                    <iframe id="fv_pdf_preview" src="" width="100%" height="400" style="display:none;"></iframe>

                                                    <!-- Unsupported file -->
                                                    <div id="fv_file_preview" style="display:none;">
                                                        <p>Preview not available. <a id="fv_file_link" href="" target="_blank">Download file</a></p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="closeFvModalBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    {{-- tabs end--}}
                    <div class="col-md-12" hidden="hidden">
                        <div class="card bg-warning text-white" >
                            <div class="card-body">
                                <div class="row">
                                    <h5 class="card-title">All Payment Details:</h5>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table mb-0 text-white table-outer-border">
                                                <thead>
                                                <tr>
                                                    <th>Amount Paid</th>
                                                    <th>Date Paid</th>
                                                    <th>Collected by</th>
                                                    <th>Payment Method</th>
                                                    <th>Uploaded receipt</th>
                                                    <th>Next payment Date</th>
                                                    <th>Next payment amount</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($case->fieldVisitInstallments as $installment)
                                                    <tr>
                                                        <td>{{$installment->amount_paid}}</td>
                                                        <td>{{$installment->date_of_payment}}</td>
                                                        <td>{{user_fullname($installment->user)}}</td>
                                                        <td>{{$installment->payment_method}}</td>
                                                        <td>
                                                            {{--                                                            <div class="">--}}
                                                            {{--                                                                @foreach ($installment->fvUpdates as $fv_update)--}}
                                                            {{--                                                                    <li class="event"--}}
                                                            {{--                                                                        data-date="{{ date('m-d-Y', strtotime($fv_update->created_at)) }}, {{ date('h:i a', strtotime($fv_update->created_at)) }} ">--}}


                                                            {{--                                                                        @php--}}
                                                            {{--                                                                            $extension = substr($fv_update->fv_update, -3);--}}
                                                            {{--                                                                        @endphp--}}
                                                            {{--                                                                        @if ($fv_update->fv_update != null)--}}
                                                            {{--                                                                            @if ($extension == 'pdf')--}}
                                                            {{--                                                                                <iframe style="overflow: hidden"--}}
                                                            {{--                                                                                        src="{{ asset('/documents/' . $fv_update->fv_update) }}" width="50"--}}
                                                            {{--                                                                                        height="50"></iframe>--}}
                                                            {{--                                                                            @else--}}
                                                            {{--                                                                                <img src="{{ asset('/documents/' . $fv_update->fv_update) }}" width="50"--}}
                                                            {{--                                                                                     height="50" />--}}
                                                            {{--                                                                            @endif--}}
                                                            {{--                                                                        @else--}}
                                                            {{--                                                                            <div class="d-flex align-items-center justify-content-center"--}}
                                                            {{--                                                                                 style="background: rgb(168, 168, 168); height: 100px; width: 100px; color: #ffffff; border-radius: 4px">--}}
                                                            {{--                                                                                <small>No file to show</small>--}}
                                                            {{--                                                                            </div>--}}
                                                            {{--                                                                        @endif--}}
                                                            {{--                                                                        <span class="d-block">{{ $fv_update->fv_summary }}</span>--}}
                                                            {{--                                                                        <div class="d-flex">--}}
                                                            {{--                                                                            <a href="#" class="btn  btn-primary mt-2 viewFVUpdate2" data-toggle="modal"--}}
                                                            {{--                                                                               data-target="#exampleModal2">--}}
                                                            {{--                                                                                <span class="fv_id d-none">{{ $fv_update->id }}</span>--}}
                                                            {{--                                                                                <i class="far fa-eye"></i> View--}}
                                                            {{--                                                                            </a>--}}
                                                            {{--                                                                        </div>--}}
                                                            {{--                                                                    </li>--}}
                                                            {{--                                                                @endforeach--}}
                                                            {{--                                                            </div>--}}

                                                            <div class="">
                                                                <ul class="list-unstyled">
                                                                    @foreach ($installment->fvUpdates as $fv_update)
                                                                        <li class="event"
                                                                            data-date="{{ date('m-d-Y', strtotime($fv_update->created_at)) }}, {{ date('h:i a', strtotime($fv_update->created_at)) }}">
                                                                            @php
                                                                                $file = $fv_update->fv_update;
                                                                                $extension = $file ? strtolower(pathinfo($file, PATHINFO_EXTENSION)) : null;
                                                                                $fileUrl = $file ? asset('documents/'.$file) : null;
                                                                            @endphp

                                                                            @if ($file)
                                                                                <a href="#" class="fv-thumb d-inline-block me-2" data-id="{{ $fv_update->id }}" data-file="{{ $file }}">
                                                                                    @if(in_array($extension, ['pdf']))
                                                                                        {{-- small pdf icon preview --}}
                                                                                        <div class="thumb-pdf d-flex align-items-center justify-content-center">
                                                                                            <small class="fw-bold">PDF</small>
                                                                                        </div>
                                                                                    @else
                                                                                        <img src="{{ $fileUrl }}" alt="file thumbnail" class="img-thumbnail thumb-img" />
                                                                                    @endif
                                                                                </a>
                                                                            @else
                                                                                <div class="d-inline-flex align-items-center justify-content-center placeholder-thumb me-2">
                                                                                    <small>No file</small>
                                                                                </div>
                                                                            @endif

                                                                            <div class="d-inline-block align-middle">
                                                                                <span class="d-block">{{ $fv_update->fv_summary }}</span>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if (empty($installment->next_payment_date))
                                                                <span>N/A</span>
                                                            @else
                                                                {{ date('m-d-Y', strtotime($installment->next_payment_date)) }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (empty($installment->next_payment_amount))
                                                                <span>N/A</span>
                                                            @else
                                                                $ {{ number_format($installment->next_payment_amount, 2, '.', ',') }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
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
    {{--    <div class="row">--}}
    {{--        <div class="col-md-12">--}}
    {{--            <div class="card">--}}
    {{--                <div class="card-body">--}}
    {{--                    <table class="table">--}}
    {{--                        <thead>--}}
    {{--                            <tr>--}}
    {{--                                <th scope="col">SL</th>--}}
    {{--                                <th scope="col">Employee Name</th>--}}
    {{--                                <th scope="col">Total Amount</th>--}}
    {{--                            </tr>--}}
    {{--                        </thead>--}}
    {{--                        <tbody>--}}
    {{--                            @foreach ($installmentByEmployees as $installmentByEmployee)--}}
    {{--                                <tr>--}}
    {{--                                    <th scope="row">{{ $loop->iteration }}</th>--}}
    {{--                                    <td> {{ $installmentByEmployee->user->name }}</td>--}}
    {{--                                    <td>{{ $installmentByEmployee->total_amounts != null ? '$ ' . number_format($installmentByEmployee->total_amounts, 2, '.', ',') : 'N/A' }}--}}
    {{--                                    </td>--}}
    {{--                                </tr>--}}
    {{--                            @endforeach--}}

    {{--                        </tbody>--}}
    {{--                    </table>--}}
    {{--                    --}}{{-- {{ $installmentByEmployees->links() }} --}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--    <div class="row">--}}
    {{--        <div class="col-md-4">--}}
    {{--            <div id="success" class="text-success"></div>--}}
    {{--            <div class="card">--}}
    {{--                <div class="card-header text-center">General Update</div>--}}
    {{--                <div class="card-body">--}}
    {{--                    <form enctype="multipart/form-data" action="{{ route('general.case.create') }}" method="POST">--}}
    {{--                        @csrf--}}
    {{--                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">--}}

    {{--                        <!-- Take Image Button -->--}}
    {{--                        <label class="form-label">Gn Case Update</label>--}}
    {{--                        <button id="takeImageBtn" class="btn btn-dark mb-3" type="button">Upload Or Select File</button>--}}

    {{--                        <!-- Preview container -->--}}
    {{--                        <div id="previewContainer" class="mb-3 d-flex flex-wrap"></div>--}}

    {{--                        <!-- Hidden file input for fallback -->--}}
    {{--                        <input type="file" name="gn_updates[]" id="hiddenGnUpdates" multiple style="display:none;">--}}
    {{--                        @error('gn_updates')--}}
    {{--                        <p class="error">{{ $message }}</p>--}}
    {{--                        @enderror--}}
    {{--                        <div class="mb-3">--}}
    {{--                            <label class="form-label">Gn Case Update</label>--}}
    {{--                            <input type="file" name="gn_updates[]" multiple class="form-control">--}}
    {{--                            @error('gn_updates')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <div class="mb-3">--}}
    {{--                            <label class="form-label">Amount Paid</label>--}}
    {{--                            <input type="number" step="0.01" min="0" max="10000000000000" name="amount_paid" value="{{ old('amount_paid') }}"--}}
    {{--                                placeholder="Enter Paid Amount Here" class="form-control">--}}
    {{--                            @error('amount_paid')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <input type="hidden" name="update_type" value="general_update">--}}
    {{--                        --}}{{-- @if ($case->legal_cost - $case->legal_cost_received != 0)--}}
    {{--                            <div class="mb-3">--}}
    {{--                                <label class="form-label">Legal Cost</label>--}}
    {{--                                <input type="number" name="legal_cost" value="{{ $case->legal_cost }}"--}}
    {{--                                    class="form-control">--}}
    {{--                                @error('legal_cost')--}}
    {{--                                    <p class="error">{{ $message }}</p>--}}
    {{--                                @enderror--}}
    {{--                            </div>--}}
    {{--                        @endif --}}
    {{--                        <div class="mb-3">--}}
    {{--                            <label class="form-label">Payment Method</label>--}}
    {{--                            <select class="form-select" aria-label="Default select example" name="payment_method">--}}
    {{--                                <option value="" {{ old('payment_method') ? '' : 'selected' }}>Select One Payment Method</option>--}}
    {{--                                <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>--}}
    {{--                                <option value="Check" {{ old('payment_method') == 'Check' ? 'selected' : '' }}>Check</option>--}}
    {{--                                <option value="Online" {{ old('payment_method') == 'Online' ? 'selected' : '' }}>Online</option>--}}
    {{--                            </select>--}}
    {{--                            @error('payment_method')--}}
    {{--                                <div style="color: red;">{{ $message }}</div>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <div class="mb-3" hidden="hidden">--}}
    {{--                            <label class="form-label">Whom To Assign</label>--}}
    {{--                            <select class="form-select" aria-label="Default select example" name="assign_type">--}}
    {{--                                <option value="" {{ old('assign_type') == '' ? 'selected' : '' }}>Select One</option>--}}
    {{--                                <option value="Admin" {{ old('assign_type') == 'Admin' ? 'selected' : '' }} selected>Admin</option>--}}
    {{--                                <option value="Accounts" {{ old('assign_type') == 'Accounts' ? 'selected' : '' }}>Accounts</option>--}}
    {{--                                <option value="Noone" {{ old('assign_type') == 'Noone' ? 'selected' : '' }}>Don't assign to anyone</option>--}}
    {{--                            </select>--}}

    {{--                            @error('assign_type')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <div class="mb-3" hidden="hidden">--}}
    {{--                            <label class="form-label">Collected By</label>--}}
    {{--                            <input class="form-control" name="collected_by_id" value="{{auth()->user()->id}}">--}}
    {{--                            <select class="form-select select2" id="collected_by_2" name="collected_by_id" aria-label="Default select example">--}}
    {{--                                <option value="" {{ old('collected_by_id') == '' ? 'selected' : '' }} disabled>Select Employee</option>--}}
    {{--                                @foreach ($employees as $employee)--}}
    {{--                                    <option value="{{ $employee->id }}" {{ old('collected_by_id') == $employee->id ? 'selected' : '' }}>--}}
    {{--                                        {{ $employee->name }}--}}
    {{--                                    </option>--}}
    {{--                                @endforeach--}}
    {{--                            </select>--}}
    {{--                            @error('collected_by_id')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <div class="mb-3">--}}
    {{--                            <label class="form-label">Date of payment</label>--}}
    {{--                            <input type="date" value="{{ old("payment_date") }}" name="payment_date" class="form-control">--}}
    {{--                            @error('payment_date')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <div class="mb-3">--}}
    {{--                            <label class="form-label">Next Payment Amount</label>--}}
    {{--                            <input type="number" step="0.01" min="0" max="10000000000000"--}}
    {{--                                name="next_payment_amount" value="{{ old('next_payment_amount') }}" class="form-control" placeholder="Enter Next Payment Amount"--}}
    {{--                                id="next_payment_amount">--}}
    {{--                            @error('next_payment_amount')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <div class="mb-3">--}}
    {{--                            <label class="form-label">Next Payment Date</label>--}}
    {{--                            <input type="date" value="{{ old("next_payment_date") }}" name="next_payment_date" class="form-control"--}}
    {{--                                placeholder="Enter Next Payment Date">--}}
    {{--                            @error('next_payment_date')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <div class="mb-3">--}}
    {{--                            <label class="form-label">Update Date</label>--}}
    {{--                            <input type="date" value="{{ old("fv_date") }}" name="fv_date" class="form-control">--}}
    {{--                            @error('fv_date')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <div class="mb-3">--}}
    {{--                            <label class="form-label">Gn Summary</label>--}}
    {{--                            <textarea name="gn_summary" class="form-control" id="" rows="2">{{ old("gn_summary") }}</textarea>--}}
    {{--                            @error('gn_summary')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <div class="mb-3">--}}
    {{--                            <label class="form-label">Remarks</label>--}}
    {{--                            <input type="text" name="remarks" value="{{ old('remarks') }}" class="form-control" placeholder="Enter Remarks Here">--}}
    {{--                            @error('remarks')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">--}}

    {{--                        <div class="row">--}}
    {{--                            <div class="mb-3 text-end">--}}
    {{--                                <a href="{{ route('admin.cases.show', $case->id) }}" class="btn btn-light">Cancel</a>--}}
    {{--                                <button class="btn btn-primary waves-effect waves-lightml-2 " type="submit">--}}
    {{--                                    <i class="fa fa-save"></i> Save--}}
    {{--                                </button>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </form>--}}



    {{--                    <!-- Pop-up modal -->--}}
    {{--                    <div class="modal fade" id="openPopUpModal" tabindex="-1" aria-hidden="true">--}}
    {{--                        <div class="modal-dialog">--}}
    {{--                            <div class="modal-content">--}}
    {{--                                <div class="modal-header">--}}
    {{--                                    <h5 class="modal-title">Open Camera or Upload Image</h5>--}}
    {{--                                    <button id="closePopUpBtn" type="button" class="close" data-bs-dismiss="modal"><span>×</span></button>--}}
    {{--                                </div>--}}
    {{--                                <div class="modal-body">--}}
    {{--                                    <button id="openCameraBtn" class="btn btn-warning" type="button">Open Camera</button>--}}
    {{--                                    <h4 class="text-warning mt-3">OR</h4>--}}
    {{--                                    <div class="btn btn-secondary mt-2">--}}
    {{--                                        <span>Browse</span>--}}
    {{--                                        <input id="fileInput" type="file" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif">--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="modal-footer">--}}
    {{--                                    <button id="cancelPopUpBtn" type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}

    {{--                    <!-- Camera modal -->--}}
    {{--                    <div class="modal fade" id="openCameraModal" tabindex="-1" aria-hidden="true">--}}
    {{--                        <div class="modal-dialog">--}}
    {{--                            <div class="modal-content">--}}
    {{--                                <div class="modal-header">--}}
    {{--                                    <h5 class="modal-title">Take A Snap</h5>--}}
    {{--                                    <button id="closeCameraBtn" type="button" class="close" data-bs-dismiss="modal"><span>×</span></button>--}}
    {{--                                </div>--}}
    {{--                                <div class="modal-body">--}}
    {{--                                    <video id="videoElement" autoplay playsinline style="width:100%; max-height:400px;"></video>--}}
    {{--                                    <canvas id="canvasElement" style="display:none;"></canvas>--}}
    {{--                                </div>--}}
    {{--                                <div class="modal-footer">--}}
    {{--                                    <button id="switchCameraBtn" class="btn btn-warning">Switch Camera</button>--}}
    {{--                                    <button id="captureBtn" class="btn btn-info">Capture</button>--}}
    {{--                                    <button id="cancelCameraBtn" type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}

    {{--                    camera modal end--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--        <div class="col-md-8">--}}
    {{--            <div class="card">--}}
    {{--                <div class="card-body">--}}
    {{--                    <h5>General updates</h5>--}}
    {{--                    <div id="content">--}}
    {{--                        <ul class="timeline">--}}
    {{--                            @foreach ($gn_updates as $gn_update)--}}
    {{--                                <li class="event"--}}
    {{--                                    data-date="{{ date('m-d-Y', strtotime($gn_update->created_at)) }}, {{ date('h:i a', strtotime($gn_update->created_at)) }} ">--}}
    {{--                                    <div>--}}
    {{--                                        @php--}}
    {{--                                            $extension = substr($gn_update->gn_update, -3);--}}
    {{--                                        @endphp--}}
    {{--                                        @if ($gn_update->gn_update != null)--}}
    {{--                                            @if ($extension == 'pdf')--}}
    {{--                                                <iframe style="overflow: hidden"--}}
    {{--                                                    src="{{ asset('/documents/' . $gn_update->gn_update) }}"--}}
    {{--                                                    width="100" height="100"></iframe>--}}
    {{--                                            @else--}}
    {{--                                                <img src="{{ asset('/documents/' . $gn_update->gn_update) }}"--}}
    {{--                                                    width="100" height="100" />--}}
    {{--                                            @endif--}}
    {{--                                        @else--}}
    {{--                                            <div class="d-flex align-items-center justify-content-center"--}}
    {{--                                                style="background: rgb(168, 168, 168); height: 100px; width: 100px; color: #ffffff; border-radius: 4px">--}}
    {{--                                                <small>No file to show</small>--}}
    {{--                                            </div>--}}
    {{--                                        @endif--}}

    {{--                                    </div>--}}
    {{--                                    <h6 class="mt-2">Field Visited at:--}}
    {{--                                        {{ $gn_update->fv_date == null ? 'N/A' : date('m-d-Y', strtotime($gn_update->fv_date)) }}--}}
    {{--                                    </h6>--}}
    {{--                                    <span class="d-block">{{ $gn_update->gn_summary }}</span>--}}
    {{--                                    <div class="d-flex">--}}
    {{--                                        <a href="#" class="btn  btn-primary mt-2 viewFVUpdate" data-toggle="modal"--}}
    {{--                                            data-target="#exampleModal">--}}
    {{--                                            <span class="gn_id d-none">{{ $gn_update->id }}</span>--}}
    {{--                                            <i class="far fa-eye"></i> View--}}
    {{--                                        </a>--}}

    {{--                                        @if(Auth::user()->user_type == \App\Models\User::USER_TYPE_EMPLOYEE && $task->status == 'not_complete')--}}
    {{--                                            <a class="btn btn-warning mt-2" style="margin-left: 5px;" href="{{ route('admin.tasks.edit', $task->id) }}">Edit</a>--}}
    {{--                                            <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST">--}}
    {{--                                                @csrf--}}
    {{--                                                @method('DELETE')--}}
    {{--                                                <button class="btn btn-danger mt-2 ml-2" style="margin-left: 5px;" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>--}}
    {{--                                            </form>--}}
    {{--                                        @endif--}}
    {{--                                    </div>--}}
    {{--                                </li>--}}
    {{--                            @endforeach--}}
    {{--                        </ul>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}

    {{--        <div class="col-md-8">--}}
    {{--            <div class="card">--}}
    {{--                <div class="card-body">--}}

    {{--                    <h5 class="text-center table-outer-border p-2 bg-soft-lime text-lime">--}}
    {{--                        General Updates--}}
    {{--                    </h5>--}}

    {{--                    <div id="timeline">--}}

    {{--                        @php--}}
    {{--                            $groupedUpdates = $gn_updates->groupBy(function ($item) {--}}
    {{--                                return \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:i');--}}
    {{--                            });--}}
    {{--                        @endphp--}}

    {{--                        @foreach ($groupedUpdates as $time => $updates)--}}
    {{--                            <div class="timeline-group general-group">--}}

    {{--                                --}}{{-- HEADER (TIME + GROUP ACTIONS) --}}
    {{--                                <div class="d-flex justify-content-between align-items-center mb-2">--}}

    {{--                                    <div class="timeline-time text-primary">--}}
    {{--                                        {{ \Carbon\Carbon::parse($time)->format('m-d-Y, h:i a') }}--}}
    {{--                                    </div>--}}

    {{--                                    --}}{{-- GROUP ACTIONS (EDIT / DELETE FULL GENERAL UPDATE) --}}
    {{--                                    @if(Auth::user()->user_type == \App\Models\User::USER_TYPE_ADMIN && $task->status == 'not_complete')--}}
    {{--                                        <div class="payment-actions">--}}
    {{--                                            <a href="{{ route('admin.tasks.edit', $task->id) }}"--}}
    {{--                                               class="action-icon edit"--}}
    {{--                                               title="Edit this general update">--}}
    {{--                                                <i class="fas fa-pen"></i>--}}
    {{--                                            </a>--}}

    {{--                                            <form action="{{ route('admin.tasks.destroy', $task->id) }}"--}}
    {{--                                                  method="POST"--}}
    {{--                                                  class="d-inline">--}}
    {{--                                                @csrf--}}
    {{--                                                @method('DELETE')--}}
    {{--                                                <button type="submit"--}}
    {{--                                                        class="action-icon delete"--}}
    {{--                                                        title="Delete this general update"--}}
    {{--                                                        onclick="return confirm('Are you sure you want to delete this general update?')">--}}
    {{--                                                    <i class="fas fa-trash"></i>--}}
    {{--                                                </button>--}}
    {{--                                            </form>--}}
    {{--                                        </div>--}}
    {{--                                    @endif--}}
    {{--                                </div>--}}

    {{--                                --}}{{-- FILE GRID --}}
    {{--                                <div class="timeline-grid">--}}
    {{--                                    @foreach ($updates as $gn_update)--}}
    {{--                                        @php--}}
    {{--                                            $file = $gn_update->gn_update;--}}
    {{--                                            $ext = $file ? strtolower(pathinfo($file, PATHINFO_EXTENSION)) : null;--}}
    {{--                                        @endphp--}}

    {{--                                        <div class="timeline-item gn-thumb"--}}
    {{--                                             data-id="{{ $gn_update->id }}">--}}

    {{--                                            @if ($file)--}}
    {{--                                                @if ($ext === 'pdf')--}}
    {{--                                                    <div class="file-thumb pdf-thumb">--}}
    {{--                                                        <i class="far fa-file-pdf"></i>--}}
    {{--                                                        <span>PDF</span>--}}
    {{--                                                    </div>--}}
    {{--                                                @else--}}
    {{--                                                    <img src="{{ asset('/documents/' . $file) }}" />--}}
    {{--                                                @endif--}}
    {{--                                            @else--}}
    {{--                                                <div class="file-thumb empty-thumb">--}}
    {{--                                                    <small>No file</small>--}}
    {{--                                                </div>--}}
    {{--                                            @endif--}}

    {{--                                        </div>--}}
    {{--                                    @endforeach--}}
    {{--                                </div>--}}

    {{--                                --}}{{-- DETAILS --}}
    {{--                                <div class="mt-3">--}}
    {{--                                    <h6 class="text-primary">--}}
    {{--                                        Summary:--}}
    {{--                                        <span class="text-muted">--}}
    {{--                                    {{ $updates->first()->gn_summary }}--}}
    {{--                                </span>--}}
    {{--                                    </h6>--}}
    {{--                                </div>--}}

    {{--                                <hr>--}}
    {{--                            </div>--}}
    {{--                        @endforeach--}}

    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--        <!-- Modal for General Update -->--}}
    {{--        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"--}}
    {{--             aria-hidden="true">--}}
    {{--            <div class="modal-dialog" role="document">--}}
    {{--                <div class="modal-content">--}}
    {{--                    <div class="modal-header">--}}
    {{--                        <h5 class="modal-title">General Update</h5>--}}
    {{--                    </div>--}}
    {{--                    <div class="modal-body text-center">--}}
    {{--                        <!-- Image preview -->--}}
    {{--                        <img id="gn_image_preview" src="" alt="GN Update"--}}
    {{--                             style="max-width:100%; max-height:400px; height:auto; margin:auto; display:block;">--}}

    {{--                        <!-- PDF preview -->--}}
    {{--                        <iframe id="gn_pdf_preview" src="" width="100%" height="400" style="display:none;"></iframe>--}}

    {{--                        <!-- Unsupported file -->--}}
    {{--                        <div id="gn_file_preview" style="display:none;">--}}
    {{--                            <p>Preview not available. <a id="gn_file_link" href="" target="_blank">Download file</a></p>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <div class="modal-footer">--}}
    {{--                        <button type="button" class="btn btn-secondary" id="closeGnModalBtn" data-dismiss="modal">Close</button>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--    <div class="row">--}}
    {{--        <div class="col-md-4">--}}
    {{--            <div class="card">--}}
    {{--                <div class="card-header text-center">Payment Updates</div>--}}
    {{--                <div class="card-body">--}}
    {{--                    <form enctype="multipart/form-data" action="{{ route('field.visit.create') }}" method="POST">--}}
    {{--                        @csrf--}}
    {{--                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">--}}

    {{--                        <!-- Take Image Button -->--}}
    {{--                        --}}{{--                        <label class="form-label">Gn Case Update</label>--}}
    {{--                        <button id="takeFvBtn" class="btn btn-dark mb-3" type="button">Upload Or Select File</button>--}}

    {{--                        <!-- Preview container -->--}}
    {{--                        <div id="previewFvContainer" class="mb-3 d-flex flex-wrap"></div>--}}

    {{--                        <!-- Hidden file input for fallback -->--}}
    {{--                        <input type="file" name="fv_updates[]" id="hiddenFvUpdates" multiple style="display:none;">--}}
    {{--                        @error('gn_updates')--}}
    {{--                        <p class="error">{{ $message }}</p>--}}
    {{--                        @enderror--}}

    {{--                        <div class="mb-3">--}}
    {{--                            <label class="form-label">FV Update</label>--}}
    {{--                            <input type="file" name="fv_updates[]" class="form-control" multiple>--}}
    {{--                            @error('fv_updates')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <div class="mb-3">--}}
    {{--                            <label class="form-label">Amount Paid</label>--}}
    {{--                            <input type="number" step="0.01" min="0" max="10000000000000" name="amount_paid"--}}
    {{--                            value="{{ old('amount_paid') }}" placeholder="Enter Paid Amount Here" class="form-control">--}}
    {{--                            @error('amount_paid')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        --}}{{-- @if ($case->legal_cost != 0)--}}
    {{--                            <div class="mb-3">--}}
    {{--                                <label class="form-label">Legal Cost</label>--}}
    {{--                                <input type="number" name="legal_cost" value="{{ $case->legal_cost }}"--}}
    {{--                                    class="form-control">--}}
    {{--                                @error('legal_cost')--}}
    {{--                                    <p class="error">{{ $message }}</p>--}}
    {{--                                @enderror--}}
    {{--                            </div>--}}
    {{--                        @endif --}}
    {{--                        <div class="mb-3">--}}
    {{--                            <label class="form-label">Payment Method</label>--}}
    {{--                            <select class="form-select" aria-label="Default select example" name="payment_method">--}}
    {{--                                <option value="" {{ old('payment_method') ? '' : 'selected' }}>Select One Payment Method</option>--}}
    {{--                                <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>--}}
    {{--                                <option value="Check" {{ old('payment_method') == 'Check' ? 'selected' : '' }}>Check</option>--}}
    {{--                                <option value="Online" {{ old('payment_method') == 'Online' ? 'selected' : '' }}>Online</option>--}}
    {{--                            </select>--}}
    {{--                            @error('payment_method')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <div class="mb-3" hidden="hidden">--}}
    {{--                            <label class="form-label">Whom To Assign</label>--}}
    {{--                            <select class="form-select" aria-label="Default select example" name="assign_type">--}}
    {{--                                <option value="" {{ old('assign_type') == '' ? 'selected' : '' }}>Select One</option>--}}
    {{--                                <option value="Admin" {{ old('assign_type') == 'Admin' ? 'selected' : '' }}>Admin</option>--}}
    {{--                                <option value="Accounts" {{ old('assign_type') == 'Accounts' ? 'selected' : '' }} selected>Accounts</option>--}}
    {{--                                <option value="Noone" {{ old('assign_type') == 'Noone' ? 'selected' : '' }}>Don't assign to anyone</option>--}}
    {{--                            </select>--}}
    {{--                            @error('assign_type')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <div class="mb-3" hidden="hidden">--}}
    {{--                            <label class="form-label">Collected By</label>--}}
    {{--                            <input class="form-control" name="collected_by_id" value="{{auth()->user()->id}}">--}}
    {{--                            <select class="form-select select2" id="collected_by_2" name="collected_by_id" aria-label="Default select example">--}}
    {{--                                <option value="" {{ old('collected_by_id') == '' ? 'selected' : '' }} disabled>Select Employee</option>--}}
    {{--                                @foreach ($employees as $employee)--}}
    {{--                                    <option value="{{ $employee->id }}" {{ old('collected_by_id') == $employee->id ? 'selected' : '' }}>--}}
    {{--                                        {{ $employee->name }}--}}
    {{--                                    </option>--}}
    {{--                                @endforeach--}}
    {{--                            </select>--}}
    {{--                            @error('collected_by_id')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <div class="mb-3">--}}
    {{--                            <label class="form-label">Date of Payment</label>--}}
    {{--                            <input type="date" value="{{ old("payment_date") }}" name="payment_date" class="form-control">--}}
    {{--                            @error('payment_date')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <div class="mb-3">--}}
    {{--                            <label class="form-label">Next Payment Amount</label>--}}
    {{--                            <input type="number" step="0.01" min="0" max="10000000000000"--}}
    {{--                                name="next_payment_amount" value="{{ old('next_payment_amount') }}" class="form-control" placeholder="Enter Next Payment Amount"--}}
    {{--                                id="next_payment_amount">--}}
    {{--                            @error('next_payment_amount')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <div class="mb-3">--}}
    {{--                            <label class="form-label">Next Payment Date</label>--}}
    {{--                            <input type="date" value="{{ old("next_payment_date") }}" name="next_payment_date" class="form-control"--}}
    {{--                                placeholder="Enter Interest Start Date">--}}
    {{--                            @error('next_payment_date')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <div class="mb-3">--}}
    {{--                            <label class="form-label d-block">Under instalment</label>--}}
    {{--                            <div class="btn-group btn-group-toggle" data-toggle="buttons">--}}
    {{--                                <label class="btn btn-secondary active">--}}
    {{--                                    <input type="radio" name="underInstallment" id="yes" autocomplete="off" checked> Yes--}}
    {{--                                </label>--}}
    {{--                                <label class="btn btn-secondary">--}}
    {{--                                    <input type="radio" name="underInstallment" id="no" autocomplete="off"> No--}}
    {{--                                </label>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                        <div class="mb-3">--}}
    {{--                            <label class="form-label">Field Visit Date</label>--}}
    {{--                            <input type="date" value="{{ old("fv_date") }}" name="fv_date" class="form-control">--}}
    {{--                            @error('fv_date')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <input type="hidden" name="update_type" value="field_visit_update">--}}
    {{--                        <div class="mb-3" hidden="hidden">--}}
    {{--                            <label class="form-label">FV Summary</label>--}}
    {{--                            <textarea name="fv_summary" class="form-control" id="" rows="2">{{ old("fv_summary") }}</textarea>--}}
    {{--                            @error('fv_summary')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <div class="mb-3">--}}
    {{--                            <label class="form-label">Remarks</label>--}}
    {{--                            <input type="text" name="remarks" value="{{ old("remarks") }}" class="form-control" placeholder="Enter Remarks Here">--}}
    {{--                            @error('remarks')--}}
    {{--                                <p class="error">{{ $message }}</p>--}}
    {{--                            @enderror--}}
    {{--                        </div>--}}
    {{--                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">--}}

    {{--                        <div class="row">--}}
    {{--                            <div class="mb-3">--}}
    {{--                                <div class="d-flex justify-content-between">--}}
    {{--                                    <div class="div">--}}
    {{--                                        <a href="{{ route('admin.cases.show', $case->id) }}"--}}
    {{--                                            class="btn btn-light">Cancel</a>--}}
    {{--                                        <button class="btn btn-primary waves-effect waves-lightml-2 " type="submit">--}}
    {{--                                            <i class="fa fa-save"></i> Save--}}
    {{--                                        </button>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </form>--}}


    {{--                    <!-- Upload / Camera Popup Modal -->--}}
    {{--                    <div class="modal fade" id="fvPopUpModal" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">--}}
    {{--                        <div class="modal-dialog">--}}
    {{--                            <div class="modal-content">--}}
    {{--                                <div class="modal-header">--}}
    {{--                                    <h5 class="modal-title">Upload File or Open Camera</h5>--}}
    {{--                                    <button type="button" class="close" id="closeFvPopupBtn"><span>&times;</span></button>--}}
    {{--                                </div>--}}
    {{--                                <div class="modal-body text-center">--}}
    {{--                                    <button type="button" id="openFvCameraBtn" class="btn btn-warning mb-2">Open Camera</button>--}}
    {{--                                    <h5 class="mt-2">OR</h5>--}}
    {{--                                    <input type="file" id="fvFileInput" multiple style="margin-top:10px;">--}}
    {{--                                </div>--}}
    {{--                                <div class="modal-footer">--}}
    {{--                                    <button type="button" id="cancelFvPopupBtn" class="btn btn-danger">Cancel</button>--}}
    {{--                                </div>--}}

    {{--                                <div class="modal-body">--}}
    {{--                                    <button id="openFvCameraBtn" class="btn btn-warning" type="button">Open Camera</button>--}}
    {{--                                    <h4 class="text-warning mt-3">OR</h4>--}}
    {{--                                    <div class="btn btn-secondary mt-2">--}}
    {{--                                        <span>Browse</span>--}}
    {{--                                        <input id="fvFileInput" type="file" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif">--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="modal-footer">--}}
    {{--                                    <button id="cancelFvPopupBtn" type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}

    {{--                    <!-- Camera Modal -->--}}
    {{--                    <div class="modal fade" id="fvCameraModal" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">--}}
    {{--                        <div class="modal-dialog">--}}
    {{--                            <div class="modal-content">--}}
    {{--                                <div class="modal-header">--}}
    {{--                                    <h5 class="modal-title">Take A Snap</h5>--}}
    {{--                                    <button type="button" class="close" id="closeFvCameraBtn"><span>&times;</span></button>--}}
    {{--                                </div>--}}
    {{--                                <div class="modal-body text-center">--}}
    {{--                                    <video id="fvVideoElement" autoplay playsinline style="width:100%; max-height:400px;"></video>--}}
    {{--                                    <canvas id="fvCanvasElement" style="display:none;"></canvas>--}}
    {{--                                </div>--}}
    {{--                                <div class="modal-footer">--}}
    {{--                                    <button type="button" id="switchFvCameraBtn" class="btn btn-warning">Switch Camera</button>--}}
    {{--                                    <button type="button" id="captureFvBtn" class="btn btn-info">Capture</button>--}}
    {{--                                    <button type="button" id="cancelFvCameraBtn" class="btn btn-danger">Cancel</button>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}

    {{--                    camera modal end--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--        <div class="col-md-8">--}}
    {{--            <div class="card">--}}
    {{--                <div class="card-body">--}}
    {{--                    <h5>Field Visit Updates</h5>--}}
    {{--                    <div id="content">--}}
    {{--                        <ul class="timeline">--}}
    {{--                            @foreach ($fv_updates as $fv_update)--}}
    {{--                                <li class="event"--}}
    {{--                                    data-date="{{ date('m-d-Y', strtotime($fv_update->created_at)) }}, {{ date('h:i a', strtotime($fv_update->created_at)) }} ">--}}


    {{--                                    @php--}}
    {{--                                        $extension = substr($fv_update->fv_update, -3);--}}
    {{--                                    @endphp--}}
    {{--                                    @if ($fv_update->fv_update != null)--}}
    {{--                                        @if ($extension == 'pdf')--}}
    {{--                                            <iframe style="overflow: hidden"--}}
    {{--                                                src="{{ asset('/documents/' . $fv_update->fv_update) }}" width="100"--}}
    {{--                                                height="100"></iframe>--}}
    {{--                                        @else--}}
    {{--                                            <img src="{{ asset('/documents/' . $fv_update->fv_update) }}" width="100"--}}
    {{--                                                height="100" />--}}
    {{--                                        @endif--}}
    {{--                                    @else--}}
    {{--                                        <div class="d-flex align-items-center justify-content-center"--}}
    {{--                                            style="background: rgb(168, 168, 168); height: 100px; width: 100px; color: #ffffff; border-radius: 4px">--}}
    {{--                                            <small>No file to show</small>--}}
    {{--                                        </div>--}}
    {{--                                    @endif--}}
    {{--                                    <h6 class="mt-2">Date of payment:--}}
    {{--                                        {{ $fv_update->fv_date == null ? 'N/A' : date('m-d-Y', strtotime($fv_update->fv_date)) }}--}}
    {{--                                    </h6>--}}
    {{--                                    <span class="d-block">{{ $fv_update->fv_summary }}</span>--}}
    {{--                                    <div class="d-flex">--}}
    {{--                                        <a href="#" class="btn  btn-primary mt-2 viewFVUpdate2" data-toggle="modal"--}}
    {{--                                            data-target="#exampleModal2">--}}
    {{--                                            <span class="fv_id d-none">{{ $fv_update->id }}</span>--}}
    {{--                                            <i class="far fa-eye"></i> View--}}
    {{--                                        </a>--}}

    {{--                                        @if(Auth::user()->user_type == \App\Models\User::USER_TYPE_EMPLOYEE && $task->status == 'not_complete')--}}
    {{--                                            <a class="btn btn-warning mt-2" style="margin-left: 5px;" href="{{ route('admin.tasks.edit', $task->id) }}">Edit</a>--}}
    {{--                                            <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST">--}}
    {{--                                                @csrf--}}
    {{--                                                @method('DELETE')--}}
    {{--                                                <button class="btn btn-danger mt-2 ml-2" style="margin-left: 5px;" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>--}}
    {{--                                            </form>--}}
    {{--                                        @endif--}}
    {{--                                    </div>--}}
    {{--                                </li>--}}
    {{--                            @endforeach--}}
    {{--                        </ul>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--        <div class="col-md-8">--}}
    {{--            <div class="card">--}}
    {{--                <div class="card-body">--}}

    {{--                    <h5 class="text-center table-outer-border p-2 bg-soft-lime text-lime">--}}
    {{--                        Payment Updates--}}
    {{--                    </h5>--}}

    {{--                    <div id="fv-timeline">--}}

    {{--                        @php--}}
    {{--                            $groupedFvUpdates = $fv_updates->groupBy(function ($item) {--}}
    {{--                                return \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:i');--}}
    {{--                            });--}}
    {{--                        @endphp--}}

    {{--                        @foreach ($groupedFvUpdates as $time => $updates)--}}
    {{--                            <div class="timeline-group payment-group">--}}

    {{--                                --}}{{-- HEADER (TIME + ACTIONS) --}}
    {{--                                <div class="d-flex justify-content-between align-items-center mb-2">--}}

    {{--                                    <div class="timeline-time text-primary">--}}
    {{--                                        {{ \Carbon\Carbon::parse($time)->format('m-d-Y, h:i a') }}--}}
    {{--                                    </div>--}}

    {{--                                    --}}{{-- GROUP ACTIONS (EDIT / DELETE FULL PAYMENT UPDATE) --}}
    {{--                                    @if(Auth::user()->user_type == \App\Models\User::USER_TYPE_ADMIN && $task->status == 'not_complete')--}}
    {{--                                        <div class="payment-actions">--}}
    {{--                                            <a href="{{ route('admin.tasks.edit', $task->id) }}"--}}
    {{--                                               class="action-icon edit btn btn-sm btn-outline-primary"--}}
    {{--                                               title="Edit this payment update">--}}
    {{--                                                <i class="fas fa-pen"></i>--}}
    {{--                                            </a>--}}

    {{--                                            <form action="{{ route('admin.tasks.destroy', $task->id) }}"--}}
    {{--                                                  method="POST"--}}
    {{--                                                  class="d-inline">--}}
    {{--                                                @csrf--}}
    {{--                                                @method('DELETE')--}}
    {{--                                                <button type="submit"--}}
    {{--                                                        class="action-icon delete"--}}
    {{--                                                        title="Delete this payment update"--}}
    {{--                                                        onclick="return confirm('Are you sure you want to delete this payment update?')">--}}
    {{--                                                    <i class="fas fa-trash"></i>--}}
    {{--                                                </button>--}}
    {{--                                            </form>--}}
    {{--                                        </div>--}}
    {{--                                    @endif--}}
    {{--                                </div>--}}

    {{--                                --}}{{-- FILE GRID --}}
    {{--                                <div class="timeline-grid">--}}
    {{--                                    @foreach ($updates as $fv_update)--}}
    {{--                                        @php--}}
    {{--                                            $file = $fv_update->fv_update;--}}
    {{--                                            $ext = $file ? strtolower(pathinfo($file, PATHINFO_EXTENSION)) : null;--}}
    {{--                                        @endphp--}}

    {{--                                        <div class="timeline-item fv-thumb"--}}
    {{--                                             data-id="{{ $fv_update->id }}">--}}

    {{--                                            @if ($file)--}}
    {{--                                                @if ($ext === 'pdf')--}}
    {{--                                                    <div class="file-thumb pdf-thumb">--}}
    {{--                                                        <i class="far fa-file-pdf"></i>--}}
    {{--                                                        <span>PDF</span>--}}
    {{--                                                    </div>--}}
    {{--                                                @else--}}
    {{--                                                    <img src="{{ asset('/documents/' . $file) }}" />--}}
    {{--                                                @endif--}}
    {{--                                            @else--}}
    {{--                                                <div class="file-thumb empty-thumb">--}}
    {{--                                                    <small>No file</small>--}}
    {{--                                                </div>--}}
    {{--                                            @endif--}}

    {{--                                        </div>--}}
    {{--                                    @endforeach--}}
    {{--                                </div>--}}

    {{--                                --}}{{-- DETAILS --}}
    {{--                                <div class="mt-3">--}}
    {{--                                    <h6 class="text-primary">--}}
    {{--                                        Date of payment:--}}
    {{--                                        <span class="text-muted">--}}
    {{--                                    {{ $updates->first()->fv_date ? date('m-d-Y', strtotime($updates->first()->fv_date)) : 'N/A' }}--}}
    {{--                                </span>--}}
    {{--                                    </h6>--}}

    {{--                                    <h6 class="text-primary">--}}
    {{--                                        Remarks:--}}
    {{--                                        <span class="text-muted">--}}
    {{--                                    {{ $updates->first()->remarks }}--}}
    {{--                                </span>--}}
    {{--                                    </h6>--}}
    {{--                                </div>--}}

    {{--                                <hr>--}}
    {{--                            </div>--}}
    {{--                        @endforeach--}}

    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--        <!-- Modal for FV Update -->--}}
    {{--        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"--}}
    {{--            aria-hidden="true">--}}
    {{--            <div class="modal-dialog" role="document">--}}
    {{--                <div class="modal-content">--}}
    {{--                    <div class="modal-header">--}}
    {{--                        <h5 class="modal-title" id="exampleModalLabel">Feild Visit Update</h5>--}}
    {{--                    </div>--}}
    {{--                    <div class="modal-body">--}}
    {{--                        <iframe id="fv_update" src="" class="mt-2" width="100%" height="400">--}}
    {{--                        </iframe>--}}
    {{--                    </div>--}}
    {{--                    <div class="modal-footer">--}}
    {{--                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}

    {{--        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"--}}
    {{--             aria-hidden="true">--}}
    {{--            <div class="modal-dialog" role="document">--}}
    {{--                <div class="modal-content">--}}
    {{--                    <div class="modal-header">--}}
    {{--                        <h5 class="modal-title">Payment Update</h5>--}}
    {{--                    </div>--}}
    {{--                    <div class="modal-body text-center">--}}
    {{--                        <!-- Image preview -->--}}
    {{--                        <img id="fv_image_preview" src="" alt="FV Update"--}}
    {{--                             style="max-width:100%; max-height:400px; height:auto; display:none; margin:auto; display:block;">--}}

    {{--                        <!-- PDF preview -->--}}
    {{--                        <iframe id="fv_pdf_preview" src="" width="100%" height="400" style="display:none;"></iframe>--}}

    {{--                        <!-- Unsupported file -->--}}
    {{--                        <div id="fv_file_preview" style="display:none;">--}}
    {{--                            <p>Preview not available. <a id="fv_file_link" href="" target="_blank">Download file</a></p>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <div class="modal-footer">--}}
    {{--                        <button type="button" id="closeFvModalBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    {{-- <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">CR Case Update</div>
                <div class="card-body">
                    <form enctype="multipart/form-data" action="{{ route('general.case.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">
                        <div class="mb-3">
                            <label class="form-label">CR Case Update</label>
                            <input type="file" name="cr_updates[]" class="form-control" multiple>
                            @error('cr_updates')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Field Visit Date</label>
                            <input type="date" name="fv_date" class="form-control">
                            @error('fv_date')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">CR Summary</label>
                            <textarea name="cr_summary" class="form-control" id="" rows="2"></textarea>
                            @error('cr_summary')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">

                        <div class="row">
                            <div class="mb-3 text-end">
                                <a href="{{ route('admin.cases.show', $case->id) }}" class="btn btn-light">Cancel</a>
                                <button class="btn btn-primary waves-effect waves-lightml-2 " type="submit">
                                    <i class="fa fa-save"></i> Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5>CR Updates</h5>
                    <div id="content">
                        <ul class="timeline">
                            @foreach ($cr_updates as $cr_update)
                                <li class="event"
                                    data-date="{{ date('d-m-Y', strtotime($cr_update->created_at)) }}, {{ date('h:i a', strtotime($cr_update->created_at)) }} ">
                                    <iframe src="{{ asset('/documents/' . $cr_update->cr_update) }}" width="400"
                                        height="400"></iframe>

                                    <h6 class="mt-2">Field Visited at:
                                        {{ date('d-m-Y', strtotime($cr_update->fv_date)) }}</h6>
                                    <span class="d-block">{{ $cr_update->cr_summary }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Modal for GN Update -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Gn Update</h5>
                        </div>
                        <div class="modal-body">
                            <iframe id="gn_update" src="" class="mt-2" width="100%" height="400">
                            </iframe>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- Test comment --}}
    {{-- <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">MS Update</div>
                <div class="card-body">
                    <form enctype="multipart/form-data" action="{{ route('general.case.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">
                        <div class="mb-3">
                            <label class="form-label">MS Update</label>
                            <input type="file" name="ms_updates[]" class="form-control" multiple>
                            @error('ms_update')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Field Visit Date</label>
                            <input type="date" name="fv_date" class="form-control">
                            @error('fv_date')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">MS Summary</label>
                            <textarea name="ms_summary" class="form-control" id="" rows="2"></textarea>
                            @error('ms_summary')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">

                        <div class="row">
                            <div class="mb-3 text-end">
                                <a href="{{ route('admin.cases.show', $case->id) }}" class="btn btn-light">Cancel</a>
                                <button class="btn btn-primary waves-effect waves-lightml-2 " type="submit">
                                    <i class="fa fa-save"></i> Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5>MS Updates</h5>
                    <div id="content">
                        <ul class="timeline">
                            @foreach ($ms_updates as $ms_update)
                                <li class="event"
                                    data-date="{{ date('d-m-Y', strtotime($ms_update->created_at)) }}, {{ date('h:i a', strtotime($ms_update->created_at)) }} ">
                                    <iframe src="{{ asset('/documents/' . $ms_update->ms_update) }}" width="400"
                                        height="400"></iframe>

                                    <h6 class="mt-2">Field Visited at:
                                        {{ date('d-m-Y', strtotime($ms_update->fv_date)) }}</h6>
                                    <span class="d-block">{{ $ms_update->ms_summary }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="modal fade" id="exampleModal0" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Total Balance</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update.total.amount.balance', $case->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="num1">Total Amount Balance</label>
                            <input type="number" class="form-control" readonly name="" id="num1"
                                aria-describedby="emailHelp" value="{{ $case->total_amount_balance }}">
                        </div>
                        <div class="form-group mt-2">
                            <label for="num2">Amount Paid</label>
                            <input type="number" class="form-control" name="total_amount_paid" id="num2"
                                value="">
                        </div>
                        <div class="form-group mt-2">
                            <label for="subt">Unpaid Amount Balance</label>
                            <input type="text" class="form-control" name="total_amount_balance" id="subt"
                                value="">
                        </div>
                        <button type="submit" class="btn btn-success mt-2">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {

            $('#collected_by, #collected_by_2').select2();

            $(function() {
                $("#num2").on("keydown keyup", sum);

                function sum() {
                    var result = Number($("#num1").val()) - Number($("#num2").val())
                    $("#subt").val(result.toFixed(2));
                }
            });
        });

        $(document).on('click', '.timeline-item', function () {

            const gn_update_id = $(this).data('id');

            $.ajax({
                type: 'get',
                url: '{{ route('single.general.case.update') }}',
                data: { id: gn_update_id },
                success: function (response) {

                    let fileUrl = "{{ asset('documents') }}/" + response.data.gn_update;

                    $('#gn_image_preview, #gn_pdf_preview, #gn_file_preview').hide();

                    const ext = fileUrl.split('.').pop().toLowerCase();

                    if (['jpg','jpeg','png','gif','webp'].includes(ext)) {
                        $('#gn_image_preview').attr('src', fileUrl).show();
                    } else if (ext === 'pdf') {
                        $('#gn_pdf_preview').attr('src', fileUrl).show();
                    } else {
                        $('#gn_file_link').attr('href', fileUrl);
                        $('#gn_file_preview').show();
                    }

                    $('#exampleModal').modal('show');
                }
            });
        });
        $(document).ready(function() {
            {{--$('.viewFVUpdate').click(function(e) {--}}
            {{--    var gn_update_id = $(this).find('.gn_id').text();--}}

            {{--    $.ajax({--}}
            {{--        type: 'get',--}}
            {{--        url: '{{ route('single.general.case.update') }}',--}}
            {{--        data: { id: gn_update_id },--}}
            {{--        success: (response) => {--}}
            {{--            let fileUrl = "{{ asset('documents') }}/" + response.data.gn_update;--}}

            {{--            // Hide all previews--}}
            {{--            $('#gn_image_preview, #gn_pdf_preview, #gn_file_preview').hide();--}}

            {{--            const ext = fileUrl.split('.').pop().toLowerCase();--}}

            {{--            if (['jpg','jpeg','png','gif','webp'].includes(ext)) {--}}
            {{--                $('#gn_image_preview').attr('src', fileUrl).show();--}}
            {{--            } else if (ext === 'pdf') {--}}
            {{--                $('#gn_pdf_preview').attr('src', fileUrl).show();--}}
            {{--            } else {--}}
            {{--                $('#gn_file_link').attr('href', fileUrl);--}}
            {{--                $('#gn_file_preview').show();--}}
            {{--            }--}}

            {{--            $('#exampleModal').modal('show');--}}
            {{--        },--}}
            {{--        error: function(response) {--}}
            {{--            $('#error').text(response.responseJSON.message);--}}
            {{--        }--}}
            {{--    });--}}
            {{--});--}}

            // Fix lingering backdrop globally
            $('#exampleModal').on('hidden.bs.modal', function () {
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
            });

            $('#closeGnModalBtn').click(function() {
                $('#exampleModal').modal('hide');
            })

            // Open Fv modal and load file
            {{--$('.viewFVUpdate2').click(function(e) {--}}
            {{--    var fv_update_id = $(this).find('.fv_id').text();--}}

            {{--    $.ajax({--}}
            {{--        type: 'get',--}}
            {{--        url: '{{ route('single.field.vist.update') }}',--}}
            {{--        data: { id: fv_update_id },--}}
            {{--        success: (response) => {--}}
            {{--            let fileUrl = "{{ asset('/documents/') }}/" + response.data.fv_update;--}}

            {{--            $('#fv_image_preview, #fv_pdf_preview, #fv_file_preview').hide();--}}

            {{--            const ext = fileUrl.split('.').pop().toLowerCase();--}}
            {{--            if(['jpg','jpeg','png','gif','webp'].includes(ext)){--}}
            {{--                $('#fv_image_preview').attr('src', fileUrl).show();--}}
            {{--            } else if(ext === 'pdf'){--}}
            {{--                $('#fv_pdf_preview').attr('src', fileUrl).show();--}}
            {{--            } else {--}}
            {{--                $('#fv_file_link').attr('href', fileUrl);--}}
            {{--                $('#fv_file_preview').show();--}}
            {{--            }--}}

            {{--            $('#exampleModal2').modal('show');--}}
            {{--        },--}}
            {{--        error: function(response) {--}}
            {{--            $('#error').text(response.responseJSON.message);--}}
            {{--        }--}}
            {{--    });--}}
            {{--});--}}

            {{--$(document).on('click', '.fv-thumb, .viewFVUpdate2', function(e) {--}}
            {{--    e.preventDefault();--}}

            {{--    // prefer data-id (thumbnail or view button), fallback to nested span if present.--}}
            {{--    var fv_update_id = $(this).data('id') || $(this).find('.fv_id').text();--}}

            {{--    if (!fv_update_id) return;--}}

            {{--    $.ajax({--}}
            {{--        type: 'GET',--}}
            {{--        url: '{{ route('single.field.vist.update') }}',--}}
            {{--        data: { id: fv_update_id },--}}
            {{--        success: function(response) {--}}
            {{--            var fileName = response.data.fv_update;--}}
            {{--            var createdAt = response.data.created_at; // if your response provides created_at--}}
            {{--            var fileUrl = fileName ? "{{ asset('/documents/') }}/" + fileName : null;--}}

            {{--            // hide all preview areas--}}
            {{--            $('#fv_image_preview, #fv_pdf_preview, #fv_file_preview').addClass('d-none').hide();--}}

            {{--            if (!fileUrl) {--}}
            {{--                $('#fv_file_link').attr('href', '#').text('No file available');--}}
            {{--                $('#fv_file_preview').removeClass('d-none').show();--}}
            {{--            } else {--}}
            {{--                var ext = fileUrl.split('.').pop().toLowerCase();--}}
            {{--                if (['jpg','jpeg','png','gif','webp','bmp','svg'].includes(ext)) {--}}
            {{--                    $('#fv_image_preview').attr('src', fileUrl).removeClass('d-none').show();--}}
            {{--                } else if (ext === 'pdf') {--}}
            {{--                    $('#fv_pdf_preview').attr('src', fileUrl).removeClass('d-none').show();--}}
            {{--                } else {--}}
            {{--                    $('#fv_file_link').attr('href', fileUrl).text('Open / Download');--}}
            {{--                    $('#fv_file_preview').removeClass('d-none').show();--}}
            {{--                }--}}
            {{--            }--}}

            {{--            // optional: show created date in footer if available--}}
            {{--            if (createdAt) {--}}
            {{--                $('#fv_preview_date').text(new Date(createdAt).toLocaleString());--}}
            {{--            } else {--}}
            {{--                $('#fv_preview_date').text('');--}}
            {{--            }--}}

            {{--            // show modal (Bootstrap 5)--}}
            {{--            var modal = new bootstrap.Modal(document.getElementById('exampleModal2'));--}}
            {{--            modal.show();--}}
            {{--        },--}}
            {{--        error: function(xhr) {--}}
            {{--            var msg = 'An error occurred';--}}
            {{--            if (xhr && xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;--}}
            {{--            alert(msg);--}}
            {{--        }--}}
            {{--    });--}}
            {{--});--}}

            $('#fv-timeline').on('click', '.fv-thumb', function (e) {
                e.preventDefault();
                e.stopPropagation(); // 🔥 VERY IMPORTANT

                var fv_update_id = $(this).data('id');
                if (!fv_update_id) return;

                $.ajax({
                    type: 'GET',
                    url: '{{ route('single.field.vist.update') }}',
                    data: { id: fv_update_id },
                    success: function (response) {

                        var fileName = response.data.fv_update;
                        var fileUrl = fileName ? "{{ asset('/documents') }}/" + fileName : null;

                        $('#fv_image_preview, #fv_pdf_preview, #fv_file_preview')
                            .addClass('d-none')
                            .hide();

                        if (!fileUrl) {
                            $('#fv_file_link').attr('href', '#').text('No file available');
                            $('#fv_file_preview').removeClass('d-none').show();
                        } else {
                            var ext = fileUrl.split('.').pop().toLowerCase();

                            if (['jpg','jpeg','png','gif','webp','bmp','svg'].includes(ext)) {
                                $('#fv_image_preview').attr('src', fileUrl).removeClass('d-none').show();
                            } else if (ext === 'pdf') {
                                $('#fv_pdf_preview').attr('src', fileUrl).removeClass('d-none').show();
                            } else {
                                $('#fv_file_link').attr('href', fileUrl).text('Open / Download');
                                $('#fv_file_preview').removeClass('d-none').show();
                            }
                        }

                        $('#exampleModal2').modal('show');
                    },
                    error: function (xhr) {
                        alert(xhr.responseJSON?.message || 'Something went wrong');
                    }
                });
            });

            // Fix lingering backdrop globally
            $('#exampleModal2').on('hidden.bs.modal', function () {
                setTimeout(function() {
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                }, 200); // short delay to ensure modal finished hiding
            });

            $('#closeFvModalBtn').click(function() {
                $('#exampleModal2').modal('hide');
            })
        });
    </script>
    {{--    sticki header--}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const sticky = document.getElementById('caseStickyWrapper');
            const tabContent = document.getElementById('tabContentWrapper');
            const breadcrumb = document.querySelector('.breadcrumb') || document.querySelector('.page-title');

            const navbar = document.querySelector('.navbar');
            const sidebar = document.querySelector('.sidebar');

            function setCSSVars() {
                document.documentElement.style.setProperty(
                    '--navbar-height',
                    navbar ? navbar.offsetHeight + 'px' : '70px'
                );

                document.documentElement.style.setProperty(
                    '--sidebar-width',
                    sidebar ? sidebar.offsetWidth + 'px' : '0px'
                );
            }

            function setTabHeight() {
                const vh = window.innerHeight;
                const stickyHeight = sticky.offsetHeight;
                const navbarHeight = navbar ? navbar.offsetHeight : 70;

                tabContent.style.maxHeight =
                    (vh - stickyHeight - navbarHeight - 20) + 'px';
            }

            const triggerPoint =
                breadcrumb.offsetTop + breadcrumb.offsetHeight;

            window.addEventListener('scroll', function () {
                if (window.scrollY > triggerPoint) {
                    sticky.classList.add('is-sticky');
                } else {
                    sticky.classList.remove('is-sticky');
                }
            });

            tabContent.addEventListener('scroll', function () {
                tabContent.classList.toggle('scrolled', tabContent.scrollTop > 5);
            });

            window.addEventListener('resize', function () {
                setCSSVars();
                setTabHeight();
            });

            // init
            setCSSVars();
            setTabHeight();
        });
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tooltipTriggerList = [].slice.call(
                document.querySelectorAll('[data-bs-toggle="tooltip"]')
            );
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    container: 'body',
                    html: false,
                    delay: { show: 200, hide: 100 }
                });
            });
        });
    </script>


    {{--    to open previous tab after refresing or form submission--}}
    <script>
        $(document).ready(function () {

            const STORAGE_KEY = 'activeUpdateTab';

            function activateTab(targetSelector) {
                $('#updateTabs .nav-link').removeClass('active');
                $('.tab-pane').removeClass('show active');

                $('#updateTabs button[data-bs-target="' + targetSelector + '"]').addClass('active');
                $(targetSelector).addClass('show active');
            }

            const savedTab = localStorage.getItem(STORAGE_KEY);

            // Default = All Debtors
            const defaultTab = '#all-debtors';

            const initialTab = (savedTab && $(savedTab).length)
                ? savedTab
                : defaultTab;

            activateTab(initialTab);

            $('.update-tabs, .tab-content').css('visibility', 'visible');

            $('#updateTabs').on('click', 'button[data-bs-toggle="pill"]', function () {
                const target = $(this).attr('data-bs-target');
                localStorage.setItem(STORAGE_KEY, target);
            });

        });
    </script>

@endpush
@push('style')
    <style>
        .card-padding-start {
            padding-left: 70px;
        }

        .fixed {
            position: absolute;
            width: 100%;
            background-color: #f1f1f1;
            padding: 10px 0;
            transition: top 0.3s;
            z-index: 9999;
            /* For smooth transition */
        }

        /* Style for the fixed div when it's fixed */
        .fixed.fixed-top {
            position: fixed;
            top: 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .timeline {
            border-left: 3px solid #858AB6;
            border-bottom-right-radius: 4px;
            border-top-right-radius: 4px;
            margin: 0 auto;
            letter-spacing: 0.2px;
            position: relative;
            line-height: 1.4em;
            font-size: 1.03em;
            padding: 50px;
            list-style: none;
            text-align: left;
            max-width: 60%;
        }

        .btn-color {
            background-color: #858AB6;
            outline: none;
            border: 0
        }

        .btn-color:hover {
            background-color: #858AB6;
            outline: none;
            border: 0
        }

        @media (max-width: 767px) {
            .timeline {
                max-width: 98%;
                padding: 25px;
            }
        }

        .timeline h1 {
            font-weight: 300;
            font-size: 1.4em;
        }

        .timeline h2,
        .timeline h3 {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .timeline .event {
            border-bottom: 1px dashed #e8ebf1;
            padding-bottom: 25px;
            margin-bottom: 25px;
            position: relative;
        }

        @media (max-width: 767px) {
            .timeline .event {
                padding-top: 30px;
            }
        }

        .timeline .event:last-of-type {
            padding-bottom: 0;
            margin-bottom: 0;
            border: none;
        }

        .timeline .event:before,
        .timeline .event:after {
            position: absolute;
            display: block;
            top: 0;
        }

        .timeline .event:before {
            left: -207px;
            content: attr(data-date);
            text-align: right;
            font-weight: 100;
            font-size: 0.9em;
            min-width: 120px;
        }

        @media (max-width: 767px) {
            .timeline .event:before {
                left: 0px;
                text-align: left;
            }
        }

        .timeline .event:after {
            -webkit-box-shadow: 0 0 0 3px #858AB6;
            box-shadow: 0 0 0 3px #858AB6;
            left: -55.8px;
            background: #fff;
            border-radius: 50%;
            height: 9px;
            width: 9px;
            content: "";
            top: 5px;
        }

        @media (max-width: 767px) {
            .timeline .event:after {
                left: -31.8px;
            }
        }

        .rtl .timeline {
            border-left: 0;
            text-align: right;
            border-bottom-right-radius: 0;
            border-top-right-radius: 0;
            border-bottom-left-radius: 4px;
            border-top-left-radius: 4px;
            border-right: 3px solid #727cf5;
        }

        .rtl .timeline .event::before {
            left: 0;
            right: -170px;
        }

        .rtl .timeline .event::after {
            left: 0;
            right: -55.8px;
        }

        .table-outer-border {
            border: 1px solid #dee2e6; /* Adjust color as needed */
        }

        .thumb-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.12);
        }

        .thumb-pdf {
            width: 50px;
            height: 50px;
            background: #f2f2f2;
            color: #c0392b;
            border-radius: 6px;
            border: 1px solid rgba(0,0,0,0.06);
            font-size: 12px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }

        .placeholder-thumb {
            width: 50px;
            height: 50px;
            background: #a8a8a8;
            color: #fff;
            border-radius: 6px;
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .fv-thumb { text-decoration: none; }
        .fv-thumb:hover .thumb-img { transform: scale(1.03); transition: transform .12s ease-in-out; }

        /* .fixed-content{
                                                                                                                position: fixed;
                                                                                                                z-index: 9999;
                                                                                                                width: 70%;
                                                                                                            } */
        /* .balance-btn{
                                                                                                                padding-top: 100px;
                                                                                                            } */


        .timeline-group {
            margin-bottom: 25px;
        }

        .timeline-time {
            font-weight: 600;
        }

        .timeline-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 12px;
        }

        .timeline-item {
            cursor: pointer;
        }

        .timeline-item img,
        .file-thumb {
            width: 100%;
            height: 120px;
            border-radius: 8px;
            object-fit: cover;
            background: #f1f1f1;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s ease;
        }

        .timeline-item:hover img,
        .timeline-item:hover .file-thumb {
            transform: scale(1.04);
        }

        .pdf-thumb {
            color: #dc3545;
            font-size: 26px;
            flex-direction: column;
        }

        .empty-thumb {
            background: #aaa;
            color: #fff;
        }

        .payment-actions {
            display: flex;
            gap: 8px;
        }

        .action-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: #f4f6f8;
            color: #555;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .action-icon.edit:hover {
            background: #e7f1ff;
            color: #0d6efd;
        }

        .action-icon.delete:hover {
            background: #fdeaea;
            color: #dc3545;
        }

        .action-icon i {
            font-size: 14px;
        }

        /*tab css start*/

        .update-tabs .nav-link {
            font-weight: 600;
            color: #6c757d;
            border-radius: 10px;
            padding: 10px 15px;
            transition: all 0.25s ease;
        }

        .update-tabs .nav-link.active {
            background: linear-gradient(135deg, #c7f000, #9adf00);
            color: #1f2d3d;
            box-shadow: 0 6px 15px rgba(154, 223, 0, 0.35);
        }

        .update-tabs .nav-link i {
            opacity: 0.85;
        }

        /* Smooth fade + slide animation for tab content */
        .tab-pane {
            opacity: 0;
            transform: translateY(8px);
            transition: all 0.35s ease;
        }

        .tab-pane.show.active {
            opacity: 1;
            transform: translateY(0);
        }

        .update-tabs .nav-link {
            transition: all 0.25s ease;
        }

        .update-tabs .nav-link.active {
            transform: translateY(-1px);
        }

        /* Prevent tab flash before JS restores state */
        .update-tabs,
        .tab-content {
            visibility: hidden;
        }

        /*status tooltip css start*/
        .payment-tooltip {
            font-size: 13px;
            line-height: 1.4;
        }

        .tooltip-inner {
            max-width: 280px;
            padding: 10px 12px;
            text-align: left;
            background-color: #ffffff;
            color: #212529;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .tooltip.bs-tooltip-top .tooltip-arrow::before {
            border-top-color: #ffffff;
        }
        .status-badge {
            cursor: help;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .status-badge:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        /*status tooltip css end*/

        /*tab css end*/

        /*sticki header*/
        /* Sticky wrapper base */
        #caseStickyWrapper {
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            /*z-index: 10;*/
        }

        /* Activated sticky state */
        #caseStickyWrapper.is-sticky {
            position: fixed;
            top: var(--navbar-height);
            width: calc(100% - var(--sidebar-width));
            transform: translateY(0);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
            background: #fff;
        }

        /* Smooth slide-in */
        #caseStickyWrapper.is-sticky {
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-10px);
                opacity: 0.95;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Scrollable tab content */
        #tabContentWrapper {
            overflow-y: auto;
            padding-top: 12px;
            overflow-x:hidden ;
        }

        /* Scroll shadow indicator */
        #tabContentWrapper::before {
            content: "";
            position: sticky;
            top: 0;
            height: 12px;
            /*background: linear-gradient(to bottom, rgba(0,0,0,0.15), transparent);*/
            display: none;
            /*z-index: 5;*/
        }

        #tabContentWrapper.scrolled::before {
            display: block;
        }
    </style>
@endpush
