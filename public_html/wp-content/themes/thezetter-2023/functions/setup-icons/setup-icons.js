function up_icon_picker(){
    var target_acf_field = false;
    var target_acf_search = ".acf-field-select[data-name=autoloaded_icon]";

    //Handle open function and registers selected ACF field
    document.addEventListener('mousedown', function(e) {
        var targetElement = e.target;
        // Check if the clicked element is a select field within the specific ACF field
        if ( targetElement.closest(target_acf_search+"[data-name=autoloaded_icon]") && (   
            targetElement.matches("select") || 
            targetElement.closest(".select2")
        )) {
            //Prevent the "select2" field from opening, but only if jquery is defined. 
            var selectElement = targetElement.closest(".acf-field.acf-field-select").querySelector('select');
            if (typeof jQuery !== 'undefined' && jQuery(selectElement).data('select2')) {
                jQuery(selectElement).select2('close');  // Close the select2 dropdown
            }
            e.preventDefault();
            targetElement.blur();
            if(targetElement.matches("select")){
                target_acf_field = targetElement;
            }else{
                target_acf_field = selectElement;
            }
            window.focus();
            document.querySelector('.up-icon-picker-modal').classList.add('active');
            document.body.style.overflow = "hidden";
        }
    });

    //Close icon modal
    document.querySelectorAll(".up-icon-picker-close").forEach(function(target) {
        target.onclick = function(e) {
            e.preventDefault();
            this.closest('.up-icon-picker-modal').classList.remove('active');
            document.body.style.overflow = "";  
        };
    });

    //Close icon modal (when clicking outside the modal)
    document.querySelectorAll(".up-icon-picker-modal").forEach(function(target) {
        target.onclick = function(e) {
            if (e.target == target){
                e.preventDefault();
                target.classList.remove('active');
                document.body.style.overflow = "";  
            }
        };
    });

    //Icon picker category selector and update displayed icons
    document.querySelectorAll(".up-icon-picker-category").forEach(function(target) {
        target.onclick = function(e) {
            e.preventDefault();
            var cat = this.getAttribute('data-cat');
            var items = this.closest('.up-icon-picker-modal').querySelectorAll('.up-icon-picker-grid .up-icon-select');
            this.closest('.up-icon-picker-modal').querySelectorAll('.up-icon-picker-category').forEach(i => i.classList.remove('active'));
            this.classList.add('active');
            if(cat != 'all'){
                items.forEach(function(item) {
                    var itemValue = item.getAttribute('data-cat');
                    if (itemValue == cat) {
                        item.classList.remove('cat-hidden');
                    } else {
                        item.classList.add('cat-hidden');
                    
                    }
                });
            }else{
                items.forEach(i => i.classList.remove('cat-hidden'));
            }
            count_icons_active(this);
        };
    });

    //Handles select of option and update required ACF field
    document.querySelectorAll(".up-icon-select").forEach(function(target) {
        target.onclick = function(e) {
            target_acf_field.value = this.getAttribute('data-id');
            const changeEvent = new Event('change', { bubbles: true });
            target_acf_field.dispatchEvent(changeEvent);
            document.querySelector('.up-icon-picker-modal').classList.remove('active');
            document.body.style.overflow = "";  
        };
    });

    //Update results based on user input
    document.querySelector('input[name=up-icon-seach-input]').addEventListener('keyup', function(e) {
        var search = this.value.toLowerCase();
        var items = this.closest('.up-icon-picker-modal').querySelectorAll('.up-icon-picker-grid .up-icon-select');
        items.forEach(function(item) {
            var itemValue = item.getAttribute('data-value').toLowerCase();
            if (itemValue.includes(search)) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
              
            }
        });
        count_icons_active(this);
    });

    //Count number of displayed icons and update results number
    function count_icons_active(target){
        var items = target.closest('.up-icon-picker-modal').querySelectorAll('.up-icon-picker-grid .up-icon-select');
        var foundItems = 0;
        items.forEach(function(item) {
            if(!item.classList.contains('hidden') && !item.classList.contains('cat-hidden')){
                foundItems++;
            }
        });
        document.querySelectorAll('.up-icon-picker-results-number')[0].textContent = foundItems;
    }
}
up_icon_picker();

    
