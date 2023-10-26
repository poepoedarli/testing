@extends('developer.index')

@section('developer-content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <form class="form-inline">
                    <label for="dropdown1" class="mr-sm-2">Application : </label>
                    <select class="form-control mb-2 mr-sm-2" id="dropdown1">
                        @foreach($data as $value)
                            <option>{{$value['service']['name'].$value['version']}}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="col-sm-6">
                <form class="form-inline">
                    <label for="dropdown2" class="mr-sm-2">scene :</label>
                    <select class="form-control mb-2 mr-sm-2" id="dropdown2">
                        <option>start</option>
                        <option>stop</option>
                    </select>
                </form>
            </div>
        </div>

        <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter " id="role-dtable">
            <thead>
            <tr>
                <th>test case</th>
                <th>test step pass rate</th>
                <th>state</th>
                <th>remaining link test time</th>
                <th>action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection