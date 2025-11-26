<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category')->latest()->paginate(15);
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.menus.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:1000',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_available' => 'boolean'
        ]);

        $data = $request->except('image');
        $data['is_available'] = $request->has('is_available');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/menus');
            $data['image'] = str_replace('public/', '', $path);
        }

        Menu::create($data);
        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        $categories = Category::all();
        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:1000',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_available' => 'boolean'
        ]);

        $data = $request->except('image');
        $data['is_available'] = $request->has('is_available');

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($menu->image) {
                \Storage::delete('public/menus/' . $menu->image);
            }
            $path = $request->file('image')->store('public/menus');
            $data['image'] = str_replace('public/', '', $path);
        }

        $menu->update($data);
        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->image) {
            \Storage::delete('public/menus/' . $menu->image);
        }
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil dihapus!');
    }
}