<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
     <table>
    <tr><td>Dear {{ $name }}!</td></tr>
    <tr><td>&nbsp;</td></tr><br></br>
    <tr><td>Welcome To Shivendra Developers.Your Account Has Been Created Successfully  With Below Given Information : </td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>Name:{{ $name }}</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>Email:{{ $email }}</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>Mobile:{{ $mobile }}</td></tr>
    <tr><td>&nbsp;</td></tr>
    {{-- <tr><td>Password:{{ $password }}</td></tr> --}}
    <tr><td>&nbsp;</td></tr>
    <tr><td>Thanks & Regards,</td></tr><br></br>
    <tr><td>Shivendra Developer</td></tr>
</table>

</body>
</html>
