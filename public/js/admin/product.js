/**
 * Product management functionality
 */
const ProductManager = {
    // Color suggestions data
    colorSuggestions: {},
    
    init: function(suggestions) {
        this.colorSuggestions = suggestions;
        this.setupToneSuggestions();
        this.setupColorIndicators();
        this.setupVariantActions();
    },
    
    setupToneSuggestions: function() {
        // Setup tone suggestion dropdowns
        document.querySelectorAll('[id$="toneSuggestion"]').forEach(select => {
            select.addEventListener('change', function() {
                const idPrefix = this.id.replace('toneSuggestion', '');
                const selectedTone = this.value;
                const suggestionsContainer = document.getElementById(`${idPrefix}colorSuggestions`);
                const suggestedColorsList = document.getElementById(`${idPrefix}suggestedColorsList`);
                
                suggestedColorsList.innerHTML = '';
                
                if (selectedTone && ProductManager.colorSuggestions[selectedTone]) {
                    suggestionsContainer.classList.remove('d-none');
                    
                    // Display the suggested colors
                    Object.entries(ProductManager.colorSuggestions[selectedTone]).forEach(([colorName, colorCode]) => {
                        const colorItem = document.createElement('div');
                        colorItem.className = 'color-suggestion-item me-3 mb-2';
                        colorItem.innerHTML = `
                            <div class="d-flex align-items-center">
                                <div style="width: 25px; height: 25px; background-color: ${colorCode}; 
                                        border-radius: 50%; margin-right: 8px; border: 1px solid #ddd;"></div>
                                <span>${colorName}</span>
                            </div>
                        `;
                        
                        // Make the color suggestion clickable
                        colorItem.addEventListener('click', function() {
                            // Find the color in the dropdown options
                            const formPrefix = idPrefix === 'edit_' ? 'edit_' : '';
                            const colorSelect = document.getElementById(`${formPrefix}colorID`);
                            if (colorSelect) {
                                Array.from(colorSelect.options).forEach(option => {
                                    if (option.text.includes(colorName)) {
                                        colorSelect.value = option.value;
                                        colorSelect.dispatchEvent(new Event('change', { bubbles: true }));
                                    }
                                });
                            }
                        });
                        
                        suggestedColorsList.appendChild(colorItem);
                    });
                } else {
                    suggestionsContainer.classList.add('d-none');
                }
            });
        });
    },
    
    setupColorIndicators: function() {
        // Initialize tone and color selectors
        document.querySelectorAll('.tone-select').forEach(select => {
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const container = this.closest('div').querySelector('.tone-indicator');
                const swatch = container.querySelector('.tone-swatch');
                const name = container.querySelector('.tone-name');
                
                if (this.value && selectedOption) {
                    swatch.style.backgroundColor = selectedOption.dataset.toneCode;
                    name.textContent = selectedOption.dataset.toneName;
                    container.classList.remove('d-none');
                    
                    // Update the tone suggestion dropdown to match
                    if (this.id === 'edit_toneID') {
                        document.getElementById('edit_toneSuggestion').value = selectedOption.dataset.toneName;
                        document.getElementById('edit_toneSuggestion').dispatchEvent(new Event('change', { bubbles: true }));
                    }
                } else {
                    container.classList.add('d-none');
                }
            });
        });
        
        document.querySelectorAll('.color-select').forEach(select => {
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const container = this.closest('div').querySelector('.color-indicator');
                const swatch = container.querySelector('.color-swatch');
                const name = container.querySelector('.color-name');
                
                if (this.value && selectedOption) {
                    swatch.style.backgroundColor = selectedOption.dataset.colorCode;
                    name.textContent = selectedOption.dataset.colorName;
                    container.classList.remove('d-none');
                } else {
                    container.classList.add('d-none');
                }
            });
        });
    },
    
    setupVariantActions: function() {
        // Handle edit variant button clicks
        document.querySelectorAll('.edit-variant').forEach(button => {
            button.addEventListener('click', function() {
                const variantId = this.getAttribute('data-variant-id');
                ProductManager.fetchVariantDetails(variantId);
            });
        });
        
        // Handle delete variant button clicks
        document.querySelectorAll('.delete-variant').forEach(button => {
            button.addEventListener('click', function() {
                const variantId = this.getAttribute('data-variant-id');
                document.getElementById('deleteVariantForm').action = `/admin/products/variants/${variantId}`;
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteVariantModal'));
                deleteModal.show();
            });
        });
    },
    
    fetchVariantDetails: function(variantId) {
        fetch(`/admin/products/variants/${variantId}/edit`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.variant) {
                this.populateEditForm(data.variant);
                const editModal = new bootstrap.Modal(document.getElementById('editVariantModal'));
                editModal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load variant details. Please try again.');
        });
    },
    
    populateEditForm: function(variant) {
        const form = document.getElementById('editVariantForm');
        form.action = `/admin/products/variants/${variant.product_variantID}`;
        
        // Set values in form fields
        const toneSelect = document.getElementById('edit_toneID');
        const colorSelect = document.getElementById('edit_colorID');
        
        toneSelect.value = variant.toneID;
        colorSelect.value = variant.colorID;
        document.getElementById('edit_product_size').value = variant.product_size;
        document.getElementById('edit_product_stock').value = variant.product_stock;
        
        // Update image preview
        const imageUrl = variant.product_image ? `/storage/${variant.product_image}` : '';
        document.getElementById('current_variant_image').src = imageUrl;
        
        // Trigger change events to update visual indicators
        setTimeout(() => {
            // Create and dispatch proper change events
            const toneEvent = new Event('change', { bubbles: true });
            const colorEvent = new Event('change', { bubbles: true });
            
            toneSelect.dispatchEvent(toneEvent);
            colorSelect.dispatchEvent(colorEvent);
            
            // Also update the tone suggestion dropdown
            const selectedToneOption = toneSelect.options[toneSelect.selectedIndex];
            if (selectedToneOption && selectedToneOption.dataset.toneName) {
                const suggestionSelect = document.getElementById('edit_toneSuggestion');
                suggestionSelect.value = selectedToneOption.dataset.toneName;
                suggestionSelect.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }, 100);
    }
};