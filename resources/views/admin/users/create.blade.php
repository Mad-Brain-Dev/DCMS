@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">{{ get_page_meta('title', true) }}</h4>

                    <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">First Name <span class="error">*</span></label>
                                <input type="text" name="first_name" class="form-control" required=""
                                    placeholder="First Name" value="{{ old('first_name') }}">
                                @error('first_name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Last Name <span class="error">*</span></label>
                                <input type="text" name="last_name" class="form-control" required=""
                                    placeholder="Last Name" value="{{ old('last_name') }}">
                                @error('last_name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Email <span class="error">*</span></label>
                                <input type="email" name="email" class="form-control" required="" placeholder="Email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Phone <span class="error">*</span></label>
                                <input type="tel" name="phone" class="form-control" required="" placeholder="Phone"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Password <span class="error">*</span></label>
                                <input type="password" name="password" id="password" class="form-control" required=""
                                    placeholder="Password" value="">
                                @error('password')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                                <span id="StrengthDisp" class="input_bellow_text">
                                    Should contains Letters(uppercase & lowercase), Number and Special Characters.
                                </span>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Confirm Password <span class="error">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required=""
                                    placeholder="Confirm Password" value="">
                                @error('password_confirmation')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- <div class="mb-3 col-md-6">
                                <label class="form-label mb-2 w-100">Status <span class="error">*</span></label>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="status_yes" value="{{ \App\Utils\GlobalConstant::STATUS_ACTIVE }}"
                                           name="status" class="form-check-input" checked="">
                                    <label class="custom-control-label" for="status_yes">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="status_no" value="{{ \App\Utils\GlobalConstant::STATUS_INACTIVE }}"
                                           name="status" class="form-check-input">
                                    <label class="custom-control-label" for="status_no">Inactive</label>
                                </div>
                            </div> --}}

                            <div class="mb-3">
                                <label class="form-label">Select Grade <span class="error">*</span></label>
                                <select class="form-control select2" name="role[]" required multiple>
                                    <option selected disabled>Select One</option>
                                    @forelse ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ old('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @empty
                                        <option value="">Nothing in the list</option>
                                    @endforelse
                                </select>
                                @error('role')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>


                        </div>

                        <div class="row">
                            <div class="mb-3 offset-md-6 col-md-6">
                                <div class="text-end">
                                    <button class="btn btn-primary waves-effect waves-lightml-2 me-2" type="submit">
                                        <i class="fa fa-save"></i> Save
                                    </button>

                                    <a class="btn btn-secondary waves-effect" href="{{ route('admin.users.index') }}">
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
