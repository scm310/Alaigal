<style>
    .cart-container {
        position: relative;
        display: inline-block;
    }

    .cart-icon {
        font-size: 30px;
        color: #333;
    }

    .cart-count {
        position: absolute;
        top: -5px;
        right: 47px;
        background-color: #bcb4c3;
        color: black;
        border-radius: 100%;
        padding: 1px 5px;
        font-size: 10px;
        font-weight: bold;
        min-width: 10px;
        text-align: center;
    }

    .search-suggestions {
        position: absolute;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 5px;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        width: 100%;
    }

    .search-suggestions li {
        padding: 10px;
        cursor: pointer;
    }

    .search-suggestions li:hover {
        background-color: #f1f1f1;
    }


    .no-bullets {
        list-style: none;
        /* Removes the bullet points */
        padding: 0;
        /* Removes default padding */
        margin: 0;
        /* Removes default margin */
    }

    .search{
        background-color: #A87676 !important;
    }

    .search:hover{
        background-color:#9055fd !important;
    }


 #navbar a{
    font-size: 13px;
 }
 #navbar{
    transform: translateY(5px);
 }

 .input-group {
    position: relative;
    display: flex;
    flex-wrap: wrap;
    align-items: stretch;
    width: 100%;
    transform: translateY(22px);
}


#navbar {
    transform: translateY(27px);
    color: black;
}
 @media (max-width: 768px) {
    #top-bar .row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    /* Logo & Navbar Side by Side */
    #top-bar .col-md-4:first-child {
        display: flex;
        align-items: center;
        flex: 1;
    }

    #navbar {
        flex: 1;
        text-align:center;
        transform: translateY(-7px);
    }

    /* Search Box Full Width */
    #top-bar .col-md-4.position-relative {
        flex: 1 1 100%;
        order: 2; /* Pushes search below logo & navbar */
        margin-top: 10px;
    }

    #navbar a {
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        color: #333;
        font-size: 16px;
        position: relative;
        padding-left:17px;
    }

    /* Hide Text on Mobile */
    #navbar a::after {
        content: attr(title); /* Display the text from title attribute */
        position: absolute;
        bottom: -25px;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 5px 10px;
        font-size: 14px;
        white-space: nowrap;
        border-radius: 5px;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease-in-out;
    }

    /* Show Text on Hover */
    #navbar a:hover::after {
        opacity: 1;
        visibility: visible;
    }

    /* Hide Default Text */
    #navbar a span {
        display: none;
    }

    .vendor{
    transform: translateY(0px) !important;
    color: black;
}

.input-group {
    position: relative;
    display: flex;
    flex-wrap: wrap;
    align-items: stretch;
    width: 100%;
    transform: translateY(-10px) !important;
}

h6{
    font-size:12px;
}

}

.vendor{
    color: black;
}

</style>



<div id="top-bar" class="container">
    <div class="row">
    <div class="col-4 d-flex align-items-center">

  <a class="navbar-brand mt-1" href="{{route('home')}}">
        <img src="{{ asset('assets/images/favicon.png') }}" alt="Logo" style="width:80px; height:80px;" />
    </a>
    <h6 class="me-2 mb-0">TIEPMD Marketplace</h6>
</div>

        <div class="col-md-4 position-relative">
            <form action="{{ route('product.search') }}" method="GET" class="search-form">
                <div class="input-group">
                    <input
                        type="text"
                        name="query"
                        class="form-control search-input"
                        placeholder="Search for products or services"
                        id="search-box"
                        autocomplete="off">
                    <button type="submit" class="btn search-btn search">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <!-- Suggestions dropdown -->
                <div id="suggestion-box" class="suggestion-box"></div>
            </form>


            <!-- Suggestions Box -->
            <ul id="search-suggestions" class="search-suggestions shadow-sm rounded d-none no-bullets">
                <!-- Suggestions will be dynamically injected here -->
            </ul>
        </div>
        <div class="col-md-4" id="navbar">
    <a href="{{ route('vendor') }}" class="vendor" title="Become a Seller" target="_blank" rel="noopener noreferrer">
        <i class="bi bi-shop"></i> <span>Become a Member</span>
    </a>
    &nbsp;&nbsp;
    <a href="{{ route('vendor.login') }}" class="vendor" title="Login" target="_blank" rel="noopener noreferrer">
        <i class="bi bi-person"></i> <span>Login</span>
    </a>
    &nbsp;&nbsp;
    <a href="{{ route('memberlogin') }}" class="vendor" title="Member Directory" target="_blank" rel="noopener noreferrer">
        <i class="bi bi-person-lines-fill"></i> <span>Member Directory</span>
    </a>
</div>

    </div>
</div>

<script>
    // Function to fetch and update the unique item count
    function fetchAndUpdateUniqueItemCount() {
        $.ajax({
            url: '/cart-unique-count',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log('Response received:', response);
                if (response.unique_count !== undefined) {
                    $('#cart-unique-count').text(response.unique_count);
                } else {
                    console.error('unique_count not found in response');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching unique item count:', xhr.responseText);
            }
        });
    }

    // Function to fetch search suggestions
    function fetchSearchSuggestions(query) {
        if (query.length === 0) {
            $('#search-suggestions').addClass('d-none');
            return;
        }

        $.ajax({
            url: '/search',
            method: 'GET',
            data: { query: query },
            dataType: 'json',
            success: function(response) {
                const suggestions = response.suggestions;
                let suggestionList = '';

                suggestions.forEach(item => {
                    suggestionList += `<li data-id="${item.id}" data-type="${item.type}"
                        data-category="${item.category || ''}"
                        data-subcategory="${item.subcategory || ''}"
                        data-childcategory="${item.childcategory || ''}">
                        ${item.name}
                    </li>`;
                });

                if (suggestions.length > 0) {
                    $('#search-suggestions').html(suggestionList).removeClass('d-none');
                } else {
                    $('#search-suggestions').html('<li>No results found</li>').removeClass('d-none');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching search suggestions:', xhr.responseText);
            }
        });
    }

    // Document Ready Function
    $(document).ready(function() {
        // Fetch cart count on page load
        fetchAndUpdateUniqueItemCount();

        // Poll cart count every 5 seconds
        setInterval(fetchAndUpdateUniqueItemCount, 1000);

        // Handle search input
        $('#search-box').on('input', function() {
            const query = $(this).val();
            fetchSearchSuggestions(query);
        });

        // Handle search suggestions click
        $('#search-suggestions').on('click', 'li', function() {
            const selectedText = $(this).text();
            const category = $(this).data('category');
            const subcategory = $(this).data('subcategory');
            const childcategory = $(this).data('childcategory');

            $('#search-box').val(selectedText);
            $('#search-suggestions').addClass('d-none');

            let url = `/search?query=${encodeURIComponent(selectedText)}`;

            // Append category, subcategory, and childcategory to the URL if available
            if (category && subcategory && childcategory) {
                url = `/${category}/${subcategory}/${childcategory}?query=${encodeURIComponent(selectedText)}`;
            } else if (category && subcategory) {
                url = `/${category}/${subcategory}?query=${encodeURIComponent(selectedText)}`;
            } else if (category) {
                url = `/${category}?query=${encodeURIComponent(selectedText)}`;
            }

            // Redirect to search results page
            window.location.href = url;
        });

        // Hide search suggestions when clicking outside
        $(document).on('click', function(event) {
            if (!$(event.target).closest('#search-box, #search-suggestions').length) {
                $('#search-suggestions').addClass('d-none');
            }
        });
    });
</script>
