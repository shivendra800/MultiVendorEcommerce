<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>

    <tr><td>Dear {{ $name }}!</td></tr>
    <tr><td>&nbsp;</td></tr><br></br>
    <tr><td>Please Click On Below Link To Confirm Your Vendor Account : </td></tr>
    <tr><td><a href="{{ url('vendor/confirm/'.$code) }}">{{ url('vendor/confirm/'.$code) }}</a></td></tr><br></br>
    <tr><td>&nbsp;</td></tr><br></br>
    <tr><td>Thanks & Regards,</td></tr><br></br>
    <tr><td>Shivendra Developer</td></tr>


</body>
</html>
