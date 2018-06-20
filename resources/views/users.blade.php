@extends('layouts.layout')
@section('content')
<?php
use Carbon\Carbon;
/**
 * Created by PhpStorm.
 * User: DustDustin
 * Date: 20-Mar-18
 * Time: 8:36 AM
 */

    $title = "Users";
    $small = "List of users"

?>
<button type="button" data-toggle="modal" data-target="#AddEmployee" class="btn btn-success">
    <span class="fa fa-plus"></span> Add Employee
</button>
<button type="button" data-toggle="modal" data-target="#AddGuest" class="btn btn-success">
    <span class="fa fa-plus"></span> Create Guest account
</button>
    <h1 class="subtitle">Employees</h1>
    <table id="dataatable" class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Username:</th>
            <th>Email:</th>
            <th>Role:</th>
            <th>Is frozen: </th>
            <th>Actions:</th>
        </tr>
        </thead>
        <tfoot>

        </tfoot>
        <tbody>
        @forelse($users as $employee)
                <tr>
                    <td>{{$employee->username}}</td>
                    <td>{{$employee->email}}</td>
	                @if($employee->roleName != Null)
                      <td>{{ $employee->roleName}}</td>
                      @else
                        <td class="red">Unassigned</td>
                    @endif
	                @if( $employee->IsFrozen == "1")
                    <td class="red">Yes</td>
	                @else
                    <td>No</td>
	                @endif
                    <td>
                        <button type="button" data-toggle="modal"
                                data-employee="{{ $employee->username}}"
                                data-employeerole="{{ $employee->role}}"
                                data-target="#DeleteEmployee" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        <button type="button" data-toggle="modal"
                                data-userid="{{$employee->id}}"
                                data-userrole="{{$employee->role}}"
                                data-username="{{$employee->username}}"
                                data-usermail="{{$employee->email}}"

                                data-userrolename="@if($employee->roleName != Null ){{$employee->roleName}} @else <span class='red'>None</span> @endif"
                                data-target="#EditUser" class="btn btn-success"><i class="fa fa-edit"></i></button>
		                @if($employee->IsFrozen == "1")
                        <button type="button" title="Activate account"
                                data-userid="{{$employee->id}}"
                                data-userrole="{{$employee->role}}"
                                data-userstate="{{$employee->IsFrozen}}"
                                data-warn="Activate"
                                data-toggle="modal" data-target="#FreezeUser" class="btn btn-info"><i class="fa fa-play"></i></button>
		                @else
                        <button type="button" title="Deactivate account"
                                data-userid="{{ $employee->id }}"
                                data-userrole="{{$employee->role}}"
                                data-userstate="{{$employee->IsFrozen}}"
                                data-warn="Deactivate"
                                data-target="#FreezeUser" data-toggle="modal" class="btn btn-info"><i class="fa fa-pause"></i></button>
		                @endif
                    </td>
                </tr>
            @empty
            <tr>
                <td></td>
                <td></td>
                <td>ERROR!</td>
                <td>No users found</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <h1 class="subtitle">Guests</h1>
    <p> Guest accounts will automaticly being removed when expire date is reached</p>
    <table id="dataatable2" class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Username:</th>
            <th>Email:</th>
            <th>Expires at:</th>
            <th>Is frozen: </th>
            <th>Actions:</th>
        </tr>
        </thead>
        <tfoot></tfoot>
        <tbody>
        @forelse($guests as $guest)
            <tr>
                <td>{{$guest->username}}</td>
                <td>{{$guest->email}}</td>
                <td>{{$guest->ExpiresAt}}</td>
                @if( $guest->IsFrozen == "1")
                    <td class="red">Yes</td>
                @else
                    <td>No</td>
                @endif
                <td>
                    @if($guest->IsFrozen == "1")
                        <button type="button" title="Activate account"
                                data-userid="{{ $guest->id }}"
                                data-userrole="{{$guest->role}}"
                                data-userstate="{{$guest->IsFrozen}}"
                                data-warn="Activate"
                                data-toggle="modal" data-target="#FreezeUser" class="btn btn-info"><i class="fa fa-play"></i></button>
                    @else
                        <button type="button" title="Deactivate account"
                                data-userid="{{ $guest->id }}"
                                data-userrole="{{$guest->role}}"
                                data-userstate="{{$guest->IsFrozen}}"
                                data-warn="Deactivate"
                                data-target="#FreezeUser" data-toggle="modal" class="btn btn-info"><i class="fa fa-pause"></i></button>
                    @endif
                        <button type="button" data-toggle="modal"
                                data-employee="{{ $guest->username}}"
                                data-employeerole="{{ $guest->role}}"
                                data-target="#DeleteEmployee" class="btn btn-danger"><i class="fa fa-trash"></i></button>

                </td>
            </tr>
        @empty
            <tr>
                <td></td>
                <td>ERROR! No guests found</td>
            </tr>
        @endforelse
        </tbody>
    </table>


<!-- Modals (pop ups) -->

    <div class="modal fade" id="AddEmployee" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Create new employee account.</h4>
                </div>
                <form action = "/CreateEmployee" method = "post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                        <p>Please fill in the forms to register a employee account.<br> The password will be generated and mailed to the email address</p>
                        <label for="username">Username: </label>
                        <input class="form-control" type="Text" placeholder="Username" name="username" value="{{ old('username') }}"/>
                        <label for="username">Email of employee: </label>
                        <input class="form-control" type="Text" placeholder="email" name="email" value="{{ old('email') }}"/>
                        <label for="roleid">Role of employee:</label>
                        <select class="form-control" id="role" name="role">
                            <option value=" ">select role....</option>
                            @foreach($roles as $role)
                                <option value="{{$role->roleId}}">{{$role->roleName}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-kleynorange">Create acccount</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="modal fade" id="AddGuest" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Create Guest account.</h4>
                </div>
                <form action = "/CreateGuest" method = "post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                            @if(session()->has('message'))
                                <p class="alert alert-danger">{{ session()->get('message') }}</p>
                            @endif
                        <p>Please fill in the forms to register a guest account.<br> The password will be generated and mailed to the email address<br>
                            <br>
                            The system is schedueled every night at 1AM to clear expired accounts</p></p>
                        <label for="username">Username: </label>
                        <input class="form-control" type="Text" placeholder="Username" name="username"/>
                        <label for="email">Email of guest: </label>
                        <input class="form-control" type="Text" placeholder="email" name="email"/>
                        <label for="expires">Date of expire: </label>
                        <input class="form-control" type="date" placeholder="Date of expire" min="{{Carbon::tomorrow()->toDateString()}}" name="expiresAt"/>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-kleynorange">Create acccount</button>
                    </div>
                </form>

         </div>
      </div>
    </div>

    <div class="modal fade" id="EditUser" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit User.</h4>
                </div>
                <form action = "/EditUser" method = "post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <input type="hidden" name="userid" id="userid" value=""/>
                    <input type="hidden" name="currentuserrole" id="userrole1" value=""/>
                    <div class="modal-body">
                        <p>You are now editing <span id="usernametxt"></span>.</p>
                        <p>Users role : <span id="rolename1"></span></p>
                        <label for="username">Usename:</label>
                        <input type="Text" class="form-control" id="username" name="username" value="{{ old('username') }}"/>
                        <label for="usermail">Email of User:</label>
                        <input type="Text" class="form-control" id="usermail" name="email" value="{{ old('email') }}"/>
                        <label for="roleid">Role of User</label>
                        <select class="form-control" id="roleid" name="roleid">
                            <option id="userrole2"></option>
                            @foreach($roles as $role)
                                <option value="{{$role->roleId}}">{{$role->roleName}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-kleynorange">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div class="modal fade" id="FreezeUser" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i id="warn1"></i> user.</h4>
                </div>
                <form action = "/FreezeUser" method = "post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <input type="hidden" name="userid" id="userid1" value=""/>
                    <input type="hidden" name="userstate" id="userstate" value=""/>
                    <input type="hidden" name="userrole" id="userrole" value=""/>

                    <div class="modal-body">
                        <p> Are you sure you want <span id="warn2"></span> to this user?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-danger">No! Don't <span id="warn3"></span> this user.</button>
                        <button type="submit" class="btn btn-success">Yes! <span id="warn4"></span> this user.</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div class="modal fade" id="DeleteEmployee" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete User.</h4>
                </div>
                <form action = "/DeleteEmployee" method = "post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="modal-body">
                        <p>Are you sure you want to delete <span style="font-weight: bold;" id="EmployeeTxt"></span>?</p>
                        <input id="employee" type="hidden" name="username" value="" readonly/>
                        <input id="employeerole" type="hidden" name="userrole" value="" readonly/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-danger">No! Don't delete this user.</button>
                        <button type="submit" class="btn btn-success">Yes! Delete this user.</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
<?php $error_code = session()->get('error_code');?>


@endsection
