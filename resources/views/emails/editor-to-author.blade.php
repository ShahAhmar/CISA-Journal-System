<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message from Editor</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
        <h2 style="color: #0056FF; margin-top: 0;">Message from Editor</h2>
        <p style="margin: 5px 0;"><strong>Journal:</strong> {{ $submission->journal->name }}</p>
        <p style="margin: 5px 0;"><strong>Submission:</strong> {{ $submission->title }}</p>
        <p style="margin: 5px 0;"><strong>From:</strong> {{ $editor->full_name }}</p>
    </div>

    <div style="background-color: #ffffff; padding: 20px; border: 1px solid #e0e0e0; border-radius: 8px; margin-bottom: 20px;">
        <h3 style="color: #333; margin-top: 0;">Message:</h3>
        <div style="white-space: pre-wrap; color: #555;">{{ $body }}</div>
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('author.submissions.show', $submission) }}" style="display: inline-block; background-color: #0056FF; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold;">View Submission</a>
    </div>

    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e0e0e0; font-size: 12px; color: #777; text-align: center;">
        <p>This is an automated email from {{ $submission->journal->name }}.</p>
        <p>Please do not reply to this email. If you have questions, please contact the journal directly.</p>
    </div>
</body>
</html>

