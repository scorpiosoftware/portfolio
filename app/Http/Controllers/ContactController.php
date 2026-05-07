<?php

namespace App\Http\Controllers;

use App\Models\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Honeypot: bots fill this field, humans never see it
        if ($request->filled('website')) {
            return response()->json(['success' => true]);
        }

        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'phone'   => 'nullable|string|max:30',
            'company' => 'nullable|string|max:100',
            'service' => 'required|string|max:100',
            'budget'  => 'nullable|string|max:50',
            'message' => 'required|string|min:10|max:2000',
        ]);

        $to      = SiteContent::where('key', 'contact_email')->value('value')
                    ?: config('mail.from.address');

        $name    = e($data['name']);
        $email   = e($data['email']);
        $phone   = e($data['phone']   ?? '');
        $company = e($data['company'] ?? '');
        $service = e($data['service']);
        $budget  = e($data['budget']  ?? '');
        $message = nl2br(e($data['message']));

        $optionalRows = '';
        if ($phone)   $optionalRows .= self::emailRow('Phone',   "<a href='tel:{$phone}' style='color:#6366f1;'>{$phone}</a>");
        if ($company) $optionalRows .= self::emailRow('Business / Company', $company);
        if ($budget)  $optionalRows .= self::emailRow('Budget Range', "<span style='display:inline-block;background:#ede9fe;color:#6d28d9;padding:2px 10px;border-radius:20px;font-size:13px;font-weight:600;'>{$budget}</span>");

        $html = <<<HTML
        <!DOCTYPE html>
        <html>
        <body style="margin:0;padding:0;background:#f3f4f6;font-family:Arial,sans-serif;">
          <table width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f6;padding:40px 20px;">
            <tr><td align="center">
              <table width="560" cellpadding="0" cellspacing="0"
                style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08);">
                <tr>
                  <td style="background:linear-gradient(135deg,#6366f1,#8b5cf6);padding:32px;text-align:center;">
                    <h1 style="color:#fff;margin:0;font-size:22px;font-weight:700;">New Quote Request</h1>
                    <p style="color:rgba(255,255,255,.75);margin:6px 0 0;font-size:13px;">Scorpio Software — scorpiosoft.tech</p>
                  </td>
                </tr>
                <tr>
                  <td style="padding:32px;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                      {$optionalRows}
                      <tr><td style="padding:12px 0;border-bottom:1px solid #f0f0f0;">
                        <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6b7280;">Name</span>
                        <div style="color:#111827;margin-top:4px;font-size:15px;">{$name}</div>
                      </td></tr>
                      <tr><td style="padding:12px 0;border-bottom:1px solid #f0f0f0;">
                        <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6b7280;">Email</span>
                        <div style="margin-top:4px;">
                          <a href="mailto:{$email}" style="color:#6366f1;font-size:15px;">{$email}</a>
                        </div>
                      </td></tr>
                      <tr><td style="padding:12px 0;border-bottom:1px solid #f0f0f0;">
                        <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6b7280;">Service Needed</span>
                        <div style="color:#111827;margin-top:4px;font-size:15px;">{$service}</div>
                      </td></tr>
                      <tr><td style="padding:12px 0;">
                        <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6b7280;">Message</span>
                        <div style="color:#374151;margin-top:8px;font-size:15px;line-height:1.7;">{$message}</div>
                      </td></tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="background:#f9fafb;padding:20px 32px;border-top:1px solid #f0f0f0;text-align:center;">
                    <p style="color:#9ca3af;font-size:12px;margin:0;">Hit Reply to respond directly to {$name}</p>
                  </td>
                </tr>
              </table>
            </td></tr>
          </table>
        </body>
        </html>
        HTML;

        try {
            Mail::html($html, function ($msg) use ($data, $to) {
                $msg->to($to)
                    ->replyTo($data['email'], $data['name'])
                    ->subject("New Quote Request — {$data['service']}");
            });

            return response()->json(['success' => true]);
        } catch (\Throwable) {
            return response()->json(['success' => false, 'error' => 'Failed to send. Please try again.'], 500);
        }
    }

    private static function emailRow(string $label, string $value): string
    {
        return "<tr><td style='padding:12px 0;border-bottom:1px solid #f0f0f0;'>
          <span style='font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6b7280;'>{$label}</span>
          <div style='color:#111827;margin-top:4px;font-size:15px;'>{$value}</div>
        </td></tr>";
    }
}
