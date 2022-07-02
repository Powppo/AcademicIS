@extends('student.layout')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left mt-2">
            <h2>INFORMATION TECHNOLOGY-STATE POLYTECHNIC OF MALANG</h2>
        </div>

        <div class="row justify-content-center mb-3 mt-3">
            <div class="col-md-6">
                <form action="">
                    <div class="input-group my-3">
                        <input type="text" class="form-control" placeholder="Search" name="search" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <div class="float-right my-3">
                    <a href="{{ route('student.create') }}" class="btn btn-success">Input Student Data</a>
                </div>
            </div>
        </div>
    </div>
</div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>Nim</th>
            <th>Name</th>
            <th>Class</th>
            <th>Major</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($paginate as $mhs)
        <tr>

            <td>{{ $mhs ->nim }}</td>
            <td>{{ $mhs ->name }}</td>
            <td>{{ $mhs ->class->class_name }}</td>
            <td>{{ $mhs ->major }}</td>
            <td>
            <form action="{{ route('student.destroy',['student'=>$mhs->nim]) }}" method="POST">

                <a class="btn btn-info" href="{{ route('student.show',$mhs->nim) }}">Show</a>

                <a class="btn btn-primary" href="{{ route('student.edit',$mhs->nim) }}">Edit</a>
            
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            </td>
        </tr>
        @endforeach
    </table>
@endsection