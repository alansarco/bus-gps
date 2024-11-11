@extends('back.layout.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Home')

@section('content')
    <div class="container">

        <!-- Search Bar with Date Filter -->
        <form method="GET" action="{{ route('admin.home') }}" class="mb-4 bg-secondary-200 p-2">
            <div class="row">
                <div class="col-md-4 d-flex">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by Name or Location" value="{{ request()->get('search') }}">
                </div>
                <div class="col-md-3 d-flex">
                    <label for="date" class="form-label text-nowrap my-auto mr-2">Select Date</label>
                    <input type="date" name="start_date" class="form-control form-control-sm" value="{{ request()->get('start_date') }}">
                </div>
                <div class="col-md-3 d-flex">
                    <label for="date" class="form-label text-nowrap my-auto mr-2">Select Date</label>
                    <input type="date" name="end_date" class="form-control form-control-sm" value="{{ request()->get('end_date') }}">
                </div>
                <div class="col-md-2 d-flex">
                    <button class="btn btn-primary my-auto w-100" type="submit">Search</button>
                </div>
            </div>
        </form>

        <!-- Table Displaying Data -->
        <table class="table table-striped table-hover">
            <thead class="bg-dark text-white">
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>LATITUDE</th>
                    <th>LONGITUDE</th>
                    <th>TIME</th>
                    <th>DATE</th>
                    <th class="text-center">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $dat)
                <tr>
                    <td class="pl-3">{{ $loop->iteration + (($data->currentPage() - 1) * $data->perPage()) }}</td>
                    <td class="pl-3">{{ $dat->name }}</td>
                    <td class="pl-3">{{ $dat->latitude }}</td>
                    <td class="pl-3">{{ $dat->longitude }}</td>
                    <td class="pl-3">{{ $dat->formatted_time }}</td>
                    <td class="pl-3">{{ $dat->formatted_date }}</td>
                    <td class="text-center pl-3">
                        <a href="{{ route('admin.show', Crypt::encrypt($dat->id)) }}" class="btn btn-sm btn-success rounded-pill">
                            <i class="micon fa fa-search"></i> View Map
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>    

        <!-- Custom Bootstrap 5 Pagination -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                @if ($data->onFirstPage())
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $data->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                @endif

                @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                    <li class="page-item {{ ($data->currentPage() == $page) ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                @if ($data->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $data->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endsection
