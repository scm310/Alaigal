@extends('admin_layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Import Client Requirements</h2>
    <div class="card">
        <div class="card-body">
            <form id="import-form" method="POST" enctype="multipart/form-data" action="{{ route('import.requirements') }}">
                @csrf
                <div class="form-group">
                    <label for="file">Upload Requirement Excel</label>
                    <input type="file" name="file" class="form-control" accept=".xlsx, .xls, .csv" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Import</button>
            </form>
        </div>
    </div>
    <div id="results-container" class="mt-5">
        <!-- Comparison results will be dynamically loaded here -->
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('import-form');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                });

                const result = await response.text();
                document.getElementById('results-container').innerHTML = result;
            } catch (err) {
                alert('Error: ' + err.message);
            }
        });
    });
</script>
@endsection
