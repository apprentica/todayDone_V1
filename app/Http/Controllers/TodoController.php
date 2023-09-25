<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class TodoController extends Controller
{
    /**
     *  Display todo items.
     */
    public function index()
    {
        try {
            $todos = Todo::where('is_completed', '0')->get();
            return view('todo.index', compact('todos'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

    }

    /**
     *  Display completed items.
     */
    public function done()
    {
        try {
            $dones = Todo::where('is_completed', '1')->get();
            return view('todo.done', compact('dones'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

    }

        /**
     * Display form to add item.
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Submit new item.
     */
    public function store(Request $request)
    {
        try {
            $todo = Todo::create([
                'title' => $request->title,
                'description' => $request->description
            ]);

            if ($todo) {
                return redirect()->route('todo.index')->with('success', 'Todo list created successfully!');
            }
            return back()->with('error', 'Unable to create todo. Please try again.');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Display chosen item.
     */
    public function show(Todo $todo)
    {
        return view('todo.show', compact('todo'));
    }

    /**
     * Form to edit item.
     */
    public function edit(Todo $todo)
    {
        return view('todo.edit', compact('todo'));
    }

    /**
     * Update an item in db.
     */
    public function update(Request $request, Todo $todo)
    {
        try {
            $todo->update($request->all());
            $todo->save();
            return redirect()->route('todo.index')->with('success', 'Todo list updated successfully!');

        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Delete item from db.
     */
    public function destroy(Todo $todo)
    {
        try {
            if ($todo) {
                $todo->delete();
                return redirect()->route('todo.index')->with('success', 'Todo list deleted successfully!');
            }
            return back()->with('error', 'Todo list not found!');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
