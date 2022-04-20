    //get all sliders on page and make slider for each...
    let current = $(".first");
    let next = current.next();
    let prev = $("#slider").children().last();
    let interval = setInterval(startshow, 4000);
    function startshow() {
        //loop on every first class in the page
        $(".first").each(function() {
            current = $(this);
            next = $("#slider").children().last().hasClass("first") ? $("#slider").children().first() : $(this).next();
            prev = $("#slider").children().first().hasClass("first") ? $("#slider").children().last() : $(this).prev();
            $(this).toggleClass("hidden").toggleClass("first");
            next.toggleClass("first").toggleClass("hidden");
            prev = current;
            current = next;
            next = $("#slider").children().last().hasClass("first") ? $("#slider").children().first() : current.next();
            //check if the last element has first class to repeat the loop again
            if ($("#slider").children().last().hasClass("first")) {
                setTimeout(function() {
                    /* console.log(current); */
                    $("#slider").children().first().removeClass("hidden").addClass("first");
                    current = $("#slider").children().first();
                    prev = $("#slider").children().last();
                    next = current.next();
                }, 4000); //set time as the same time for setInterval time
            }
        });
    }

        function checkshow(func) {
            if (func == 'start') {
                interval = setInterval(startshow, 4000);
            } else {
                clearInterval(interval);

            }
        }

        /* function afterprev() {
            checkshow('start');
        } */

        $('#prev').click(function() {
            checkshow('stop');
            current.toggleClass('hidden').toggleClass("first");
            prev.toggleClass('first').toggleClass("hidden");
            next = current;
            current = prev;
            prev = $("#slider").children().first().hasClass("first") ? $("#slider").children().last() : current.prev();
            checkshow('start');
            /* afterprev(); */
        });
        $('#next').click(function() {
            checkshow('stop');
            current.toggleClass('hidden').toggleClass("first");
            next.toggleClass('first').toggleClass("hidden");
            prev = current;
            current = next;
            next = $("#slider").children().last().hasClass("first") ? $("#slider").children().first() : current.next();
            checkshow('start')
            /* afterprev(); */
        });