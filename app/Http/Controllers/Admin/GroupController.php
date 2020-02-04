<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::all();

        return view('admin.groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'color' => 'required',
            'is_dark' => 'required|boolean'
        ]);

        $group = new Group($request->all());
        $group->save();

        return redirect('admin.groups.index')->with('success', 'Groupe sauegardé');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        return redirect('admin.groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required',
            'color' => 'required',
            'is_dark' => 'required|boolean'
        ]);

        $group->update($request->all());
        $group->save();

        return redirect('admin.groups.index')->with('success', 'Groupe sauvegardé');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();

        return redirect('admin.groups.index')->with('success', 'Groupe supprimé');
    }
}
