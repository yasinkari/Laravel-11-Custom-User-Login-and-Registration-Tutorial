class AjaxPagination {
    constructor(options) {
        this.container = options.container;
        this.contentSelector = options.contentSelector || '.table-responsive';
        this.paginationSelector = options.paginationSelector || '.card-footer';
        this.url = options.url;
        this.onLoad = options.onLoad || (() => {});
        this.onError = options.onError || ((error) => console.error('Pagination error:', error));
        
        this.initializeEventListeners();
    }

    initializeEventListeners() {
        this.container.addEventListener('click', (e) => {
            const link = e.target.closest('.page-link');
            if (!link) return;
            
            e.preventDefault();
            this.loadPage(link.href);
        });
    }

    loadPage(url) {
        const content = this.container.querySelector(this.contentSelector);
        const pagination = this.container.querySelector(this.paginationSelector);
        
        content.classList.add('opacity-50');
        
        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                content.innerHTML = doc.querySelector(this.contentSelector).innerHTML;
                pagination.innerHTML = doc.querySelector(this.paginationSelector).innerHTML;
                
                this.onLoad(doc);
            })
            .catch(this.onError)
            .finally(() => {
                content.classList.remove('opacity-50');
            });
    }
}

window.AjaxPagination = AjaxPagination;