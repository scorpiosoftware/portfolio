<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\SiteContent;
use Illuminate\Http\Request;

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

    private function parseFeatures(string $raw): array
    {
        return array_values(
            array_filter(
                array_map('trim', explode("\n", $raw))
            )
        );
    }
}
