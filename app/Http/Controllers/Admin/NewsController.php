<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('id', 'desc')->get();
        return view('dashboard.news.news', compact('news'));
    }

    public function create()
    {
        return view('dashboard.news.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'tanggal' => 'date|required',
            'minggu' => 'required|max:50',
            'warta' => 'file|max:2048|mimes:pdf|required',
            'keterangan' => 'nullable'
        ]);

        $extension = $request->file('warta')->getClientOriginalExtension();
        $warta = 'warta'. '-' . rand() . '.' . $extension;
        $path = $request->file('warta')->storeAs('warta', $warta, 'public');

        News::create([
            'tanggal' => $request->tanggal,
            'minggu' => $request->minggu,
            'warta' => $warta,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('news.index')->with('status', 'Data Warta Berhasil di Tambahkan');
    }

    public function edit($id)
    {
        $news = News::find($id);
        return view('dashboard.news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $news = News::find($id);
        $validate = $request->validate([
            'tanggal' => 'date|required',
            'minggu' => 'required|max:50',
            'warta' => 'file|max:2048|mimes:pdf|nullable',
            'keterangan' => 'required'
        ]);

        if(is_null($request->file('warte'))) {
            $warta = $news->warta;
        } else {
            $extension = $request->file('warta')->getClientOriginalExtension();
            $warta = 'warta'. '-' . rand() . '.' . $extension;
            $path = $request->file('warta')->storeAs('warta', $warta, 'public');
        }

        News::find($id)->update([
            'tanggal' => $request->tanggal,
            'minggu' => $request->minggu,
            'warta' => $warta,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('news.index')->with('status', 'Data Warta Berhasil di Edit');
    }

    public function destroy($id)
    {
        News::find($id)->delete();
        return redirect()->route('news.index')->with('status', 'Data Warta Berhasil di Hapus');
    }
}
