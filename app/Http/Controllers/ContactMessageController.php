<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContactMessageController extends Controller
{
    public function list()
    {
        $contact_message_list = ContactMessage::latest()->get();

        return view('backend.contact_message.list', compact('contact_message_list'));
    } // End Method

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $data = ContactMessage::findOrFail($id);

            $data->delete();

            DB::commit();

            return redirect()
                ->route('admin.contact_message.list')
                ->with([
                    'message' => 'Contact Message deleted successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error deleting Contact Message: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with([
                    'message' => 'Failed to delete Contact Message.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method
}
