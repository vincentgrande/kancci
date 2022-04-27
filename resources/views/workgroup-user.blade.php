@extends('layouts.template')

@section('title', 'Workgroup Infos')
@section('actions')
    <li class="nav-item active">
        <a class="nav-link" href="{{route('workgroup', $workgroup->id)}}">
            <i class="fas fa-arrow-left"></i>
            <span>Back to WorkGroup</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item active" id="manageWorkgroup">
        <a class="nav-link" href="{{route('WorkgroupInfosGet', $workgroup->id)}}">
            <i class="fas fa-cog"></i>
            <span>Manage Informations</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item active" id="manageWorkgroup">
        <a class="nav-link" href="{{route('usersManagement', $workgroup->id)}}">
            <i class="fas fa-user-cog"></i>
            <span>Manage Users</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
@endsection
@section('content')
    <div id="invitedUsers" class="justify-content-center mx-auto">
        <?php
        foreach ($workgroup_users as $user)
            {
                if($workgroup->created_by != $user->user->id)
                {
                ?>
                    <div class="row mx-auto form-group justify-content-center mx-auto">
                        <input class="form-control" type="text" id="user" name="user" value="<?php echo $user->user->email;?>" readonly="readonly"/>
                        <select id="role" name="role" class="form-control" onchange="ChangeRole($('#user').val(), $('#role').val())">
                            <?php if($user->isAdmin)
                                {?>
                            <option value="1" selected="selected">Admin</option>
                            <option value="0">User</option>
                            <?php
                                }
                                else
                                {
                            ?>
                                <option value="1">Admin</option>
                                <option value="0" selected="selected">User</option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
        <?php
                }
            }
        ?>
    </div>
@endsection
@section('scripts')
    <script>
        /**
         * Function to change ChangeRole of a user
         * @param email
         * @param value
         */
        function ChangeRole(email, value)
        {
            $.ajax({
                url: "{{ route('changeRole') }}",
                method: 'get',
                data: {
                    "email": email,
                    "value": value,
                    "workgroup_id": {{$workgroup->id}},
                },
                success: function (result) {

                }
            });
        }
    </script>
@endsection
