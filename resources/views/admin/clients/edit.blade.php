@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">{{get_page_meta('title', true)}}</h4>

                    <form action="{{ route('admin.clients.update', $clients->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">First Name <span class="error">*</span></label>
                                <input type="text" name="first_name" class="form-control" placeholder="First Name"
                                       value="{{ $clients->first_name }}">
                                @error('first_name')
                                <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Last Name <span class="error">*</span></label>
                                <input type="text" name="last_name" class="form-control" placeholder="Last Name"
                                       value="{{ $clients->last_name }}">
                                @error('last_name')
                                <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Status<span class="error">*</span></label>
                                <select class="form-select" name="status" aria-label="Default select example"
                                        id="status">
                                        <option selected disabled>Select One</option>
                                        <option class="text-capitalize"
                                            value="{{ App\Utils\GlobalConstant::STATUS_ACTIVE }}">
                                            Active</option>

                                        <option class="text-capitalize"
                                            value="{{ App\Utils\GlobalConstant::STATUS_REJECTED }}">
                                           Rejected</option>

                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Email <span class="error">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Email"
                                       value="{{ $clients->email }}">
                                @error('email')
                                <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Phone <span class="error">*</span></label>
                                <input type="tel" name="phone" class="form-control" placeholder="Phone"
                                       value="{{ $clients->phone }}">
                                @error('phone')
                                <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Password <span class="error">*</span></label>
                                <input type="password" name="password" id="password" class="form-control"
                                       placeholder="Password" value="{{ $clients->password }}">
                                @error('password')
                                <p class="error">{{ $message }}</p>
                                @enderror
                                <span id="StrengthDisp" class="input_bellow_text">
                                    Should contains Letters(uppercase & lowercase), Number and Special Characters.
                                </span>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Confirm Password <span class="error">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control"
                                       placeholder="Confirm Password" value="{{ $clients->password }}">
                                @error('password_confirmation')
                                <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                        <div class="row">
                            <div class="mb-3 offset-md-6 col-md-6">
                                <div class="text-end">
                                    <button class="btn btn-primary waves-effect waves-lightml-2 me-2" type="submit">
                                        <i class="fa fa-save"></i> Save
                                    </button>

                                    <a class="btn btn-secondary waves-effect" href="{{ route('admin.clients.index') }}">
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('script')
    <script src="{{ asset('/admin/js/passwordCheck.js') }}"></script>
@endpush

