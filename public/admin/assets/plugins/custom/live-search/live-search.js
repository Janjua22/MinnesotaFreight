(function($){
    "use strict";

    var settings = {
        name: "location_id",
        method: 'GET',
        selected: ''
    };

    /**
     * Creating a prototype for a method to append an element
     * next to the provided sibling element.
     */
    Element.prototype.appendAfter = function(element){
        element.parentNode.insertBefore(this, element.nextSibling);
    }, false;

    function createDropdownContainer(elem){
        const container = document.createElement("DIV");
        const input = document.createElement("INPUT");

        container.className = 'lvs-container';

        input.setAttribute('type', 'hidden');
        input.setAttribute('name', settings.name);
        input.setAttribute('value', settings.selected);

        container.appendChild(input);

        container.appendAfter(elem);

        if(elem.offsetWidth > 300){
            container.style.width = elem.offsetWidth+'px';
        }

        return container;
    }

    function createContainerItem(text, elem){
        const itemPanel = document.createElement("DIV");
        const item = document.createElement(elem);
        const textNode = document.createTextNode(text);

        itemPanel.className = "lvs-suggestion-item";

        item.setAttribute('href', 'javascript:void(0);');
        item.appendChild(textNode);

        itemPanel.appendChild(item);

        return itemPanel;
    }

    /*function initPlugin($instance){
        $instance.each(function(index){
            if($instance[index].getAttribute('data-selected')){
                settings.selected = $instance[index].getAttribute('data-selected');
            }
            
            let container = createDropdownContainer($instance[index]);
            let url = settings.url;
            let request = null;

            $instance[index].onkeyup = keystroke => {
                if($instance[index].value.length > 2){
                    if(request != null){
                        request.abort();
                    }

                    request = $.ajax({
                        url,
                        type: settings.method,
                        data: { q: $instance[index].value },
                        success: res => {
                            $('.lvs-suggestion-item').remove();
    
                            if(res.length){
                                res.map(function(obj){
                                    let item = createContainerItem(`${obj.name} (${obj.city}, ${obj.state})`, "A");

                                    item.addEventListener('click', evt => {
                                        let hiddenInput = container.getElementsByTagName('input');

                                        $instance[index].value = obj.name;
                                        hiddenInput[0].value = obj.id;
                                    });

                                    container.appendChild(item);
                                });
                            } else{
                                let item = createContainerItem("No locations found!", "P");

                                $(container).append(item);
                            }
    
                            container.style.display = 'block';
                        },
                        error: err => {
                            container.style.display = 'none';
                            // console.error(err);
                        },
                    });
                } else{
                    if(request != null){
                        request.abort();
                    }

                    container.style.display = 'none';
                }
            }

            $instance[index].addEventListener('focusout', evt => {
                setTimeout(() => {
                    container.style.display = 'none';
                }, 100);
            });
        });
    }*/

    $.fn.liveSearch = function(options, callback = null){
        settings = $.extend(settings, options);

        // initPlugin(this);

        return this.each(function(){
            if(this.getAttribute('data-selected')){
                settings.selected = this.getAttribute('data-selected');
            }
            
            let container = createDropdownContainer(this);
            let $instance = this;
            let request = null;
            let url = settings.url;
            let hovered = [];

            $instance.onkeyup = keystroke => {
                if($instance.value.length > 2){
                    if(request != null){
                        request.abort();
                    }

                    // Applying the server request check if the user press UP, DOWN or ENTER key...
                    if(keystroke.which != 40 && keystroke.which != 38 && keystroke.which != 13){
                        request = $.ajax({
                            url,
                            type: settings.method,
                            data: { q: $instance.value },
                            success: res => {
                                $('.lvs-suggestion-item').remove();

                                if(res.length){
                                    res.map(function(obj){
                                        let outputText;

                                        if(callback){
                                            outputText = callback(obj);
                                        } else{
                                            outputText = `${obj.name} (${obj.city}, ${obj.state})`;
                                        }

                                        let item = createContainerItem(outputText, "A");

                                        item.addEventListener('click', evt => {
                                            let hiddenInput = container.getElementsByTagName('input');

                                            if(callback){
                                                $instance.value = outputText;
                                            } else{
                                                $instance.value = obj.name;
                                            }
                                            hiddenInput[0].value = obj.id;
                                        });

                                        container.appendChild(item);
                                    });
                                } else{
                                    let item = createContainerItem("No locations found!", "P");

                                    $(container).append(item);
                                }
        
                                container.style.display = 'block';
                                hovered = [];
                            },
                            error: err => {
                                container.style.display = 'none';
                                // console.error(err);
                            },
                        });
                    }
                } else{
                    if(request != null){
                        request.abort();
                    }

                    container.style.display = 'none';
                }
            }

            $instance.onkeydown = keystroke => {
                if($instance.value.length > 2){
                    if(keystroke.which == 40 || keystroke.which == 38 || keystroke.which == 13){
                        keystroke.preventDefault();
                        
                        let items = $(container).children(".lvs-suggestion-item");
                        
                        if(hovered.length){
                            if(keystroke.which == 40){ // down key
                                if(hovered.next().prop('tagName')){
                                    hovered.removeClass("item-hovered");
                                    hovered = hovered.next().addClass('item-hovered');
                                }
                            } 
                            if(keystroke.which == 38){ // up key
                                if(hovered.prev().prop('tagName') != "INPUT"){
                                    hovered.removeClass("item-hovered");
                                    hovered = hovered.prev().addClass('item-hovered');
                                }
                            }
                            if(keystroke.which == 13){ // enter key
                                hovered.children("a")[0].click();
                                container.style.display = 'none';
                                hovered = [];
                            }
                        } else{
                            hovered = $(items[0]).addClass('item-hovered');
                        }
                    }
                }
            }

            $instance.addEventListener('focusout', evt => {
                setTimeout(() => {
                    container.style.display = 'none';
                    hovered = [];
                }, 100);
            });
        });

        // return {
        //     reload: ()=>{
        //         // $(this).next('.lvs-container').remove();
        //         // initPlugin(this);
        //     }
        // };
    };
})(jQuery);