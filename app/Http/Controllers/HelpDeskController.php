<?php
namespace App\Http\Controllers;

use App\HelpDesk;
use App\Mail\SendTicketReplay;
use App\Mail\SendTicketToAdmin;
use App\Mail\SendTicketToUser;
use App\Notifications\SendTicket;
use App\Notifications\SendTicketStatus;
use App\User;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Image;
use Mail;



class HelpDeskController extends Controller
{
    public function get()
    {
        require_once 'price.php';
        return view('front.helpdesk.get', compact('conversion_rate'));
    }

    public function store(Request $request)
    {
        $request->validate(['issue_title' => 'required|min:6', 'issue' => 'required|max:5000', 'image' => 'mimes:png,jpeg,jpg,bmp,gif']);

        $hd = new HelpDesk;
        $hd->ticket_no = mt_rand(10, 100000);
        $hd->issue_title = $request->issue_title;
        $hd->issue = clean($request->issue);
        $hd->user_id = Auth::user()->id;
        $hd->status = "open";

        if ($file = $request->file('image')) {

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/helpDesk/';
            $image = time() . $file->getClientOriginalName();
            $optimizeImage->resize(600, 600, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $image, 72);

            $hd->image = $image;

        }

        $get_user_email = User::find($hd->user_id)->email;
        $get_user_name = User::find($hd->user_id)->name;

        $hd->save();

        $get_admins = User::where('role_id', '=', 'a')->get();

        /*Sending notifcation to admins*/
        \Notification::send($get_admins, new SendTicket($hd));

        /*Mail*/

        foreach ($get_admins as $admin) {
            try {
                Mail::to($admin->email)->send(new SendTicketToAdmin($hd, $get_user_name));
            } catch (\Swift_TransportException $e) {

            }
        }

        try {
            Mail::to($get_user_email)->send(new SendTicketToUser($hd));
        } catch (\Swift_TransportException $e) {

        }

        notify()->success(__('Ticket has been created ! You can view status of your ticket under MyAccount'));
        return back();
    }

    public function userticket()
    {
        require_once 'price.php';
        return view('user.myticket', compact('conversion_rate'));
    }

    public function viewbyadmin(Request $request)
    {
        abort_if(!auth()->user()->can('support-ticket.manage'),403,__('User does not have the right permissions.'));

        $data = \DB::table('help_desks')->join('users', 'users.id', '=', 'help_desks.user_id')
            ->select('help_desks.ticket_no as ticket', 'help_desks.issue_title as title', 'help_desks.status as status', 'users.name as username')
            ->get();

        if ($request->ajax()) {
            return DataTables::of($data)->addIndexColumn()->addColumn('ticketno', function ($row) {
                $btn = '<p class="badge badge-info">' . $row->ticket . '</p>';
                return $btn;
            })->addColumn('title', function ($row) {
                return $row->title;
            })->addColumn('from', function ($row) {
                return $row->username;
            })->addColumn('status', function ($row) {

                if ($row->status == "open") {
                    $btn = '<p class="badge badge-info"><i class="feather icon-volume-2" aria-hidden="true"></i>' . ucfirst($row->status) . '</p>';
                } elseif ($row->status == "pending") {
                    $btn = '<p class="badge badge-default"><i class="fa fa-clock-o mr-1"></i>' . ucfirst($row->status) . '</p>';
                } elseif ($row->status == "closed") {
                    $btn = '<p class="badge badge-danger"><i class="fa fa-ban mr-1"></i>' . ucfirst($row->status) . '</p>';
                } elseif ($row->status == "solved") {
                    $btn = '<p class="badge badge-success"><i class="fa fa-check mr-1"></i>' . ucfirst($row->status) . '</p>';
                }

                return $btn;
            })->editColumn('view', function ($row) {
                $btn = '<a href=' . url("admin/ticket/" . $row->ticket) . ' class="btn btn-primary-rgba rounded"><i class="feather icon-eye"></i></a>';

                return $btn;
            })->rawColumns(['ticketno', 'title', 'from', 'status', 'view'])
                ->make(true);
        }

        return view('admin.ticket.index');
    }

    public function updateTicket(Request $request, $id)
    {
        abort_if(!auth()->user()->can('support-ticket.manage'),403,__('User does not have the right permissions.'));
        
        $status = $request->ticketstatus;

        $ticket = HelpDesk::findorfail($id);

        $update = HelpDesk::where('id', '=', $id)->update(['status' => $status]);

        $data1 = "Your Ticket Status has been changed to " . $status;

        $data2 = $ticket->ticket_no;

        User::find($ticket->user_id)
            ->notify(new SendTicketStatus($data1, $data2));

        return 'Ticket status has been changed to ' . ucfirst($status);

    }

    public function show($id)
    {
        abort_if(!auth()->user()->can('support-ticket.manage'),403,__('User does not have the right permissions.'));
        
        $ticket = HelpDesk::where('ticket_no', '=', $id)->first();

        return view('admin.ticket.show', compact('ticket'));
    }

    public function replay(Request $request, $id)
    {
        abort_if(!auth()->user()->can('support-ticket.manage'),403,__('User does not have the right permissions.'));

        $hd = HelpDesk::where('ticket_no', '=', $id)->first();
        $newmsg = clean($request->msg);
        $get_user_email = User::find($hd->user_id)->email;

        try {
            Mail::to($get_user_email)->send(new SendTicketReplay($hd, $newmsg));
        } catch (\Exception $e) {

        }

        notify()->success(__('Reply sent !'));

        return back();
    }
}
