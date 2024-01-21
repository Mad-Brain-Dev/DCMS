@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Edit Grading</h4>
                    <div class="row">
                        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" id="form">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card shipping_address_card">
                                        <div class="card-body">
                                            <div class="form-group mb-2">
                                                <label for="name">Grading Name <span class="error">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name" autocomplete="off"
                                                       placeholder="Enter Grade Name" value="{{ $role->name }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card shipping_address_card">
                                        <div class="card-body">
                                            <div class="form-group mb-2">
                                                <strong>Permission <span class="error">*</span></strong>
                                                <br />
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="check"
                                                           onClick="permissionAll(this)">
                                                    <label class="form-check-label" for="check">
                                                        All Permission
                                                    </label>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        @foreach ($permissions as $permission)
                                                            <div class="form-group ic-single-permission @if (isset($permission->parent_id))ic-child-permission parent-{{$permission->parent_id}} @else ic-parent-permission @endif"
                                                                 @if ($permission->parent_id === null)
                                                                     data-id="{{$permission->id}}"
                                                                @endif >
                                                                <label
                                                                    class="ic-permission-label @if($permission->parent_id === null) ic-parent-permission-label @endif()">
                                                                    <input @if (isset($permission->parent_id))
                                                                               class="child-permission-{{$permission->parent_id}}"@else
                                                                               class="ic-parent-check" @endif value="{{ $permission->name }}"
                                                                           name="permission[]" type="checkbox" {{
                                            in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                                                    >
                                                                    <span class="ml-1">{{ $permission->name }}</span>

                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div>
                                    <button class="btn btn-primary waves-effect waves-lightml-2 me-2" type="submit">
                                        <i class="fa fa-save"></i> Submit
                                    </button>

                                    @can('All Roles')
                                        <a class="btn btn-secondary waves-effect" href="{{ route('admin.roles.index') }}">
                                            <i class="fa fa-times"></i> Cancel
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('script')

    <script>
        $(document).ready(function() {

            // show and close group of permission
            const parentPermission = $(".ic-parent-permission");
            parentPermission.on("click", function(){
                const parentId = $(this).data('id');
                const classname =  "." +"parent-"+ parentId;
                const childPermission = $(classname);
                if (childPermission.css("display") == 'none') {
                    childPermission.css('display', 'block');
                }else{
                    childPermission.css('display', 'none');
                }
            });

            // select all group wise permission by clicking
            $(".ic-parent-permission-label").change(function(){
                const parentId = $(this).parent().data('id');
                const parentCheckBox = $(this).find('input[type=checkbox]')[0];
                const childClassName = "." + "child-permission-" + parentId;
                const childCheckBox = $(childClassName);
                if (parentCheckBox.checked ) {
                    if (childCheckBox) {
                        for (let i = 0; i < childCheckBox.length; i++) {
                            const checkBox = childCheckBox[i];
                            checkBox.checked = true;
                        }
                    }
                }else{
                    if (childCheckBox) {
                        for (let i = 0; i < childCheckBox.length; i++) {
                            const checkBox = childCheckBox[i];
                            checkBox.checked = false;
                        }
                    }
                }
            });

            // To hide if not checked anyone
            $('.ic-child-permission').css('display','none');
            $('.ic-parent-permission').each(function(){
                if($(this).children().children().prop('checked') == true)
                {
                    var p_id = $(this).attr('data-id');
                    console.log('Checked');
                    console.log(p_id);
                    $(this).parent().find('.parent-'+p_id).css('display','block');
                }
            });
        });

        // Check All
        function permissionAll(source) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source) checkboxes[i].checked = source.checked;
            }
        }

    </script>
@endpush
@push('style')
    <style>
        .ic-single-permission {
            background-color: #b7c6ec;
        }

        .shipping_address_card {
            background: #eeeeee;
        }
    </style>
@endpush
