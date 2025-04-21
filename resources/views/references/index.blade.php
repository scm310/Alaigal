@extends('memberlayout.navbar')

@section('content')
<style>
    /* Ensuring that the tab header stays on top */
    .card-body {
        position: relative;
    }

    /* Make sure the tabs are visible and above the content */
    .nav-tabs {
        z-index: 10;
        position: relative;
    }

    /* Content below the tabs */
    .tab-content {
        z-index: 1;
    }

    .card-header-tabs .nav-link {
        margin-bottom: -1px;
    }

    /* Optional: Avoid overlap and padding between tabs */
    .nav-tabs .nav-item {
        padding: 0 5px;
    }

    /* Force display to troubleshoot */
    #referenceTabs {
        display: block !important;
    }

    .nav-tabs {
        display: flex !important;
    }

    .nav-link {
        visibility: visible !important;
        opacity: 1 !important;
    }

    .tab-pane {
        display: block !important;
        visibility: visible !important;
    }

    /* Optional: Ensure the included content is in a separate container */
    .tab-content-container {
        position: relative;
        z-index: 5; /* Ensure it's above the content but below the tabs */
    }
</style>

<div class="container mt-4">
    <div class="card shadow rounded">
        <div class="card-body">
            <!-- Tabs -->
            <ul class="nav nav-tabs" id="referenceTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="given-tab" data-toggle="tab" href="#given" role="tab"
                       aria-controls="given" aria-selected="true">
                        Reference Given
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="received-tab" data-toggle="tab" href="#received" role="tab"
                       aria-controls="received" aria-selected="false">
                        Reference Received
                    </a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content pt-4" id="referenceTabsContent">
                <!-- Reference Given Tab -->
                <div class="tab-pane fade show active" id="given" role="tabpanel" aria-labelledby="given-tab">
                    <div class="tab-content-container">
                        @include('references.report', ['references' => $givenReferences])
                    </div>
                </div>

                <!-- Reference Received Tab -->
                <div class="tab-pane fade" id="received" role="tabpanel" aria-labelledby="received-tab">
                    <div class="tab-content-container">
                        @include('references.received', ['receivedReferences' => $receivedReferences])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Ensure jQuery and Bootstrap JS are included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        // Ensure tabs function properly
        $('#referenceTabs a[data-toggle="tab"]').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>
@endsection
