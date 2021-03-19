@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="grix xs1 sm3 container">
        <div class="col-sm1 mx-auto my-auto">
            <a href="{{ route('users.create') }}" class="btn rounded-1 orange dark-1 txt-white">Ajouter</a>
        </div>
        <div class="col-sm2">
            <form class="form-material" method="GET" action="searchUser">
                @csrf
                <div class="grix xs5">
                    <div class="form-field pos-xs1 col-xs4">
                        <input type="text" name="searchUser" id="searchUser" class="form-control" />
                        <label for="searchUser">Rechercher</label>
                    </div>
                    <button type="submit" class="btn circle orange txt-white search-icon vself-center rounded-4"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <div class="container mt-5 shadow-1 rounded-2">
        <div class="responsive-table rounded-2">
            <table class="table striped ">
                <thead>
                    <tr>
                        <th class="txt-center">#</th>
                        <th class="txt-center">Name</th>
                        <th class="txt-center">Email</th>
                        <th class="txt-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="txt-center <?php echo('role' . $user->is_admin) ?>">{{ $user->id }}</td>
                        <td class="txt-center">{{ $user->name }}</td>
                        <td class="txt-center">{{ $user->email }}</td>
                        <td>
                            <div class="grix xs2 gutter-xs2">
                                <div class="ml-auto">
                                    <a class="btn circle blue dark-1 txt-white push" href="{{route('users.edit', ['user' => $user->id])}}"><i class="fas fa-pen"></i></a>
                                </div>
                                <div>
                                    <form method="POST" action="{{route('users.destroy', ['user' => $user->id])}}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" onclick="return confirm('Confirmer la suppression ?')" class="btn circle red dark-1 txt-white push"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection