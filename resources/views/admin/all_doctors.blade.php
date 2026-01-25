@extends('layout.index')

@section('content')

<h4>All Doctors</h4>

<table class="table table-bordered table-striped mt-3">
<thead>
    <tr>
        <th>#</th>
         <th>Name</th>
          <th>Username</th>
          <th>email</th>
           <th>speciality</th>
            <th>Action</th>
    </tr>
</thead>

<tbody>

    @forelse ($doctors as $doctor)
    <tr>
         <td>{{$doctor->id}}</td>
          <td>{{$doctor->user->first_name}}
            {{$doctor->user->last_name}}
          </td>

          <td>{{$doctor->user->username}}</td>
           <td>{{$doctor->user->email}}</td>
          <td>{{$doctor->speciality}}</td>
           <td>
            <a href="{{ route('view_doctor',$doctor->id) }}">View</a>
             <a href="{{ route('edit_doctor',$doctor->id) }}">Edit</a>

             <form action="{{ route('admin.doctor.destroy',$doctor->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
             </form>
           </td>
    </tr>

    @empty
    <tr>
        <td>No available Doctors</td>
    </tr>

    @endforelse

</tbody>
</table>

@endsection
