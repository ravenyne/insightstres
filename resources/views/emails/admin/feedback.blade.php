<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Baru</title>
</head>
<body style="background-color: #f3f4f6; padding: 20px; font-family: sans-serif;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="background-color: #f97316; padding: 20px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">Feedback Baru</h1>
        </div>

        <!-- Content -->
        <div style="padding: 30px;">
            <p style="color: #374151; font-size: 16px; margin-bottom: 20px;">
                Halo Admin, ada feedback baru yang masuk!
            </p>

            <div style="background-color: #f9fafb; padding: 20px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #e5e7eb;">
                <p style="margin: 0 0 10px 0;"><strong>Dari:</strong> {{ $feedback->user->name }} ({{ $feedback->user->email }})</p>
                <p style="margin: 0 0 10px 0;"><strong>Tipe:</strong> <span style="display:inline-block; padding: 2px 8px; border-radius: 9999px; background-color: #e0e7ff; color: #3730a3; font-size: 12px; font-weight: bold;">{{ ucfirst($feedback->type) }}</span></p>
                <p style="margin: 0 0 10px 0;"><strong>Subjek:</strong> {{ $feedback->subject }}</p>
                <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 15px 0;">
                <p style="margin: 0 0 5px 0; color: #6b7280; font-size: 14px;">Pesan:</p>
                <p style="margin: 0; white-space: pre-wrap;">{{ $feedback->message }}</p>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ url('/admin/feedback') }}" style="display: inline-block; background-color: #f97316; color: #ffffff; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold;">
                    Lihat Feedback
                </a>
            </div>
        </div>
        
        <!-- Footer -->
        <div style="background-color: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
            <p style="color: #9ca3af; font-size: 12px; margin: 0;">&copy; {{ date('Y') }} Insight Stress Admin Panel</p>
        </div>
    </div>
</body>
</html>
