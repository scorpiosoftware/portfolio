<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function index()
    {
        $sections = SiteContent::orderBy('id')->get()->groupBy('section');
        $services = Service::orderBy('sort_order')->orderBy('id')->get();

        return view('admin.dashboard', compact('sections', 'services'));
    }

    // ── Site content (text fields) ─────────────────────────────────────────

    public function update(Request $request)
    {
        $request->validate([
            'key'   => 'required|string|exists:site_contents,key',
            'value' => 'nullable|string',
        ]);

        SiteContent::where('key', $request->key)->update(['value' => $request->value ?? '']);

        return response()->json(['success' => true]);
    }

    // ── Services CRUD ──────────────────────────────────────────────────────

    public function storeService(Request $request)
    {
        $data = $request->validate([
            'icon'       => 'nullable|string|max:50',
            'title'      => 'required|string|max:255',
            'subtitle'   => 'nullable|string|max:255',
            'popular'    => 'nullable|boolean',
            'features'   => 'nullable|string',
            'note'       => 'nullable|string|max:255',
            'price'      => 'nullable|string|max:50',
        ]);

        $data['features']   = $this->parseFeatures($data['features'] ?? '');
        $data['popular']    = $request->boolean('popular');
        $data['sort_order'] = Service::max('sort_order') + 1;

        $service = Service::create($data);

        return response()->json(['success' => true, 'service' => $service]);
    }

    public function updateService(Request $request, Service $service)
    {
        $data = $request->validate([
            'icon'     => 'nullable|string|max:50',
            'title'    => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'popular'  => 'nullable|boolean',
            'features' => 'nullable|string',
            'note'     => 'nullable|string|max:255',
            'price'    => 'nullable|string|max:50',
        ]);

        $data['features'] = $this->parseFeatures($data['features'] ?? '');
        $data['popular']  = $request->boolean('popular');

        $service->update($data);

        return response()->json(['success' => true]);
    }

    public function deleteService(Service $service)
    {
        $service->delete();

        return response()->json(['success' => true]);
    }

    // ── Email configuration ────────────────────────────────────────────────

    public function updateEmailConfig(Request $request)
    {
        $data = $request->validate([
            'mail_host'         => 'nullable|string|max:255',
            'mail_port'         => 'nullable|string|max:10',
            'mail_encryption'   => 'nullable|in:tls,ssl,',
            'mail_username'     => 'nullable|string|max:255',
            'mail_password'     => 'nullable|string|max:255',
            'mail_from_address' => 'nullable|string|max:255',
            'mail_from_name'    => 'nullable|string|max:255',
        ]);

        foreach ($data as $key => $value) {
            if ($key === 'mail_password' && empty($value)) {
                continue;
            }
            SiteContent::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '', 'section' => 'email', 'type' => $key === 'mail_password' ? 'password' : 'text', 'label' => $key]
            );
        }

        return response()->json(['success' => true]);
    }

    public function testEmail(Request $request)
    {
        $request->validate(['to' => 'required|email']);

        try {
            Mail::raw(
                'This is a test email from your Scorpio Software admin panel. Your email configuration is working correctly.',
                fn ($msg) => $msg->to($request->to)->subject('Test Email — Scorpio Software')
            );
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    private function parseFeatures(string $raw): array
    {
        return array_values(
            array_filter(
                array_map('trim', explode("\n", $raw))
            )
        );
    }
}
