@extends('admin.layout.sidenavbar')

@section('content')
<!-- Custom Styling -->
<style>
    /* Header */
    .header {
        background: linear-gradient(-225deg, #7DE2FC 0%, #B9B6E5 100%);
        color: black;
        padding: 15px;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    /* Reduce font size for table headers and content */
    #complaintTable th,
    #complaintTable td {
        font-size: 12px;
        white-space: normal;
        word-wrap: break-word;
    }

    /* Ensure headers wrap text instead of stretching */
    #complaintTable th {
        max-width: 120px;
        overflow-wrap: break-word;
        text-align: center;
    }

    @media (max-width: 500px) {
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            display: none;
        }

        .table td {
            max-width: 150px;
            white-space: normal !important;
            overflow: hidden;
            text-overflow: ellipsis;
            word-wrap: break-word;
        }
    }

    .table {
        background-color: white !important;
        /* Ensure table is white */
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #ddd !important;
        /* Soft gray border */
    }

    .table thead {
        background-color: #ffffff !important;
        /* Dark header */
        color: rgb(0, 0, 0) !important;
    }

</style>

<div class="container-wrapper mt-5">
    <!-- Header -->
    <div class="header">This Week's References</div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered dt-responsive nowrap" id="complaintTable" style="width: 100%;">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Date</th>
                    <th>Reference By</th>
                    <th>Company Name </th>
                    <th>Reference To</th>
                    <th>Company Name </th>
                    <th>Reference Amount</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data) && $data->count())
                    @foreach($data as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->date)->format('d-m-Y') }}</td>
                            <td>{{ $row->reference_by_name }}</td>
                            <td>{{ $row->reference_by_company }}</td>
                            <td>{{ $row->reference_to_name }}</td>
                            <td>{{ $row->reference_to_company }}</td>
                            <td>₹ {{ number_format($row->amount, 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center">No references found for this week.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#complaintTable').DataTable({
            responsive: {
                details: {
                    type: 'column',
                    target: -1
                }
            },
            columnDefs: [{
                className: 'control',
                orderable: false,
                targets: -1
            }],
            paging: true,
            pageLength: 10,
            language: {
                lengthMenu: "Show MENU entries",
                emptyTable: "No rejected members found."
            }
        });
    });
</script>
@endsection
