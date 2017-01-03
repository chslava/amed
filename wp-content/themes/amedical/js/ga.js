function remove_params_from_url(oldURL) {
    var index = 0;
    var newURL = oldURL;
    index = oldURL.indexOf('?');
    if(index == -1){
        index = oldURL.indexOf('#');
    }
    if(index != -1){
        newURL = oldURL.substring(0, index);
    }
    return newURL;
}


function get_social_profile_links()
{
    var social_links = [];
    social_links.push({"url":"facebook.com","title":"Facebook"});
    social_links.push({"url":"twitter.com","title":"Twitter"});
    social_links.push({"url":"linkedin.com","title":"LinkedIn"});
    social_links.push({"url":"youtube.com","title":"Youtube"});

    return social_links;

}

function get_link_text(jquery_obj){
    console.log(jquery_obj);
    var text=jquery_obj.text();
    if (text.trim().length==0){
        if (jquery_obj.attr("title")){
            text = jquery_obj.attr("title");
        }
    }
    return text.trim();
}

jQuery(function($) {
        //lang variable defined in head part of the output html
        //contact_page_link variable defined in head part of the output html





        //2.. Search bar - add event for using the search bar
        $('#mobile-search, #desktop-search, #tablet-search').submit(function( event ) {
            var self = $(this);
            var searchterm = self.find('input[name=search]').first().val();
            ga('send', 'event', 'Search bar used', searchterm.trim());
        });


        //3.. Contact form - add event in the contacts page for successfully sending the contact form
        $(document).on("gform_confirmation_loaded", function (e, form_id) {
            // code to run upon successful form submission
            if (form_id==contact_form_id){
                ga('send', 'event', 'Contact form sent', lang);
                //ga('send', 'event', 'Contact form sent', "formas nosaukums" +"Sent","referalis"); (direct)
                //
                //ga('send', 'event',"CTA button clicked", "button name" + " clicked","destination"); + referal 
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
            if (self.parents("footer").length==0){
                click_position='Contacts email clicked';
            }
            ga('send', 'event', 'Email address clicked', click_position, selected_email.trim() );
            //ga('send', 'event', 'Email address clicked', click_position+" clicked", selected_email.trim() );
        })


        //5 Phone number - add events for clicking the phone number
        //a.. Footer phone number clicked
        //b.. Contacts phone number clicked (if available - currently there is no content)
        $('a[href^="tel:"]').click(function(){
            //4.a 4.b
            var self = $(this);
            var selected_phone = $(this).text();
            var click_position="Footer phone clicked";

            //check if link is in footer block if it not in footer, must be in contacts
            if (self.parents("footer").length==0){
                click_position='Contacts phone clicked';
            }

            ga('send', 'event', 'Phone number clicked', click_position, selected_phone.trim());
        })


        //6.. Newsletter - add event for successfully subscribing to the newsletter
        if($('.mc4wp-success').length>0){
            ga('send', 'event', 'Newsletter subscribed', lang);
        }


        //7.. Homepage events - add events for clicking various homepage elements
        //a.. Slider button - add event for clicking the slider button

        $('.main-slider').find('a').click(function(){
            var self=$(this);
            var button_text = self.text();
            var button_url = self.attr("href");
            ga('send', 'event', 'Homepage events', button_text.trim()+' button clicked', button_url);
        });

        //b.. Uzzināt vairāk buttons - add event for clicking one of the “Uzzināt vairāk” buttons (for all languages)
        $('.services').find('a').click(function(){
            var self=$(this);
            var button_text = self.text();
            var button_url = self.attr("href");
            ga('send', 'event', 'Homepage events', button_text.trim()+' button clicked', button_url);
        });

        //c.. Mēs pārstāvam button - add event for clicking the Mēs pārstāvam content block button (for all languages)
        //d.. Apsaktīt visus jaunumus button - add event for clicking the news/blog content block button (for all languages)
        $('#we-represent-button, #all-news').click(function(){
            var self=$(this);
            var button_text = self.text();
            var button_url = self.attr("href");
            ga('send', 'event', 'Homepage events', button_text.trim()+' button clicked', button_url);
        });



        //8.0.. When clicking the CTA buttons that lead to the contacts page - add paramerer "?ref={projektesana}”, which indicates the page from which the user arrived.
        //done in php

        //8.1.. Contact us buttons - add event for clicking the “Contact us” button (for all languages)
        $('a').each(function(){
            var self = $(this);
            var url="";
            url = self.attr("href");

            if(self.hasClass("button")){
                if (url && url.length>0){
                    if (typeof contact_page_link != 'undefined'){
                        if (remove_params_from_url(url) == contact_page_link){
                            self.click(function(){
                                var text = get_link_text(self);
                                ga('send', 'event', 'Contact us button clicked', text.trim()+' button clicked');
                            });
                        }
                    }
                }
            }

            if (typeof url !='undefined'){
                var social_links = get_social_profile_links();
                for (x in social_links){
                    if (url.indexOf(social_links[x].url)!=-1){
                        //1.. Social buttons - add events for clicking the social buttons
                        self.click(function(){
                            var self = $(this);
                            var url="";
                            url = self.attr("href");
                            var text = get_link_text(self);
                            if (text.length==0){
                                var social_links = get_social_profile_links();
                                for (x in social_links) {
                                    if (url.indexOf(social_links[x].url)!=-1) {
                                        text = social_links[x].title;
                                        break;
                                    }
                                }
                            }
                            ga('send', 'event', 'Social button clicked', text);

                        });


                    }
                }
            }
        });

        //9.. Remote support button - add event for clicking the “Remote support” button (for all lang.)
        $('#service-cta-button').parent().click(function(){
            var self  = $(this);
            var button_text  = self.text();
          ga('send', 'event', 'Remote support button clicked', button_text.trim()+' button clicked');
        });

        //10.. TeamViewer downloaded - add event for downloading TeamViewer
        $('#teamviewer-download').parent().click(function(){
          ga('send', 'event', 'TeamViewer downloaded', lang);

        });




    }
);
