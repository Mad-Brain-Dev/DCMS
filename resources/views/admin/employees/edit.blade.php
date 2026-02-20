@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">{{ get_page_meta('title', true) }}</h4>

                    <form action="{{ route('admin.employees.update', $employee->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">First Name <span class="error">*</span></label>
                                <input type="text" name="first_name" class="form-control" required=""
                                    placeholder="First Name" value="{{ $employee->first_name }}">
                                @error('first_name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Last Name <span class="error">*</span></label>
                                <input type="text" name="last_name" class="form-control" required=""
                                    placeholder="Last Name" value="{{ $employee->last_name }}">
                                @error('last_name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- <div class="mb-3 col-md-6">
                                <label class="form-label">Email <span class="error">*</span></label>
                                <input type="email" name="email" class="form-control" required="" placeholder="Email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div> --}}

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Phone <span class="error">*</span></label>
                                <input type="tel" name="phone" class="form-control" required="" placeholder="Phone"
                                    value="{{ $employee->phone }}">
                                @error('phone')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Email <span class="error">*</span></label>
                                <input type="email" name="email" class="form-control" required="" placeholder="Email"
                                       value="{{ $employee->email }}">
                                @error('email')
                                <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Select Role <span class="error">*</span></label>
                                <select class="form-control select2" name="role" required>
                                    <option selected disabled>Select One</option>
                                    @forelse ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ $employee->employee->role == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @empty
                                        <option value="">Nothing in the list</option>
                                    @endforelse
                                </select>
                                @error('role')
                                <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Commission Rate (in %)<span class="error">*</span></label>
                                <input type="number" name="commission_rate" class="form-control" required=""
                                       value="{{ $employee->employee->commission_rate }}">
                                @error('commission_rate')
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

                                    <a class="btn btn-secondary waves-effect" href="{{ route('admin.employees.index') }}">
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
