@extends('layouts.app', ['title' => 'Housekeepers'])

@section('content')
<section class="section-head">
    <h2>Housekeepers</h2>
</section>

<section class="form-card">
    <h3>Add Housekeeper</h3>
    <form method="POST" action="{{ route('housekeepers.store') }}" class="grid-form">
        @csrf
        <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
        <input type="text" name="phone" placeholder="Phone" value="{{ old('phone') }}">
        <select name="shift" required>
            <option value="Morning">Morning</option>
            <option value="Afternoon">Afternoon</option>
            <option value="Night">Night</option>
        </select>
        <label class="switch-row">
            <input type="checkbox" name="is_active" value="1" checked>
            <span>Active</span>
        </label>
        <button type="submit" class="btn-primary">Save Staff</button>
    </form>
</section>

<section class="table-card">
    <div class="table-wrap">
        <table>
            <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Shift</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($housekeepers as $housekeeper)
                <tr>
                    <td data-label="Name">{{ $housekeeper->name }}</td>
                    <td data-label="Phone">{{ $housekeeper->phone ?: '-' }}</td>
                    <td data-label="Shift">{{ $housekeeper->shift }}</td>
                    <td data-label="Status"><span class="pill {{ $housekeeper->is_active ? 'done' : 'dirty' }}">{{ $housekeeper->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td class="actions" data-label="Actions">
                        <a class="btn-ghost" href="{{ route('housekeepers.edit', $housekeeper) }}">Edit</a>
                        <form method="POST" action="{{ route('housekeepers.destroy', $housekeeper) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No staff yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $housekeepers->links('pagination.custom') }}
</section>
@endsection
