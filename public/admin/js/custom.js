$(document).ready(function() {

    // Call Datatable class
    $('#sections').DataTable();
    $('#categories').DataTable();
    $('#brands').DataTable();
    $('#filters').DataTable();
    $('#products').DataTable();
    $('#coupons').DataTable();
    $('#orders').DataTable();
    //navbar Active Inactive
    $(".nav-item").removeClass("active");
    $(".nav-link").removeClass("inactive");
    //Check Admin Password is Correct or Not
    $("#current_password").keyup(function() {
        var current_password = $("#current_password").val();
        // alert(current_password);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/check-admin-password",
            data: { current_password: current_password },
            success: function(resp) {
                // alert(resp);
                if (resp == "false") {
                    $("#check_password").html("<font color='red'>Current Password is Incorrect!</font>");
                } else if (resp == "true") {
                    $("#check_password").html("<font color='green'>Current Password is Correct.</font>");
                }
            },
            error: function() {
                alert("Error");
            },
        });
    });

    //update Admin Status
    $(document).on("click", ".updateAdminStatus", function() {
        var status = $(this).children("i").attr("status");
        var admin_id = $(this).attr("admin_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-admin-status",
            data: { status: status, admin_id: admin_id },
            success: function(resp) {
                // alert(resp);
                if (resp['status'] == 0) {
                    $("#admin-" + admin_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='InActive'></i>");
                } else if (resp['status'] == 1) {
                    $("#admin-" + admin_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function() {
                alert("Error");
            }
        })

    });


    //update Section Status
    $(document).on("click", ".updateSectionStatus", function() {
        var status = $(this).children("i").attr("status");
        var section_id = $(this).attr("section_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-section-status",
            data: { status: status, section_id: section_id },
            success: function(resp) {
                // alert(resp);
                if (resp['status'] == 0) {
                    $("#section-" + section_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='InActive'></i>");
                } else if (resp['status'] == 1) {
                    $("#section-" + section_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function() {
                alert("Error");
            }
        })

    });
    $(document).on("click", ".updatepageStatus", function() {
        var status = $(this).children("i").attr("status");
        var page_id = $(this).attr("page_id");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-cmsPage-status",
            data: { status: status, page_id: page_id },
            success: function(resp) {
                // alert(resp);
                if (resp['status'] == 0) {
                    $("#page-" + page_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='InActive'></i>");
                } else if (resp['status'] == 1) {
                    $("#page-" + page_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function() {
                alert("Error");
            }
        })

    });

    //update Brand Status
    $(document).on("click", ".updatebrandStatus", function() {
        var status = $(this).children("i").attr("status");
        var brand_id = $(this).attr("brand_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-brands-status",
            data: { status: status, brand_id: brand_id },
            success: function(resp) {
                // alert(resp);
                if (resp['status'] == 1) {
                    $("#brand-" + brand_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='InActive'></i>");
                } else if (resp['status'] == 0) {
                    $("#brand-" + brand_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function() {
                alert("Error");
            }
        })

    });

    //update Product Status
    $(document).on("click", ".updateproductStatus", function() {
        var status = $(this).children("i").attr("status");
        var product_id = $(this).attr("product_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-products-status",
            data: { status: status, product_id: product_id },
            success: function(resp) {
                // alert(resp);
                if (resp['status'] == 0) {
                    $("#product-" + product_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='InActive'></i>");
                } else if (resp['status'] == 1) {
                    $("#product-" + product_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function() {
                alert("Error");
            }
        })

    });

    //update Filter Status
    $(document).on("click", ".updatefilterStatus", function() {
        var status = $(this).children("i").attr("status");
        var filter_id = $(this).attr("filter_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-filters-status",
            data: { status: status, filter_id: filter_id },
            success: function(resp) {
                // alert(resp);
                if (resp['status'] == 0) {
                    $("#filter-" + filter_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='InActive'></i>");
                } else if (resp['status'] == 1) {
                    $("#filter-" + filter_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function() {
                alert("Error");
            }
        });

    });

    //update Filter Values Status
    $(document).on("click", ".updatefiltervaluesStatus", function() {
        var status = $(this).children("i").attr("status");
        var filter_id = $(this).attr("filter_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-filters-values-status",
            data: { status: status, filter_id: filter_id },
            success: function(resp) {
                // alert(resp);
                if (resp['status'] == 0) {
                    $("#filter-" + filter_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='InActive'></i>");
                } else if (resp['status'] == 1) {
                    $("#filter-" + filter_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function() {
                alert("Error");
            }
        });

    });


    //update Category Status
    $(document).on("click", ".updatecategoryStatus", function() {
        var status = $(this).children("i").attr("status");
        var category_id = $(this).attr("category_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-categorys-status",
            data: { status: status, category_id: category_id },
            success: function(resp) {
                // alert(resp);
                if (resp['status'] == 0) {
                    $("#category-" + category_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='InActive'></i>");
                } else if (resp['status'] == 1) {
                    $("#category-" + category_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function() {
                alert("Error");
            }
        })

    });
    //update Image Status
    $(document).on("click", ".updateimagesStatus", function() {
        var status = $(this).children("i").attr("status");
        var image_id = $(this).attr("image_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-images-status",
            data: { status: status, image_id: image_id },
            success: function(resp) {
                // alert(resp);
                if (resp['status'] == 0) {
                    $("#image-" + image_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='InActive'></i>");
                } else if (resp['status'] == 1) {
                    $("#image-" + image_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function() {
                alert("Error");
            }
        })

    });

    $(document).on("click", ".updateAttributesStatus", function() {
        var status = $(this).children("i").attr("status");
        var attribute_id = $(this).attr("attribute_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-attribute-status",
            data: { status: status, attribute_id: attribute_id },
            success: function(resp) {
                // alert(resp);
                if (resp['status'] == 0) {
                    $("#attribute-" + attribute_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='InActive'></i>");
                } else if (resp['status'] == 1) {
                    $("#attribute-" + attribute_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function() {
                alert("Error");
            }
        })

    });

    //update Brand Status
    $(document).on("click", ".updatecouponStatus", function() {
        var status = $(this).children("i").attr("status");
        var coupon_id = $(this).attr("coupon_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-coupon-status",
            data: { status: status, coupon_id: coupon_id },
            success: function(resp) {

                if (resp['status'] == 1) {
                    $("#coupon-" + coupon_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='InActive'></i>");
                    alert("You want to Active your coupon");
                } else if (resp['status'] == 0) {
                    $("#coupon-" + coupon_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                    alert("You want to InActive your coupon");
                }
            },
            error: function() {
                alert("Error");
            }
        })

    });

    //Conifrm Delete (Simple Javascript)
    // $(".confirmDelete").click(function () {
    //     var title = $(this).attr("title");
    //     if (confirm("Are you sure to delete this " + title + "?")) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // })


    $(document).on("click", ".confirmDelete", function() {
        var module = $(this).attr('module');
        var moduleid = $(this).attr('moduleid');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
                window.location = "/admin/delete-" + module + "/" + moduleid;
            }
        })

    });

    //Append Categories Table
    $("#section_id").change(function() {
        var section_id = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'get',
            url: '/admin/append-categories-level',
            data: { section_id: section_id },
            success: function(resp) {
                $("#appendCategoriesLevel").html(resp);

            },
            error: function() {
                alert("Error");
            }
        })
    });


    //Products Attributes Add Remove Script
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><input type="text" name="size[]" placeholder="size"style="width: 120px;"/><input type="text" name="price[]" placeholder="price"style="width: 120px;"/><input type="text" name="stock[]" placeholder="Stock"style="width: 120px;"/><input type="text" name="sku[]" placeholder="sku"style="width: 120px;"/><a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function() {
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e) {
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });

    // Show Filter on Selection of Category
    $("#category_id").on('change', function() {
        var category_id = $(this).val();
        // alert(category_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: 'category-filters',
            data: { category_id: category_id },
            success: function(resp) {
                $(".loadFilters").html(resp.view);
            }
        });
    });

    // Show/Hide Coupon Field For Manual/Automatic Coupon
    $("#ManualCoupon").click(function() {
        $("#couponField").show();
    });
    $("#AutomaticCoupon").click(function() {
        $("#couponField").hide();
    });

    // show Courier Name and Tracking Number in case of Shipping Order Status
    $("#courier_name").hide();
    $("#tracking_number").hide();
    $("#order_status").on("change", function() {
        if (this.value == "Shipped") {
            $("#courier_name").show();
            $("#tracking_number").show();
        } else {
            $("#courier_name").hide();
            $("#tracking_number").hide();
        }
    });
    // show Courier Name and Tracking Number in case of Shipping Item Order Status
    // $("#item_courier_name").hide();
    // $("#item_tracking_number").hide();
    // $("#order_item_status").on("change",function(){
    //         if(this.value=="Shipped"){
    //          $("#item_courier_name").show();
    //          $("#item_tracking_number").show();
    //         }else{
    //             $("#item_courier_name").hide();
    //             $("#item_tracking_number").hide();
    //         }
    // });

});