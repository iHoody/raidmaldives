(function () {
    'use strict';

    const BlogLoader = {
        page: 1,
        postsPerPage: 6,
        loading: false,
        button: null,
        postsContainer: null,
        preloader: null,

        init() {
            this.button = document.querySelector('.pagination-click .btn');
            this.postsContainer = document.querySelector('.blog-section__posts .row');

            if (!this.button || !this.postsContainer) {
                return;
            }

            this.createPreloader();
            this.bindEvents();
        },

        createPreloader() {
            const preloaderHTML = `
                <div class="blog-preloader" style="display: none;">
                    <div class="spinner"></div>
                </div>
              `;

            const paginationWrapper = document.querySelector('.pagination-click');
            if (paginationWrapper) {
                paginationWrapper.insertAdjacentHTML('beforebegin', preloaderHTML);
                this.preloader = document.querySelector('.blog-preloader');
            }
        },

        bindEvents() {
            this.button.addEventListener('click', (e) => {
                e.preventDefault();
                this.loadMorePosts();
            });
        },

        showPreloader() {
            if (this.preloader) {
                this.preloader.style.display = 'flex';
            }
            if (this.button) {
                this.button.style.opacity = '0.5';
                this.button.style.pointerEvents = 'none';
            }
        },

        hidePreloader() {
            if (this.preloader) {
                this.preloader.style.display = 'none';
            }
            if (this.button) {
                this.button.style.opacity = '1';
                this.button.style.pointerEvents = 'auto';
            }
        },

        async loadMorePosts() {
            if (this.loading) {
                return;
            }

            this.loading = true;
            this.showPreloader();

            try {
                const response = await fetch(`${window.location.origin}/wp-admin/admin-ajax.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'load_more_posts',
                        page: this.page + 1,
                        posts_per_page: this.postsPerPage,
                    }),
                });

                const data = await response.json();

                if (data.success && data.data.html) {
                    const paginationColumn = document.querySelector('.pagination-click').closest('.column');
                    paginationColumn.insertAdjacentHTML('beforebegin', data.data.html);

                    this.page++;

                    // Hide button if no more posts
                    if (!data.data.has_more) {
                        this.button.textContent = 'No More Posts';
                        this.button.style.pointerEvents = 'none';
                        this.button.style.display = 'none';
                    }
                } else {
                    console.error('Failed to load posts');
                }
            } catch (error) {
                console.error('Error loading posts:', error);
            } finally {
                this.loading = false;
                this.hidePreloader();
            }
        },
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => BlogLoader.init());
    } else {
        BlogLoader.init();
    }
})();
