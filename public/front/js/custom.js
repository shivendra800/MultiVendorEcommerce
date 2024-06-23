$(document).ready(function () {

      $("#getPrice").on ("change" ,function(){

            var size = $(this).val();
            var product_id = $(this).attr("product-id");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "/get-productPrice-withSize",
                data: { size: size, product_id: product_id },
                success: function (resp) {
                    // alert(resp['final_price']);
                    if(resp['discount']>0){
                         $(".getAttributePrice").html("<div class='price'><h4>Rs."+resp['final_price']+"</h4></div><div class='original-price'> <span>Original Price:</span><span>Rs."+resp['product_price']+"</span></div>");
                    }else{
                        $(".getAttributePrice").html("<div class='price'><h4>Rs."+resp['final_price']+"</h4></div>");
                    }
                }, error: function () {
                    alert("Error");
                }
            });
      });

      // Update Cart Item QTY
     $(document).on('click','.updateCartItem',function(){
       if($(this).hasClass('plus-a')){
        // Get Qty
        var quantity = $(this).data('qty');
        // Increase the Qty by 1
        new_qty =parseInt(quantity) + 1;
       }
       if($(this).hasClass('minus-a')){
        // Get Qty
        var quantity = $(this).data('qty');
        // Check Qty is Atleast 1
        if(quantity<=1){
            alert("Item Quantity Must Be 1 or Greater !");
            return false;
        }
        // desrease the Qty by 1
        new_qty =parseInt(quantity) - 1;
        // alert(new_qty);
       }
       var cartid = $(this).data('cartid');
       $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
           data:{cartid:cartid,qty:new_qty},
           url:'cart/update',
           type:'post',
           success:function(resp){
              // alert(resp.status);
              $(".totalCartItems").html(resp.totalCartItems);
              if(resp.status==false){
                alert(resp.message);
              }
              $("#appendCartItems").html(resp.view);
              $("#appendHeaderCartItems").html(resp.headerview);
           },error:function(){
               alert("Error");
           }
       });
     });

           // Delete Cart Item QTY
           $(document).on('click','.deleteCartitem',function(){

            var cartid = $(this).data('cartid');
            var result =confirm("Are You sure To Delete This Cart Item?");
             if(result){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                       data:{cartid:cartid},
                       url:'cart/delete',
                       type:'post',
                       success:function(resp){
                          // alert(resp.status);
                          $(".totalCartItems").html(resp.totalCartItems);
                          $("#appendCartItems").html(resp.view);
                          $("#appendHeaderCartItems").html(resp.headerview);
                       },error:function(){
                           alert("Error");
                       }
                   });
             }

          });
  // show loader on placing order
          $(document).on('click','#placeOrder',function(){
            $(".loader").show();
          });

          // Register Form Validation
          $("#registerForm").submit(function(){
            $(".loader").show();
              var formdata = $(this).serialize();
            //   alert(formdata);
            //   return false;
            $.ajax({

                    url:"/user/register",
                    type:"POST",
                    data:formdata,
                    success:function(resp){
                       // alert(resp.type);
                       if(resp.type=="error"){
                        $(".loader").hide();
                           $.each(resp.errors,function(i,error){
                                  $("#register-"+i).attr('style','color:red');
                                  $("#register-"+i).html(error);

                           setTimeout(function () {
                               $("#register-"+i).css({'display':'none'});
                             },3000);
                            });
                       }else if(resp.type=="success"){
                          //  alert(resp.message);
                            $(".loader").hide();
                            $("#register-success").attr('style','color:green');
                            $("#register-success").html(resp.message);
                        //   window.location.href = resp.url;
                       }
                },error:function(){
                    alert("Error");
                }
            });
          });

          // Login Form Validation
          $("#loginForm").submit(function(){
            var formdata = $(this).serialize();
          //   alert(formdata);
          //   return false;
          $.ajax({

                  url:"/user/login",
                  type:"POST",
                  data:formdata,
                  success:function(resp){
                     // alert(resp.type);
                     if(resp.type=="error"){
                         $.each(resp.errors,function(i,error){
                                $("#login-"+i).attr('style','color:red');
                                $("#login-"+i).html(error);

                         setTimeout(function () {
                             $("#login-"+i).css({'display':'none'});
                           },3000);
                          });
                     }else if(resp.type=="incorrect"){
                       // alert(resp.message);
                        $("#login-error").attr('style','color:red');
                        $("#login-error").html(resp.message);
                     }else if(resp.type=="inactive"){
                        // alert(resp.message);
                         $("#login-error").attr('style','color:red');
                         $("#login-error").html(resp.message);
                      }
                     else if(resp.type=="success"){
                        window.location.href = resp.url;
                    }
              },error:function(){
                  alert("Error");
              }
          });
        });

          // forgot Form Validation
          $("#forgotForm").submit(function(){
             $(".loader").show();
              var formdata = $(this).serialize();
            //   alert(formdata);
            //   return false;
            $.ajax({

                    url:"/user/forget-password",
                    type:"POST",
                    data:formdata,
                    success:function(resp){
                       // alert(resp.type);
                       if(resp.type=="error"){
                        $(".loader").hide();
                           $.each(resp.errors,function(i,error){
                                  $("#forgot-"+i).attr('style','color:red');
                                  $("#forgot-"+i).html(error);

                           setTimeout(function () {
                               $("#forgot-"+i).css({'display':'none'});
                             },3000);
                            });
                       }else if(resp.type=="success"){
                          //  alert(resp.message);
                            $(".loader").hide();
                            $("#forgot-success").attr('style','color:green');
                            $("#forgot-success").html(resp.message);
                        //   window.location.href = resp.url;
                       }
                },error:function(){
                    alert("Error");
                }
            });
          });

            // Account Form Validation
            $("#accountForm").submit(function(){
                $(".loader").show();
                  var formdata = $(this).serialize();
                //   alert(formdata);
                //   return false;
                $.ajax({

                        url:"/user/account",
                        type:"POST",
                        data:formdata,
                        success:function(resp){
                           // alert(resp.type);
                           if(resp.type=="error"){
                            $(".loader").hide();
                               $.each(resp.errors,function(i,error){
                                      $("#account-"+i).attr('style','color:red');
                                      $("#account-"+i).html(error);

                               setTimeout(function () {
                                   $("#account-"+i).css({'display':'none'});
                                 },3000);
                                });
                           }else if(resp.type=="success"){
                              //  alert(resp.message);
                                $(".loader").hide();
                                $("#account-success").attr('style','color:green');
                                $("#account-success").html(resp.message);

                               setTimeout(function () {
                                $("#account-success").css({'display':'none'});
                              },3000);
                            //   window.location.href = resp.url;
                           }
                    },error:function(){
                        alert("Error");
                    }
                });
              });

               // Update Password Form Validation
            $("#passwordForm").submit(function(){
                $(".loader").show();
                  var formdata = $(this).serialize();
                //   alert(formdata);
                //   return false;
                $.ajax({

                        url:"/user/update-password",
                        type:"POST",
                        data:formdata,
                        success:function(resp){
                           // alert(resp.type);
                           if(resp.type=="error"){
                            $(".loader").hide();
                               $.each(resp.errors,function(i,error){
                                      $("#password-"+i).attr('style','color:red');
                                      $("#password-"+i).html(error);

                               setTimeout(function () {
                                   $("#password-"+i).css({'display':'none'});
                                 },3000);
                                });
                           }else if(resp.type=="incorrect"){
                            $(".loader").hide();

                                      $("#password-error").attr('style','color:red');
                                      $("#password-error").html(resp.message);

                               setTimeout(function () {
                                   $("#password-error").css({'display':'none'});
                                 },3000);
                           }
                           else if(resp.type=="success"){
                              //  alert(resp.message);
                                $(".loader").hide();
                                $("#password-success").attr('style','color:green');
                                $("#password-success").html(resp.message);

                               setTimeout(function () {
                                $("#password-success").css({'display':'none'});
                              },3000);
                            //   window.location.href = resp.url;
                           }
                    },error:function(){
                        alert("Error");
                    }
                });
              });

              //Apply Coupon
              $("#ApplyCoupon").submit(function(){
                // $(".loader").show();
                var user = $(this).attr("user");
             // alert(user);
                if(user==1){
                     //do nothing
                }
                else{
                    alert("Please Login To Apply Coupon!");
                    return false;
                }
                var code = $("#code").val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    url:"/apply-coupon",
                    type:"POST",
                    data:{code:code },
                    success:function(resp){
                          if(resp.message!=""){
                            alert(resp.message);
                          }
                          $(".totalCartItems").html(resp.totalCartItems);
                          $("#appendCartItems").html(resp.view);
                          $("#appendHeaderCartItems").html(resp.headerview);
                          if(resp.couponAmount>0){
                            $(".couponAmount").text("Rs."+resp.couponAmount);
                          }else{
                            $(".couponAmount").text("Rs.0");
                          }
                          if(resp.grand_total>0){
                            $(".grand_total").text("Rs."+resp.grand_total);
                          }
                    },error:function(){
                        alert("Error");
                    }
                })
              });

              // Edit Delivery Address of user
              $(document).on('click','.editAddress',function(){
                // $(".loader").show();
                var addressid = $(this).data("addressid");
               // alert(addressid);
               $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                    data:{addressid:addressid},
                    url:'/get-delivery-address',
                    type:'post',
                    success:function(resp){
                        $("#showdifferent").removeClass("collapse");
                        $("#newAddress").hide();
                        $(".deliveryText").text("Edit Delivery Address");
                        $('[name=delivery_id]').val(resp.address['id']);
                        $('[name=delivery_name]').val(resp.address['name']);
                        $('[name=delivery_address]').val(resp.address['address']);
                        $('[name=delivery_country]').val(resp.address['country']);
                        $('[name=delivery_state]').val(resp.address['state']);
                        $('[name=delivery_city]').val(resp.address['city']);
                        $('[name=delivery_pincode]').val(resp.address['pincode']);
                        $('[name=delivery_mobile]').val(resp.address['mobile']);
                    },error:function(){
                        alert("Error");
                    }
               });
          });

          //save Delivery Address
          $(document).on('submit',"#addressAddEditForm",function(){
            var formdata = $("#addressAddEditForm").serialize();
           // alert(formdata);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                 url:'/save-delivery-address',
                 type:'post',
                 data:formdata,
                 success:function(resp){
                    if(resp.type=="error"){
                        $(".loader").hide();
                           $.each(resp.errors,function(i,error){
                                  $("#delivery-"+i).attr('style','color:red');
                                  $("#delivery-"+i).html(error);

                           setTimeout(function () {
                               $("#delivery-"+i).css({'display':'none'});
                             },3000);
                            });
                       }else{
                           $("#deliveryAddresses").html(resp.view);
                           window.location.href ="checkout";
                       }
                 },error:function(){
                    alert("Error");

                 }
            });
          })

          //Remove  Delivery Address
          $(document).on('click','.removeAddress',function(){
              if(confirm("Are You Sure To Remove This Delivery Address??")){
                var addressid = $(this).data("addressid");
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                     url:'/remove-delivery-address',
                     type:'post',
                     data:{addressid:addressid},
                     success:function(resp){
                        $("#deliveryAddresses").html(resp.view);
                        window.location.href ="checkout";
                     },error:function(){
                        alert("Error");
                     }
                    });
              }
          });
});

function get_filter(class_name) {
    var filter = [];
    // alert(filter);

    $('.' + class_name + ':checked').each(function () {
        filter.push($(this).val());

    });
    return filter;
    // alert(filter);

}


