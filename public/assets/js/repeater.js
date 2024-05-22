jQuery.fn.extend({
    createRepeater: function () {
        var addItem = function (items, key) {
            var itemContent = items;
            var group = itemContent.data("group");
            var item = itemContent.clone(); // use clone() method instead of getting HTML
            var input = item.find('input,select');
            input.each(function (index, el) {
                var attrName = $(el).data('name');
                var skipName = $(el).data('skip-name');
                
                if (skipName != true) {
                    $(el).attr("name", group + "[" + key + "]" + attrName);
                } else {
                    if (attrName != 'undefined') {
                        $(el).attr("name", attrName);
                    }
                }
                $(el).val(''); // clear the value of the input
            });
            
            item.appendTo(repeater); // append the cloned item to the repeater
        };
        
        /* find elements */
        var repeater = this;
        var items = repeater.find(".items").last();
        var key = $('.items').length - 1;
        var addButton = repeater.find('.repeater-add-btn');
        var newItem = items;
        
        if (key == 0) {
            // items.remove();
            // addItem(newItem, key);
        }

        /* handle click and add items */
        addButton.on("click", function () {
            key++;
            addItem(newItem, key);
        });
    }
});
