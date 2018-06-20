@extends('layouts.layout')
@section('content')
<?php
/**
 * Created by PhpStorm.
 * User: DustDustin
 * Date: 31-Mar-18
 * Time: 8:15 PM
 */
use App\Users;
use App\Guests;
$title = "Roles";
$small = "List of roles"
?>
@if(session()->has('message'))
    <p class="alert alert-info">{{ session()->get('message') }}</p>
@endif
<p>Roles without a delete button are default roles! If you try to delete those roles you might break the app.</p>
<button type="button" data-toggle="modal" data-target="#AddRole" class="btn btn-success">
    <span class="fa fa-plus"></span> Create new role
</button>
<table id="dataatable" class="table table-striped table-hover">
    <thead>
        <tr>
            <th>role:</th>
            <th>Members count:</th>
            <th>Actions:</th>
        </tr>
    </thead>
    <tfoot>

    </tfoot>
    <tbody>
        @forelse ($roles as $role)
        <tr>
            <td>{{$role->roleName}}</td>
            <?php $counts = users::where('role', $role->roleId)->get(); $counted = count($counts); $countsguest = Guests::where('role', $role->roleId)->get(); $countedguests = count($countsguest);?>
            <td>@if($role->roleId != 5){{$counted}}@else {{$countedguests}} @endif</td>
            <td>
                <button title="Change role permissions" type="button" data-toggle="modal" data-target="#RoleEdit" data-rolename="{{$role->roleName}}" data-rolenumber="{{$role->roleId}}" class="btn btn-success"><i class="fa fa-edit"></i></button>
                 @if($role->IsDefault == 0)
                     <button title="Delete role" type="button" data-counted="@if($counted != 0)This roles haves <span class='red'> {{$counted}} member(s)</span> in it. @endif" data-toggle="modal" data-roleid="{{$role->roleId}}" data-target="#DeleteRole" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td></td>
            <td>Error No roles Found</td>
        </tr>
	@endforelse
    </tbody>
</table>

    <!-- Modals -->
<div class="modal fade" id="AddRole" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create new  role.</h4>
            </div>
            <form action = "/AddRole" method = "post">
                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </div>
                    @endif
                    <label for="roleName">Role name:</label>
                    <input type="text" name="roleName" value="{{ old('roleName') }}"/>
                    <input type="hidden" name="IsAdmin" value="0" /><br>
                    <input type="checkbox" name="IsAdmin" value="1">Administrator role<br>

                        <h4>Permissions</h4>
                        <input type="hidden" name="AllowEditLocation" value="0" />
                        <input type="checkbox" name="AllowEditLocation" value="1">Allow add / edit location<br>

                        <input type="hidden" name="AllowEditSalesman" value="0" />
                        <input type="checkbox" name="AllowEditSalesman" value="1">Allow add / edit salesman<br>


                        <input type="hidden" name="AllowEditBuyer" value="0" />
                        <input type="checkbox" name="AllowEditBuyer" value="1">Allow add / edit buyer<br>

                        <input type="hidden" name="AllowEditVideo" value="0" />
                        <input type="checkbox" name="AllowEditVideo" value="1"> Allow add / edit video<br>

                        <input type="hidden" name="AllowEditPhotos" value="0" />
                        <input type="checkbox" name="AllowEditPhotos" value="1"> Allow add / edit photos<br>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-kleynorange">Create new role</button>
                </div>
            </form>
        </div>

    </div>
</div>
<div class="modal fade" id="DeleteRole" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Role.</h4>
            </div>
            <form action = "/DeleteRole" method = "post">
                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                <input type="hidden" name="roleid"  id="roleid" value="">
                <div class="modal-body">
                    <p>Are you sure you want to delete this role?
                        <br><span id="counter"></span> </p>
                    <p>Deleting this role will block the users from logging in the app!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-danger">No! Don't delete this role.</button>
                    <button type="submit" class="btn btn-success">Yes! Delete this role.</button>
                </div>
         </form>
        </div>

    </div>
</div>
<div class="modal fade" id="RoleEdit" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit role Permissions.</h4>
            </div>
            <form action = "/EditRole" method = "post">
                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                <input type="hidden" name="roleName" id="rolenameEdit">
                <input type="hidden" name="roleid" id="roleidEdit">
                <div class="modal-body">
                    <p>Modal for editting role permissions!<br> make sure you reselect the permissions before saving!</p>
                    <input type="hidden" name="IsAdmin" value="0" /><br>
                    <input type="checkbox" name="IsAdmin" value="1">Administrator role<br>

                    <h4>Permissions</h4>
                    <input type="hidden" name="AllowEditLocation" value="0" />
                    <input type="checkbox" name="AllowEditLocation" value="1">Allow add / edit location<br>

                    <input type="hidden" name="AllowEditSalesman" value="0" />
                    <input type="checkbox" name="AllowEditSalesman" value="1">Allow add / edit salesman<br>


                    <input type="hidden" name="AllowEditBuyer" value="0" />
                    <input type="checkbox" name="AllowEditBuyer" value="1">Allow add / edit buyer<br>

                    <input type="hidden" name="AllowEditVideo" value="0" />
                    <input type="checkbox" name="AllowEditVideo" value="1"> Allow add / edit video<br>

                    <input type="hidden" name="AllowEditPhotos" value="0" />
                    <input type="checkbox" name="AllowEditPhotos" value="1"> Allow add / edit photos<br>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-kleynorange">Save Changes</button>
                </div>
            </form>
        </div>

    </div>
</div>
<?php $error_code = session()->get('error_code');?>
@endsection
