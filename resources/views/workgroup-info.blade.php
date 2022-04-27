@extends('layouts.template')

@section('title', 'Workgroup Infos')
@section('actions')
    <li class="nav-item active">
        <a class="nav-link" href="{{route('workgroup', $workgroup[0]->id)}}">
            <i class="fas fa-arrow-left"></i>
            <span>Back to WorkGroup</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item active" id="manageWorkgroup">
        <a class="nav-link" href="{{route('WorkgroupInfosGet', $workgroup[0]->id)}}">
            <i class="fas fa-cog"></i>
            <span>Manage Informations</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item active" id="manageWorkgroup">
        <a class="nav-link" href="{{route('usersManagement', $workgroup[0]->id)}}">
            <i class="fas fa-user-cog"></i>
            <span>Manage Users</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
@endsection
@section('content')
    <div id="infos" class="justify-content-center mx-auto">
        <form class="form-group" action="{{route('WorkgroupInfoPost', ['id' => $workgroup[0]->id])}}" method="post">
            @csrf
            <div class="row">
                <label class="mx-auto" for="title">Title</label>
            </div>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-ad fa-fw" id="iconTitle"></i></span>
                </div>
                <input class="form-control" type="text" id="title" name="title" placeholder="{{$workgroup[0]->title}}" required="required"/>
            </div>
            <input class="form-control mb-2" type="submit" value="Update"/>
        </form>
        <div class="mb-2" style="width: 100%; border-top: 1px solid #8c8b8b;"></div>
        <div class="row">
            <label class="mx-auto" for="title">Invited Users</label>
        </div>
        <div class="form-group">
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-at fa-fw" id="iconmail"></i></span>
                </div>
                <input class="form-control" id="emailToInvite" name="emailToInvite" type="email" placeholder="Enter an email..."/>
            </div>
            <input class="form-control mb-1" type="button" onclick="AddInput()" value="Ajouter"/>
            <div id="invitedUser" class="form-group">
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>

        let count = 0;
        $(document).ready(function() {
            getInvitedUsers()
        });

        /**
         * Add all invited users input
         */
        function getInvitedUsers(){
            let invited_users = <?php echo $invited_users; ?>;
            let pending_invitation = <?php echo $pending_invitation; ?>;
            invited_users.forEach(x => {
                if(x.user.id !== {{ $workgroup[0]->created_by }}) {
                    AddInputForInvited(x.user.email);
                }
            });
            pending_invitation.forEach(x => {
                AddInputForInvited(x.email);
            });
        }

        /**
         * Add Inputs for a specifique Email
         * @param user
         */
        function AddInputForInvited(user)
        {
            const input = user;
            let success = true;
            if(count !== 0) {
                let i = 0;
                while(i <= count) {
                    let inputValue = document.getElementById("newInput" + i);
                    if(inputValue != null) {
                        if (inputValue.value === input) {
                            success = false;
                        }
                    }
                    i++;
                }
            }
            if(success)
            {
                count++;
                const div = document.getElementById('invitedUser');
                const newDivInputGroup = document.createElement('div');
                const newDivInputGroupAppend = document.createElement('div');
                const newSpan = document.createElement('span');
                const newA = document.createElement('a');
                const newI = document.createElement('i');
                const newHiddenInput = document.createElement('input');
                const newInput = document.createElement('input');
                // Hidden Input
                newHiddenInput.type = "hidden";
                newHiddenInput.value = count;

                // Div 1
                newDivInputGroup.className = "input-group  mb-1";
                newDivInputGroup.id = 'newDivInputGroup' + count;

                div.appendChild(newDivInputGroup);

                // Input
                newInput.className = "form-control";
                newInput.type = "email";
                newInput.id = 'newInput' + count;
                newInput.name = "invitedEmail";
                newInput.placeholder = "Enter the email to be invited...";
                newInput.value = input;
                newDivInputGroup.appendChild(newInput);


                newDivInputGroup.appendChild(newHiddenInput);

                // Div 2
                newDivInputGroupAppend.className = "input-group-append";
                newDivInputGroupAppend.id = 'newDivInputGroupAppend' + count;
                newDivInputGroup.appendChild(newDivInputGroupAppend);

                // Span
                newSpan.className = "input-group-text";
                newSpan.id = 'newSpan' + count;
                newDivInputGroupAppend.appendChild(newSpan);

                // a
                newA.onclick = function () {
                    RemoveInputs(newHiddenInput.value);
                };
                newA.id = "newA" + count;
                newA.href = "#";
                newSpan.appendChild(newA);

                // i
                newI.className = "fa fa-times fa-fw";
                newI.id = "newI" + count;
                newA.appendChild(newI);
            }
            else
            {
                alert("Cet e-mail a déjà été saisie !");
            }
        }

        /**
         * Remove the invited User from Workgroup
         * @param number
         */
        function RemoveInputs(number)
        {
            const newInput = document.getElementById('newInput' + number);
            $.ajax({
                url: "{{ route('deleteInvitedUser') }}",
                method: 'get',
                data: {
                    "email" :  newInput.value,
                    "workgroup_id" : {{ $workgroup[0]->id }},
                },
                success: function(result) {
                    if(result === "true")
                    {
                        const newDivInputGroup = document.getElementById('newDivInputGroup' + number);
                        const newDivInputGroupAppend = document.getElementById('newDivInputGroupAppend' + number);
                        const newSpan = document.getElementById('newSpan' + number);
                        const newA = document.getElementById('newA' + number);
                        const newI = document.getElementById('newI' + number);
                        newI.remove();
                        newA.remove();
                        newSpan.remove();
                        newDivInputGroupAppend.remove();
                        newInput.remove();
                        newDivInputGroup.remove();
                    }
                    else
                    {
                        alert(result);
                    }
                }
                });
        }

        /**
         * Add the User to the Workgroup
         */
        function AddInput()
        {
            const input = document.getElementById('emailToInvite');
            $.ajax({
                url: "{{ route('inviteUser') }}",
                method: 'get',
                data: {
                    "email" :  input.value,
                    "workgroup_id" : {{ $workgroup[0]->id }},
                },
                success: function(result) {
                    if(result === "true")
                    {
                        if(input.value.includes('@')) {
                            let success = true;
                            if(count !== 0) {
                                let i = 0;
                                while(i <= count) {
                                    let inputValue = document.getElementById("newInput" + i);
                                    if(inputValue != null) {
                                        if (inputValue.value === input.value) {
                                            success = false;
                                        }
                                    }
                                    i++;
                                }
                            }
                            if(success)
                            {
                                count++;
                                const div = document.getElementById('invitedUser');
                                const newDivInputGroup = document.createElement('div');
                                const newDivInputGroupAppend = document.createElement('div');
                                const newSpan = document.createElement('span');
                                const newA = document.createElement('a');
                                const newI = document.createElement('i');
                                const newHiddenInput = document.createElement('input');
                                const newInput = document.createElement('input');
                                // Hidden Input
                                newHiddenInput.type = "hidden";
                                newHiddenInput.value = count;

                                // Div 1
                                newDivInputGroup.className = "input-group  mb-1";
                                newDivInputGroup.id = 'newDivInputGroup' + count;

                                div.appendChild(newDivInputGroup);

                                // Input
                                newInput.className = "form-control";
                                newInput.type = "email";
                                newInput.id = 'newInput' + count;
                                newInput.name = "invitedEmail";
                                newInput.placeholder = "Enter the email to be invited...";
                                newInput.value = input.value;
                                input.value = "";
                                newDivInputGroup.appendChild(newInput);


                                newDivInputGroup.appendChild(newHiddenInput);

                                // Div 2
                                newDivInputGroupAppend.className = "input-group-append";
                                newDivInputGroupAppend.id = 'newDivInputGroupAppend' + count;
                                newDivInputGroup.appendChild(newDivInputGroupAppend);

                                // Span
                                newSpan.className = "input-group-text";
                                newSpan.id = 'newSpan' + count;
                                newDivInputGroupAppend.appendChild(newSpan);

                                // a
                                newA.onclick = function () {
                                    RemoveInputs(newHiddenInput.value);
                                };
                                newA.id = "newA" + count;
                                newA.href = "#";
                                newSpan.appendChild(newA);

                                // i
                                newI.className = "fa fa-times fa-fw";
                                newI.id = "newI" + count;
                                newA.appendChild(newI);
                            }
                            else
                            {
                                alert("Cet e-mail a déjà été saisie !");
                            }
                        }
                        else {
                            alert("Vous devez saisir une adresse e-mail");
                        }
                    }
                    else{
                        alert("an Error occured" + result);
                    }
                }
                });

        }
    </script>
@endsection
