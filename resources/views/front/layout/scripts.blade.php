<?php use App\Models\ProductsFilter;
$productFilters=ProductsFilter::productFilters();

?>

<script>
    $(document).ready(function() {

        //sorting But Page refresh
        // $("#sort").on("change", function () {
        // // this.form.submit();
        // });
        //sorting But with out Page refresh
        $("#sort").on("change", function () {
        var sort = $("#sort").val();
        var url = $("#url").val();
        var price = get_filter('price');
        var color = get_filter('color');
        var size = get_filter('size');
        var brand = get_filter('brand');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: 'Post',
            data: { sort: sort, url: url, size: size, color: color, price: price, brand: brand },
            success: function (data) {
                $('.filter_products').html(data);
            }, error: function () {
                alert("Error");
            }
        });
    });

        // Size Filter
        $(".size").on("change", function() {
         //   alert(size);
            var size = get_filter('size');
            var color = get_filter('color');
            var price = get_filter('price');
            var brand = get_filter('brand');
            var sort = $("#sort").val();
            var url = $("#url").val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                 url: url,
                 method: 'Post',
                 data: {

                     sort: sort, url: url, size:size, color:color,price:price,brand:brand},
                 success: function(data) {
                    $('.filter_products').html(data);
                }, error: function() {
                    alert("Error");
                }
            });
        });


         //Color Filter
         $(".color").on("change", function() {

            var color = get_filter('color');
            var size = get_filter('size');
            var price = get_filter('price');
            var brand = get_filter('brand');
            var sort = $("#sort").val();
            var url = $("#url").val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                 url: url,
                 method: 'Post',
                 data: {

                     sort: sort, url: url, size:size, color:color,price:price,brand:brand},
                 success: function(data) {
                    $('.filter_products').html(data);
                }, error: function() {
                    alert("Error");
                }
            });
        });

           //Price Filter
           $(".price").on("change", function() {
                 var price = get_filter('price');
                var color = get_filter('color');
                var size = get_filter('size');
                var brand = get_filter('brand');
                var sort = $("#sort").val();
                var url = $("#url").val();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    method: 'Post',
                    data: {

                        sort: sort, url: url, size:size, color:color,price:price,brand:brand},
                    success: function(data) {
                        $('.filter_products').html(data);
                    }, error: function() {
                        alert("Error");
                  }
                 });
             });

                  //Brand Filter
           $(".brand").on("change", function() {
                var brand = get_filter('brand');
                var price = get_filter('price');
                var color = get_filter('color');
                var size = get_filter('size');
                var sort = $("#sort").val();
                var url = $("#url").val();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    method: 'Post',
                    data: {

                        sort: sort, url: url, size:size, color:color,price:price,brand:brand},
                    success: function(data) {
                        $('.filter_products').html(data);
                    }, error: function() {
                        alert("Error");
                  }
                 });
             });



            // Filter
        @foreach($productFilters as $filter)
        $('.{{ $filter['filter_column'] }}').on('click', function() {
             alert({{ $filter['filter_column'] }});
            var price = get_filter('price');
            var color = get_filter('color');
            var size = get_filter('size');
            var brand = get_filter('brand');
            var url = $("#url").val;
            var sort = $("#sort option:selected").val();
            @foreach($productFilters as $filters)
            var {{ $filters['filter_column'] }} = get_filter('{{ $filters['filter_column'] }}');
            @endforeach

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                 url: url,
                 method: "Post",
                 data: {
                    @foreach($productFilters as $filters)
                    {{ $filters['filter_column'] }}: {{ $filters['filter_column'] }},
                    @endforeach
                    url: url, sort: sort, size:size, color:color,price:price,brand:brand},

             success: function(data) {

                    $('.filter_products').html(data);

                  }, error: function() {
                     alert("Error");
                }
            });

        });
        @endforeach



    });

</script>
