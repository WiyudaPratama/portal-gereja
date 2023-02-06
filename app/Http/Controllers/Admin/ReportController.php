<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::orderBy('id', 'desc')->get();
        return view('dashboard.report.index', compact('reports'));
    }

    public function create()
    {
        return view('dashboard.report.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required',
            'thumbnail' => 'required|image|max:1024|mimes:jpeg,jpg,png',
            'news' => 'required'
        ]);

        $extenstion = $request->file('thumbnail')->getClientOriginalExtension();
        $imageName = 'thumbnail' . '-' . rand() . '.' .$extenstion;
        $path = $request->file('thumbnail')->storeAs('thumbnail', $imageName, 'public');

        $report = Report::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'thumbnail' => $imageName,
            'news' => $request->news
        ]);

        return redirect()->route('berita.index')->with('status', 'Berita Baru Gereja Berhasil di Tambahkan');
    }
}
