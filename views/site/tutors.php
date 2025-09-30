<?php
/** @var yii\web\View $this */
/** @var array $tutors */
/** @var \yii\data\Pagination $pages */
/** @var string $search */

use app\components\Helper;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Tutors';

$search = Yii::$app->request->get('search', '');

?>
<style>
    .search-input-wrapper::before {
        content: none !important;
        left: 370px !important;
    }

    .search-box .form-control {
        padding: 22px 24px 22px 30px !important;
    }
    
    @media (max-width: 576px) {
        .tutors-page-card {
            display: flex;
            align-items: flex-start;
            padding: 15px;
        }
        
        .tutors-page-card-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-right: 15px;
            min-width: 80px;
        }
        
        .tutors-page-tutor-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-bottom: 8px;
        }
        
        .tutors-page-rating {
            font-size: 12px;
            color: #666;
        }
        
        .tutors-page-card-info {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .tutors-page-tutor-name {
            font-size: 16px;
            margin: 0 0 5px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .tutors-page-tutor-name::after {
            content: "★";
            color: #ffc107;
            font-size: 14px;
        }
        
        .tutors-page-tutor-name::before {
            content: attr(data-rating);
            color: #666;
            font-size: 12px;
            font-weight: normal;
        }
        
        .tutors-page-subjects {
            margin-top: 8px !important;
            display: flex !important;
            justify-content: flex-start;
        }
        
        .tutors-page-subject-tag {
            display: inline-block;
            background: #f8f9fa;
            color: #495057;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            margin-right: 5px;
            margin-bottom: 5px;
        }
        
        .tutors-page-rating,
        .tutor-location {
            display: none;
        }
    }
    
    .search-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
    }
    
    .search-suggestion-item {
        padding: 12px 20px;
        cursor: pointer;
        border-bottom: 1px solid #f0f0f0;
        transition: background-color 0.2s;
    }
    
    .search-suggestion-item:hover {
        background-color: #f8f9fa;
    }
    
    .search-suggestion-item:last-child {
        border-bottom: none;
    }
    
    .search-container {
        position: relative;
    }
    
    .search-icon-btn {
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
        transition: color 0.3s;
    }
    
    .search-icon-btn.active {
        color: #007bff;
    }
    
    .search-placeholder {
        position: absolute;
        top: 50%;
        left: 20px;
        transform: translateY(-50%);
        color: #6c757d;
        pointer-events: none;
        transition: all 0.3s;
    }
    
    .search-input:focus + .search-placeholder,
    .search-input:not(:placeholder-shown) + .search-placeholder {
        display: none;
    }
    
    .no-results-message {
        display: none;
        text-align: center;
        padding: 20px;
        color: #6c757d;
    }
</style>

<div class="p-3" style="background-color: #fafafa;">
    <div class="container">
        <div class="tutors-page-hero-content row">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="tutors-page-normal">Find Top Talented Tutors</div>
                <p class="tutors-page-hero-description">Find top talented tutors for tutoring assignments, projects and for learning support.</p>
            </div>
            <div class="search-box col-lg-4 col-md-12">
                <div class="search-container position-relative mt-3">
                    <input
                        type="text"
                        class="form-control search-input"
                        id="tutor-search"
                        placeholder=" "
                        value="<?= htmlspecialchars($search) ?>"
                        autocomplete="off">
                    <div class="search-placeholder">Search by tutor name or subject...</div>
                    <div class="search-suggestions" id="search-suggestions"></div>
                    <i class="fa fa-search position-absolute search-icon-btn"
                       id="search-button"
                       style="right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;"
                       onclick="performAjaxSearch(document.getElementById('tutor-search').value.trim(), 1)"></i>
                </div>
            </div>
        </div>

        <!-- Tutors Grid Section -->
        <section class="tutors-page-grid mt-4">
            <div class="container" id="tutors-grid-container">
                <?= $this->render('_tutors_grid', [
                    'tutors' => $tutors,
                    'pages' => $pages,
                    'search' => $search
                ]) ?>
            </div>
        </section>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('tutor-search');
    const searchButton = document.getElementById('search-button');
    const suggestionsContainer = document.getElementById('search-suggestions');

    // Debounce function to limit AJAX calls
    function debounce(func, delay) {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => func(...args), delay);
        };
    }

    // Update search button state
    function updateSearchButton() {
        if (searchInput.value.trim() !== '') {
            searchButton.classList.add('active');
        } else {
            searchButton.classList.remove('active');
        }
    }

    // Perform AJAX search
    function performAjaxSearch(search, page = 1) {
        console.log('Performing AJAX search for:', search, 'Page:', page);
        fetch(`<?= Url::to(['site/ajax-tutors']) ?>?search=${encodeURIComponent(search)}&page=${page}`)
            .then(response => {
                console.log('Tutors response status:', response.status);
                if (!response.ok) throw new Error('Network response was not ok: ' + response.status);
                return response.json();
            })
            .then(data => {
                console.log('AJAX tutors response:', data);
                if (data.error) {
                    console.error('Server error:', data.error);
                    return;
                }
                document.getElementById('tutors-grid-container').innerHTML = data.html;
                attachPaginationListeners();
            })
            .catch(error => console.error('AJAX tutors error:', error));
    }

    // Generate suggestions via AJAX
    function generateSuggestions() {
        const searchTerm = searchInput.value.trim();
        if (searchTerm === '') {
            suggestionsContainer.style.display = 'none';
            return;
        }

        console.log('Fetching suggestions for:', searchTerm);
        fetch(`<?= Url::to(['site/ajax-suggestions']) ?>?term=${encodeURIComponent(searchTerm)}`)
            .then(response => {
                console.log('Suggestions response status:', response.status);
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error('Network response was not ok: ' + response.status + ', Response: ' + text);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Suggestions received:', data);
                suggestionsContainer.innerHTML = '';
                if (data.error) {
                    console.error('Server error in suggestions:', data.error);
                    suggestionsContainer.style.display = 'none';
                    return;
                }
                if (data.length > 0) {
                    data.forEach(suggestion => {
                        const suggestionElement = document.createElement('div');
                        suggestionElement.className = 'search-suggestion-item';
                        suggestionElement.textContent = suggestion;
                        suggestionElement.addEventListener('click', () => {
                            searchInput.value = suggestion;
                            suggestionsContainer.style.display = 'none';
                            performAjaxSearch(suggestion, 1);
                            updateSearchButton();
                        });
                        suggestionsContainer.appendChild(suggestionElement);
                    });
                    suggestionsContainer.style.display = 'block';
                } else {
                    suggestionsContainer.style.display = 'none';
                }
            })
            .catch(error => console.error('AJAX suggestions error:', error));
    }

    // Attach listeners to pagination links
    function attachPaginationListeners() {
        document.querySelectorAll('.pagination a').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const url = new URL(link.href);
                const page = url.searchParams.get('page') || 1;
                console.log('Pagination clicked, page:', page);
                performAjaxSearch(searchInput.value.trim(), page);
            });
        });
    }

    // Initial setup
    updateSearchButton();
    attachPaginationListeners();

    // Event listeners
    searchInput.addEventListener('input', debounce(() => {
        updateSearchButton();
        generateSuggestions();
        performAjaxSearch(searchInput.value.trim(), 1);
    }, 300));

    searchInput.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            performAjaxSearch(searchInput.value.trim(), 1);
        }
    });

    // Hide suggestions when clicking outside
    document.addEventListener('click', function(event) {
        if (!searchInput.contains(event.target) && !suggestionsContainer.contains(event.target)) {
            suggestionsContainer.style.display = 'none';
        }
    });
});
</script>