<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChannelsFormRequest;
use App\Models\Channel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $channelList = Channel::with(['user', 'packages'])->latest()->get();

        return view('admin.channels.index', compact('channelList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $channelRecord = new Channel;
        $isEditMode = false;

        return view('admin.channels.form', compact('channelRecord', 'isEditMode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChannelsFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $channelRecord = new Channel;
        $channelRecord->total_channels = (int) $validatedData['total_channels'];
        $channelRecord->user_id = Auth::id();
        $channelRecord->save();

        return redirect()->route('admin.channels.index')
            ->with('successMessage', 'New channel configuration successfully added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Channel $channel): View
    {
        $channelRecord = $channel->load(['user', 'packages']);
        $isEditMode = true;

        return view('admin.channels.form', compact('channelRecord', 'isEditMode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Channel $channel): View
    {
        $channelRecord = $channel;
        $isEditMode = true;

        return view('admin.channels.form', compact('channelRecord', 'isEditMode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChannelsFormRequest $request, Channel $channel): RedirectResponse
    {
        $validatedData = $request->validated();

        $channel->update([
            'total_channels' => (int) $validatedData['total_channels'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.channels.index')
            ->with('successMessage', 'Channel configuration successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Channel $channel): RedirectResponse
    {
        $channel->delete();

        return redirect()->route('admin.channels.index')
            ->with('successMessage', 'Channel configuration deleted successfully.');
    }
}
