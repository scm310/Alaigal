<style>
    @media (max-width: 600px) {

        .mainnavbar {
            display: none;
        }
        .mobile {
            display: flex !important;
            flex-direction: column;
            gap: 15px;
            background-color: white;
        }
        .category-row {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            gap: 15px;
            padding-top: 5px;
            scrollbar-width: none;
        }
        .category-row::-webkit-scrollbar {
            display: none;
        }
        .category-wrapper {
            flex: 0 0 auto;
            scroll-snap-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 80px;
        }
        .category-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #ab7878;
            background-color: #091016;
            box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.4), inset -2px -2px 5px rgba(255, 255, 255, 0.5);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .category-img:hover {
            transform: scale(1.1);
            box-shadow: 4px 6px 12px rgba(0, 0, 0, 0.5), inset -2px -2px 8px rgba(255, 255, 255, 0.6);
        }
        .category-name {
            font-size: 12px;
            font-weight: 600;
            color: #333;
            margin-top: 5px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 80px;
            white-space: normal;
            word-wrap: break-word;
            text-align: center;
        }
    }
</style>

<div class="mobile shadow-lg mb-1 p-1 rounded" style="display: none">
    <div class="category-row">
  
        @foreach($categories->slice(0, ceil($categories->count() / 2)) as $category)
            <a class="nav-link category-link" href="#" data-category-id="{{ $category->Category_id }}">
                <div class="category-wrapper">
                    <img src="{{ asset($category->Category_image) }}" alt="{{ $category->Category_name }}" class="category-img">
                    <span class="category-name">{{ $category->Category_name }}</span>
                </div>
            </a>
        @endforeach
    </div>

    <div class="category-row">
        @foreach($categories->slice(ceil($categories->count() / 2)) as $category)
            <a class="nav-link category-link" href="#" data-category-id="{{ $category->Category_id }}">
                <div class="category-wrapper">
                    <img src="{{ asset($category->Category_image) }}" alt="{{ $category->Category_name }}" class="category-img">
                    <span class="category-name">{{ $category->Category_name }}</span>
                </div>
            </a>
        @endforeach
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.category-link').forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            let categoryId = this.getAttribute('data-category-id');

            // Redirect to subcategory page
            window.location.href = `/subcategoriesm/${categoryId}`;
        });
    });
});

function openChildCategoryPage(subcategoryId) {
    window.location.href = `/childcategoriesm/${subcategoryId}`;
}
</script>
