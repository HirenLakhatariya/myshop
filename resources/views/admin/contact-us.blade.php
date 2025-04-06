@extends('layout.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Contact Us Submissions</h2>
    <div class="card shadow p-3 mb-5 bg-white rounded">
        <div class="table-responsive">
            <table class="table table-hover table-striped text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}" class="text-white text-decoration-none">ID</a></th>
                        <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}" class="text-white text-decoration-none">Name</a></th>
                        <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}" class="text-white text-decoration-none">Email</a></th>
                        <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'contact_number', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}" class="text-white text-decoration-none">Contact Number</a></th>
                        <th>Message</th>
                        <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}" class="text-white text-decoration-none">Submitted At</a></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ContactUsInfo as $info)
                    <tr>
                        <td>{{ $info->id }}</td>
                        <td>{{ $info->name }}</td>
                        <td><a href="mailto:{{ $info->email }}" class="text-decoration-none">{{ $info->email }}</a></td>
                        <td>{{ $info->contact_number }}</td>
                        <td class="text-wrap" style="max-width: 250px;">{{ $info->message }}</td>
                        <td>{{ \Carbon\Carbon::parse($info->created_at)->format('d-m-Y H:i:s') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $ContactUsInfo->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection