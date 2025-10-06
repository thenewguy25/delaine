<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You're Invited!</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #374151;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }

        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }

        .content {
            padding: 40px 30px;
        }

        .invitation-details {
            background-color: #f3f4f6;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }

        .invitation-details h3 {
            margin: 0 0 15px 0;
            color: #1f2937;
            font-size: 18px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .detail-label {
            font-weight: 600;
            color: #6b7280;
        }

        .detail-value {
            color: #1f2937;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            margin: 20px 0;
            transition: transform 0.2s ease;
        }

        .cta-button:hover {
            transform: translateY(-2px);
        }

        .cta-container {
            text-align: center;
            margin: 30px 0;
        }

        .expiry-notice {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }

        .expiry-notice p {
            margin: 0;
            color: #92400e;
            font-weight: 500;
        }

        .footer {
            background-color: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }

        .footer p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }

        .footer a {
            color: #667eea;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .role-badge {
            display: inline-block;
            background-color: #dbeafe;
            color: #1e40af;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .role-badge.admin {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .role-badge.custom {
            background-color: #f3f4f6;
            color: #374151;
        }

        @media (max-width: 600px) {
            .container {
                margin: 0;
                border-radius: 0;
            }

            .header,
            .content,
            .footer {
                padding: 20px;
            }

            .detail-row {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>You're Invited!</h1>
            <p>Join {{ $appName }} and get started today</p>
        </div>

        <!-- Main Content -->
        <div class="content">
            <p>Hello!</p>

            <p>You've been invited to join <strong>{{ $appName }}</strong>! We're excited to have you as part of our
                community.</p>

            <!-- Invitation Details -->
            <div class="invitation-details">
                <h3>Invitation Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $invitation->email }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Invitation Type:</span>
                    <span class="detail-value">
                        <span class="role-badge {{ $invitation->invitation_type }}">
                            {{ ucfirst($invitation->invitation_type) }}
                        </span>
                    </span>
                </div>
                @if($invitation->role)
                    <div class="detail-row">
                        <span class="detail-label">Assigned Role:</span>
                        <span class="detail-value">{{ ucfirst($invitation->role) }}</span>
                    </div>
                @endif
                <div class="detail-row">
                    <span class="detail-label">Invited By:</span>
                    <span class="detail-value">{{ $invitation->creator->name }}</span>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="cta-container">
                <a href="{{ $registrationUrl }}" class="cta-button">
                    Complete Your Registration
                </a>
            </div>

            <!-- Expiry Notice -->
            <div class="expiry-notice">
                <p>⏰ This invitation expires on {{ $expiryDate }}</p>
            </div>

            <p>If you have any questions or need assistance, please don't hesitate to reach out to our support team.</p>

            <p>Welcome aboard!</p>
            <p><strong>The {{ $appName }} Team</strong></p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                This invitation was sent to {{ $invitation->email }}.
                If you didn't expect this invitation, you can safely ignore this email.
            </p>
            <p>
                <a href="{{ $registrationUrl }}">Click here to register</a> |
                <a href="{{ config('app.url') }}">Visit {{ $appName }}</a>
            </p>
        </div>
    </div>
</body>

</html>