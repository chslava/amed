console.log("Subject: Amedical product update script!");

function get_time(){
    return Math.floor(Date.now() / 1000);
}

function action_time(){
    return " ["+(end_time-start_time)+" sek]";
}

var http = require('http');
var host = 'amedical.digitalscore.lv';
var domain_name ="http://amedical.digitalscore.lv/";
var auth = 'Basic ' + new Buffer(":").toString('base64');
var force = "";
var options = {
    host: host,
    port: 80,
    method: "GET",
    path: url,//I don't know for some reason i have to use full url as a path
    auth: 'digitalscore:justdoit'
};


var url = domain_name+'magento/hanza/json/?'+force+'action=get_product_list';
var price_url = domain_name+'magento/hanza/json/?'+force+'action=get_product_list_by_price';
var update_product_url = domain_name+ 'magento/hanza/json/?'+force+'action=add_product&id=';
var update_product_url_skip_no_price_no_image = domain_name+'magento/hanza/json/?'+force+'action=add_product&skip=no_price_no_image&id=';
var debug_url=domain_name+'magento/hanza/json/?'+force+'action=debug_bad_products';
var debug_url_good_url=domain_name+'magento/hanza/json/?'+force+'action=debug_good_products';
var debug_url_no_price_url = domain_name+'magento/hanza/json/?'+force+'action=debug_no_price_products';


var counter=0;
var results=[];
var start_time=get_time();
var global_start_time = get_time();
var end_time=get_time();
var data=[];
var item_counter=0;
var item_count=0;


var today = new Date().toISOString();

function get_data_url(url,callback){
    start_time = get_time();

    http.get(url, function(res){
        var body = '';

        res.on('data', function(chunk){
            body += chunk;
        });

        res.on('end', function(){
            end_time = get_time();
            if (res.statusCode=="200"){
                var result = []
                try {
                    result = JSON.parse(body);
                    callback(result);
                } catch(err) {
                    callback(result);
                }
                callback(result);
            } else {
                callback(result);
            }
        });
    }).on('error', function(e){
        console.log("Got an error: ", e);
    });
    return [];
}

function do_action(url,item,do_next_action){
    
    if (!item){
        return;
    }
    url = url+item;
    
    if (do_next_action){
        item_counter++;    
    }
    
    var local_options = options;
    local_options.path =url;
    console.log("");
    console.log("["+item_counter+"/"+item_count+"] Working on item: "+item);
    console.log(url);

    start_time = get_time();
    http.get(local_options, function(res){
        var body = '';

        res.on('data', function(chunk){
            body += chunk;
        });

        res.on('end', function(){
            end_time = get_time();
            if (res.statusCode=="200"){
                var result = JSON.parse(body);
                //console.log(body);
                if (result['status']){
                    console.log("Done! "+result['message']+action_time());
                } else {
                    console.log("Failed! "+result['message']+action_time());
                }

            } else {
                console.log("Failed, possible server error. "+url+" "+res.statusCode+action_time());
                console.log(body);
            }

            // var url = update_product_url;
            
            if (!do_next_action){
                return;
            }
            
            
            var item = data.shift();
            var url = update_product_url;
            if (data.length>0){
                do_action(url,item,do_next_action);
                
            } else {
                console.log("----------------------");
                console.log("Finished "+today);
                console.log("----------------------");
                console.log("Done in "+(get_time()-global_start_time));
            }
            //

        });
    }).on('error', function(e){
        console.log("Got an error: ", e);
    });
}

if (process.argv[4]=="force"){
    force="force=1&";
}

if ((typeof process.argv[2])=="string"){


    switch(process.argv[2]){
        case "bad_products":
            console.log("");
            console.log("---------------------------------");
            console.log("Bad products");
            console.log("---------------------------------");

            get_data_url(debug_url, function(data) {
                // use the return value here instead of like a regular (non-evented) return value
                console.log("Testing done! "+action_time());
                for(x in data){
                    console.log(x+" : "+data[x]['error']+" : "+data[x]['value']);
                }
            });
            return;
            break;
        case "good_products":
            console.log("");
            console.log("---------------------------------");
            console.log("Good products");
            console.log("---------------------------------");

            get_data_url(debug_url_good_url, function(data) {
                // use the return value here instead of like a regular (non-evented) return value
                console.log("Testing done! "+action_time());
                for(x in data){
                    console.log(x+" : "+data[x]['error']+" : "+data[x]['value']);
                }
            });
            return;
            break;
        case "no_price_products":
            console.log("");
            console.log("---------------------------------");
            console.log("No price products");
            console.log("---------------------------------");

            get_data_url(debug_url_no_price_url, function(data) {
                // use the return value here instead of like a regular (non-evented) return value
                console.log("Testing done! "+action_time());
                for(x in data){
                    console.log(x+" : "+data[x]['error']+" : "+data[x]['value']);
                }
            });
            return;
            break;
        case  "skip_no_price_no_image":

            console.log("Starting up!");
            console.log("Getting product ids!");

            console.log("");
            console.log("----------------------");
            console.log("Syncing product data");
            console.log("----------------------");

            start_time = get_time();
            http.get(url, function(res){
                var body = '';

                res.on('data', function(chunk){
                    body += chunk;
                });

                res.on('end', function(){

                    //console.log(data);
                    end_time = get_time();
                    if (res.statusCode=="200"){
                        data = JSON.parse(body);
                        console.log("We got data ("+data.length+" items)"+action_time());
                    } else {
                        console.log("Failed, possible server error. "+url+" "+res.statusCode+action_time());
                        console.log(body);;
                    }

                    //sofar so good
                    if (data.length>0){
                        item = data.shift();
                        do_action(update_product_url_skip_no_price_no_image,item);
                    } else {
                        console.log("No data."+action_time());
                    }

                });
            }).on('error', function(e){
                console.log("Got an error: ", e);
            });
            return;
            break;
        case "domain":

            host = process.argv[3];
            domain_name = "http://"+process.argv[3]+"/";

            url = domain_name+'magento/hanza/json/?'+force+'action=get_product_list';
            price_url = domain_name+'magento/hanza/json/?'+force+'action=get_product_list_by_price';
            update_product_url = domain_name+ 'magento/hanza/json/?'+force+'action=add_product&id=';
            update_product_url_skip_no_price_no_image = domain_name+'magento/hanza/json/?'+force+'action=add_product&skip=no_price_no_image&id=';
            debug_url=domain_name+'magento/hanza/json/?'+force+'action=debug_bad_products';
            debug_url_good_url=domain_name+'magento/hanza/json/?'+force+'action=debug_good_products';
            debug_url_no_price_url = domain_name+'magento/hanza/json/?'+force+'action=debug_no_price_products';


            auth = 'Basic ' + new Buffer(":").toString('base64');
            options = {
                host: host,
                port: 80,
                method: "GET",
                path: url,//I don't know for some reason i have to use full url as a path
                auth: 'digitalscore:justdoit'
            };
            break;
    }




}


console.log("Starting up!");
console.log("Getting product ids!");

console.log("");
console.log("----------------------");
console.log("Syncing product data. "+today);
console.log("----------------------");

start_time = get_time();


var local_options = options;
local_options.path =url;


http.get(local_options, function(res){
    var body = '';

    res.on('data', function(chunk){
        body += chunk;
    });

    res.on('end', function(){

        end_time = get_time();
        if (res.statusCode=="200"){
            data = JSON.parse(body);
            console.log("We got data ("+data.length+" items for update)"+action_time());
        } else {
            console.log("Failed, possible server error. "+url+" "+res.statusCode+action_time());
            console.log(body);
        }



        //sofar so good
        item_counter++;
        if (data.length>0){
            item_count = data.length;
            item = data.shift();
            do_action(update_product_url,item,true);
        } else {
            console.log("No data."+action_time());
        }

    });
}).on('error', function(e){
    console.log("Got an error: ", e);
});



