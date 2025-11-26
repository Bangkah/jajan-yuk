<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::all();
        return view('menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:4',
            'harga'=> 'required|integer',
            'gambar' => 'required|image|max:2048'
        ]);

        $image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('menus', 'public');
        }

        Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $image,
            'promo' => $request->promo ? 1 : 0
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
   
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('menu.edit', compact('menu'));   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         $menu = Menu::findOrFail($id);

        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|integer',
        ]);

        $image = $menu->image;
        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $image = $request->file('image')->store('menus', 'public');
        }

        $menu->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $image,
            'promo' => $request->promo ? 1 : 0
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui!');
      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}
