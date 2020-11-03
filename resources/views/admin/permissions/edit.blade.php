<x-admin-master>
    @section('content')

    @if(session()->has('permission-updated'))
        <div class="alert alert-success">
            {{session('permission-updated')}}
        </div>
    @endif

        <h1>Edit Role: {{$permission->name}}</h1>
        <div class="col-sm-6">
            <form method="post" action="{{route('permissions.update', $permission->id)}}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{$permission->name}}">
                </div>

                <button class="btn btn-primary">Update</button>

            </form>
        </div>

        @endsection
</x-admin-master>
