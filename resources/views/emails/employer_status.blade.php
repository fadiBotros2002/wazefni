<!DOCTYPE html>
<html>
<head>
    <title>Employer Status</title>
</head>
<body>
    <h1>Hello, {{ $user->name }}</h1>

    @if ($status === 'approved')
        <p>Congratulations! Your application to become an employer has been approved.</p>
    @else
        <p>We regret to inform you that your application to become an employer has been rejected.</p>
    @endif

    <p>Thank you for using our service.</p>
</body>
</html>
