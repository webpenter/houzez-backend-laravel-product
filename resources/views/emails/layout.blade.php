<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $subject ?? 'Buy WebPenter' }}</title>
</head>
<body style="margin:0;padding:0;background:#f5f6fa;font-family:Arial, Helvetica, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f6fa;padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 2px 6px rgba(0,0,0,.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background:#2c3e50;color:#fff;padding:20px;text-align:center;font-size:22px;font-weight:bold;">
                            Buy WebPenter
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px;">
                            @yield('content')
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f1f2f6;padding:20px;text-align:center;font-size:13px;color:#666;">
                            © {{ date('Y') }} Buy WebPenter. All Rights Reserved.<br>
                            <a href="{{ url('/') }}" style="color:#2c3e50;text-decoration:none;">Visit Website</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
