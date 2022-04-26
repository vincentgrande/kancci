@extends('layouts.template')

@section('title', 'Archive')
@section('actions')
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('kanban', ['id'=>$kanban]) }}">
            <i class="fas fa-arrow-alt-circle-left"></i>
            <span>Back</span></a>
    </li>
    <hr class="sidebar-divider">
@endsection
@section('content')
    <label for="cards" class="text-light">Cards :</label>
    <div id="cards" class="mb-3 col text-light"></div><br><br><br><br>
    <label for="boards" class="text-light">Boards :</label>
    <div id="boards" class="mb-3 col text-light"></div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function(e) {
            actualBackground();
        })
        /**
         * Set archive page background image
         */
        let actualBackground = function() {
            let div = document.getElementById('content');
            if(div !== null)
            {
                div.style.backgroundImage = "url('/img{{ $background }}')";
            }
        }
        /**
         * Function to unarchive a board
         */
        let unarchiveBoard = function(id){
            $.ajax({
                url: "{{ route('unarchiveBoard') }}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function (result) {

                    getArchived()
                }
            })
        }
        /**
         * Function to unarchive a card
         */
        let unarchiveCard = function(id){
            $.ajax({
                url: "{{ route('unarchiveCard') }}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function (result) {

                    getArchived()
                }
            })
        }
        /**
         * Function to get archived items from a specific kanban
         */
      let getArchived = function(){
          $.ajax({ // Ajax to save kanban in DB.
              url: "{{ route('getArchived') }}",
              method: 'get',
              data: {
                  "_token": "{{ csrf_token() }}",
                  kanban_id: {{ $kanban }}
              },
              success: function(result) {
                  $('#boards').empty()
                  $('#cards').empty()
                    result.boards.map( x => {
                            $('#boards').append(`
<li class="mb-2">`+x.title+` <button class="btn btn-success btn-sm " onclick='unarchiveBoard(`+x.id+`)'><i class="fas fa-check"></i></button></li>
`)
                    })
                  result.cards.map( x => {
                      for (const [key, value] of Object.entries(x)) {
                          $('#cards').append(`
<li class="mb-2">`+x[key].title+` <button class="btn btn-success btn-sm " onclick='unarchiveCard(`+x[key].id+`)'><i class="fas fa-check"></i></button></li>
`)
                      }
                  })
              }
          });
      }
      getArchived()
    </script>

@endsection
