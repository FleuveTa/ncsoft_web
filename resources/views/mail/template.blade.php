<!DOCTYPE html>
<html>
<head>
    <title>Mail Contact us</title>
</head>
<body>
<div style="text-align: center;">
    <div style="background-image: url('{{ $image }}');width: 150px;" ></div>
    <img src="{{ $message->embed($image) }}" style="width: 200px; object-fit: cover;" alt="logo">
    <h3 style="padding: 10px;">
        <p style="margin: 0;">
            Contact sender: {{ $title ?? '' }}
        </p>
    </h3>
    
    <div class="container">
        <p class="" style="font-size: 16px; text-align: left;" >
            {{ $description ?? '' }}
        </p>
    </div>
</div>


</body>
</html>
