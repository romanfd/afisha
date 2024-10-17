<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $categories = Category::all();

        $query = Event::query()->where('is_published', true);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        $events = $query->paginate(20);

        return view('events.index', compact('user', 'events', 'categories'));
    }

    //Event admin
    public function toggleEventStatus($eventId)
    {
        $event = Event::findOrFail($eventId);
        $event->is_published = !$event->is_published;
        $event->save();

        return redirect()->back()->with('status', 'Статус мероприятия изменен.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->back()->with('status', 'Мероприятие удалено.');
    }


    //Event users
    public function register($eventId)
    {
        $user = auth()->user();

        if ($user->events->contains($eventId)) {
            return redirect()->route('home')->with('success', 'Вы уже зарегистрированы на это мероприятие.');
        }

        $user->events()->attach($eventId, [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('home')->with('success', 'Вы успешно зарегистрировались на мероприятие.');
    }

    public function cancel($eventId)
    {
        $user = auth()->user();

        if (!$user->events->contains($eventId)) {
            return redirect()->route('user')->with('error', 'Вы не зарегистрированы на это мероприятие.');
        }

        $user->events()->detach($eventId);

        return redirect()->route('user')->with('success', 'Вы успешно отменили регистрацию на мероприятие.');
    }
}
