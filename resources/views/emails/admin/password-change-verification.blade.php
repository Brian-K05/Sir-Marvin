<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Changed Successfully</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: #1E40AF; padding: 20px; border-radius: 8px 8px 0 0; color: white;">
        <h2 style="margin: 0; color: white;">Admin Account - Password Changed</h2>
    </div>
    
    <div style="background: #fff; padding: 30px; border: 1px solid #ddd; border-top: none; border-radius: 0 0 8px 8px;">
        <p style="font-size: 16px; margin-bottom: 20px;">Hello {{ $admin->name }},</p>
        
        <p style="margin-bottom: 15px;">This email confirms that your admin account password has been successfully changed.</p>
        
        <div style="background: #f0f9ff; border-left: 4px solid #1E40AF; padding: 15px; margin: 20px 0; border-radius: 4px;">
            <p style="margin: 0; font-weight: 600; color: #1E40AF;">Account Details:</p>
            <ul style="margin: 10px 0 0 20px; padding: 0;">
                <li><strong>Email:</strong> {{ $admin->email }}</li>
                <li><strong>Changed At:</strong> {{ $timestamp }}</li>
            </ul>
        </div>
        
        <p style="margin-bottom: 15px; color: #dc2626; font-weight: 600;">⚠️ Security Notice:</p>
        <p style="margin-bottom: 15px;">If you did not make this change, please contact the system administrator immediately and secure your account.</p>
        
        <p style="margin-bottom: 15px;">For security reasons, if you suspect any unauthorized access, please:</p>
        <ul style="margin-bottom: 20px; padding-left: 20px;">
            <li>Change your password again immediately</li>
            <li>Review your account activity</li>
            <li>Contact support if needed</li>
        </ul>
    </div>
    
    <div style="margin-top: 20px; padding: 15px; background: #f8f8f8; border-radius: 8px; font-size: 12px; color: #666; text-align: center;">
        <p style="margin: 0;">This is an automated security notification. Please do not reply to this email.</p>
        <p style="margin: 5px 0 0 0;">If you have any questions, please contact us at marvnbuena@gmail.com or 09223549524</p>
    </div>
</body>
</html>

