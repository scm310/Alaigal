<style>
.modal-backdrop {
    background-color: transparent !important;
}
</style>

<!-- Modal Structure -->
<div class="modal fade" id="highlightModal" tabindex="-1" role="dialog" aria-labelledby="highlightModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="highlightModalLabel">Highlight Product</h5>
                    <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
                    <!--    <span aria-hidden="true">&times;</span>-->
                    <!--</button>-->
                </div>
                <div class="modal-body">
                    <!-- Hidden input field to store the product ID -->
                    <input type="hidden" name="product_id" id="product-id">

                    <!-- Display the product name dynamically -->
                    <p>Manage product highlights:</p>
                    <h4 id="highlight-product-name"></h4> <!-- Product name display -->

                    <div class="form-group">
                        <!-- Switches -->
                        @foreach($highlights as $highlight)
    <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input highlight-checkbox"
               id="highlight-{{ Str::slug($highlight->name) }}"
               name="highlights[]" value="{{ $highlight->id }}">
        <label class="custom-control-label" for="highlight-{{ Str::slug($highlight->name) }}">
            {{ $highlight->name }}
        </label>
    </div>
@endforeach

                    </div>

                </div>
                <div class="modal-footer">
    <button type="button"
        class="btn btn-secondary"
        style="background-color: #853ede; color: white !important; border-color: #853ede !important;"
        onmouseover="this.style.setProperty('background-color', '#8a8d93', 'important'); this.style.setProperty('color', 'white', 'important'); this.style.setProperty('border-color', '#853ede', 'important');"
        onmouseout="this.style.setProperty('background-color', '#853ede', 'important'); this.style.setProperty('color', 'white', 'important'); this.style.setProperty('border-color', '#853ede', 'important');"
        data-dismiss="modal">
        Close
    </button>
</div>

            </form>
        </div>
    </div>
</div>


<script>
   $('#highlightModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var productId = button.data('product-id'); // Extract product ID

    // AJAX request to get product data
    $.ajax({
        url: '/get-product-data/' + productId,
        type: 'GET',
        success: function (data) {
            console.log(data); // Debugging

            var modal = $('#highlightModal');
            modal.find('#product-id').val(data.id);
            modal.find('#highlight-product-name').text(data.name);

            // Reset all checkboxes (uncheck them)
            modal.find('.highlight-checkbox').prop('checked', false);

            // Check only the highlights that match the product data
            if (Array.isArray(data.highlights)) {
                data.highlights.forEach(function (highlightId) {
                    modal.find('.highlight-checkbox[value="' + highlightId + '"]').prop('checked', true);
                });
            }
        },
        error: function (xhr, status, error) {
            console.error('Error fetching product data:', error);
        }
    });
});

</script>



<script>
    $(document).ready(function () {
    $('.highlight-checkbox').change(function () {
        var productId = $('#product-id').val();
        var selectedHighlights = [];

        $('.highlight-checkbox:checked').each(function () {
            selectedHighlights.push($(this).val());
        });

        $.ajax({
            url: "{{ route('highlight.updateHighlight') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                product_id: productId,
                highlights: selectedHighlights
            },
            success: function (response) {
                
            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseJSON.message);
            }
        });
    });
});

</script>

