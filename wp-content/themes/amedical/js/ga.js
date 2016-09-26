jQuery(document).ready(
    function($){


        //lang variable defined in head part of the output html
        //contact_page_link variable defined in head part of the output html


        //1.. Social buttons - add events for clicking the social buttons
        $('#facebook-share').parent().click(function(){
            ga('send', 'event', 'Social button clicked', 'Facebook');
        });
        $('#linkedin-share').parent().click(function(){
            ga('send', 'event', 'Social button clicked', 'LinkedIn');
        });


        //2.. Search bar - add event for using the search bar
        $( "#search-mobile-form, #search-form" ).submit(function( event ) {
            var self = $(this);
            var searchterm = self.find(input[name="search"]).val();
            ga('send', 'event', 'Search bar used', searchterm);
        });


        //3.. Contact form - add event in the contacts page for successfully sending the contact form
        $(document).on("gform_confirmation_loaded", function (e, form_id) {
            // code to run upon successful form submission
            if (form_id==contact_form_id){
                ga('send', 'event', 'Contact form sent', lang);
            }

        });



        // 4. Email address - add events for clicking the email address
        //a.. Footer email address clicked
        //b.. Contacts email address clicked (if available - currently there is no content)
        $('a[href^="mailto:"]').click(function(){

            var self = $(this);
            var selected_email = $(this).text();
            var click_position="Footer email clicked";
            //check if link is in footer block if it not in footer, must be in contacts
            if (!self.closest("foooter")){
                click_position='Contacts email clicked';
            }
            ga('send', 'event', 'Email address clicked', click_position, selected_email );
        })


        //5 Phone number - add events for clicking the phone number
        //a.. Footer phone number clicked
        //b.. Contacts phone number clicked (if available - currently there is no content)
        $('a[href^="tel:"]').click(function(){
            //4.a 4.b
            var self = $(this);
            var selected_email = $(this).text();
            var click_position="Footer email clicked";
            //check if link is in footer block if it not in footer, must be in contacts
            if (!self.closest("footer")){
                click_position='Contacts email clicked';
            }
            ga('send', 'event', 'Phone number clicked', click_position, selected_email );
        })


        //6.. Newsletter - add event for successfully subscribing to the newsletter
        if(('.mc4wp-success').length>0){
            ga('send', 'event', 'Newsletter subscribed', lang);
        }


        //7.. Homepage events - add events for clicking various homepage elements
        //a.. Slider button - add event for clicking the slider button

        $('main-slider').find('a').click(function{
            var self=$(this);
            var button_text = self.text();
            var button_url = self.attr("href");
            ga('send', 'event', 'Homepage events', button_text+' button clicked', button_url);
        });

        //b.. Uzzināt vairāk buttons - add event for clicking one of the “Uzzināt vairāk” buttons (for all languages)
        $('.services').find('a').click(function(){
            var self=$(this);
            var button_text = self.text();
            var button_url = self.attr("href");
            ga('send', 'event', 'Homepage events', button_text+' button clicked', button_url);
        });

        //c.. Mēs pārstāvam button - add event for clicking the Mēs pārstāvam content block button (for all languages)
        //d.. Apsaktīt visus jaunumus button - add event for clicking the news/blog content block button (for all languages)
        $('#we-represent-button, #all-news').function(){
            var self=$(this);
            var button_text = self.text();
            var button_url = self.attr("href");
            ga('send', 'event', 'Homepage events', button_text+' button clicked', button_url);
        };



        //8.0.. When clicking the CTA buttons that lead to the contacts page - add paramerer "?ref={projektesana}”, which indicates the page from which the user arrived.
        //done in php

        //8.1.. Contact us buttons - add event for clicking the “Contact us” button (for all languages)
        $('a.button').each(function(){
            var self = $(this);

            var url="";
            if (self.attr("href")){
                url =self.attr("href");
                text = self.text();
                if (url == contact_page_link){
                    ga('send', 'event', 'Contact us button clicked', text+' button clicked');
                }

            }
        });








    }
);