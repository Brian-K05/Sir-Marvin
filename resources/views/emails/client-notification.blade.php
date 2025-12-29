<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Notification' }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: #1E40AF; padding: 20px; border-radius: 8px 8px 0 0; color: white;">
        <h2 style="margin: 0; color: white;">Professional Editing Service</h2>
    </div>
    
    <div style="background: #fff; padding: 30px; border: 1px solid #ddd; border-top: none; border-radius: 0 0 8px 8px;">
        @if($greeting)
        <p style="font-size: 16px; margin-bottom: 20px;">{{ $greeting }}</p>
        @endif
        
        @foreach($lines as $line)
        <p style="margin-bottom: 15px;">{{ $line }}</p>
        @endforeach
        
        @if($actionUrl && $actionText)
        <div style="margin: 30px 0; text-align: center;">
            <a href="{{ $actionUrl }}" style="display: inline-block; background: #1E40AF; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; font-weight: 600;">{{ $actionText }}</a>
        </div>
        @endif
    </div>
    
    <div style="margin-top: 20px; padding: 15px; background: #f8f8f8; border-radius: 8px; font-size: 12px; color: #666; text-align: center;">
        <p style="margin: 0;">If you have any questions, please contact us at marvnbuena@gmail.com or 09223549524</p>
    </div>
</body>
</html>

