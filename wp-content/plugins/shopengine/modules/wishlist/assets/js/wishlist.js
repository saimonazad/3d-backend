jQuery(document).ready((function(){jQuery(document).on("click","a.shopengine_add_to_list_action",(function(e){if(e.preventDefault(),!shopEngineWishlist.isLoggedIn)return void alert("Please login first.");let s=jQuery(this),i=s.data("pid");jQuery.ajax({type:"POST",url:shopEngineWishlist.resturl+"shopengine-builder/v1/wishlist/add_to_list/",headers:{"X-WP-Nonce":shopEngineWishlist.rest_nonce},data:{product_id:i},beforeSend:function(){console.log("executing.....")},success:function(e){"success"===e.status&&("add"==e.todo?(jQuery("body").append("<div class='parent-notification'><div class=' shopengine-wishlist-message'><p class='shopengine-wishlist-message-content'>Your product is added to wishlist</p></div></div>"),jQuery(".parent-notification").addClass("active"),s.removeClass("inactive").addClass("active"),s.find("svg").css({fill:"orange"})):(jQuery("body").append("<div class='parent-notification'><div class='shopengine-wishlist-message delete-message'><p class='shopengine-wishlist-message-content'>Your product is removed from wishlist</p></div></div>"),jQuery(".parent-notification").addClass("active"),s.removeClass("active").addClass("inactive"),s.find("svg").css({fill:"none"}))),console.log(e.message)},error:function(){alert("Something went wrong")},complete:function(e){console.log("completed...."),setTimeout((function(){jQuery(".parent-notification").removeClass("active")}),3e3)}})})),jQuery(document).on("click",".shopengine-remove-action.remove-from-wishlist",(function(e){e.preventDefault();let s=jQuery(this),i=s.data("pid");i&&jQuery.ajax({type:"POST",url:shopEngineWishlist.resturl+"shopengine-builder/v1/wishlist/add_to_list/",headers:{"X-WP-Nonce":shopEngineWishlist.rest_nonce},data:{product_id:i},success:function(e){if("success"===e.status){let e=s.closest("tr");e.hide("slow",(function(){e.remove()}))}console.log(e.message)},error:function(){alert("Something went wrong")},complete:function(e){console.log("completed....")}})}))}));