<?php

namespace App\Http\Controllers\FolderDivision;

use App\Models\User;
use App\Mail\SendEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\FolderDivision\BoxNumber;
use Illuminate\Support\Facades\Validator;
use App\Models\FolderDivision\FolderDivision;
use App\Models\FolderDivision\FolderItemFile;

class FolderDivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auth = auth()->user();

        // $folders = FolderDivision::with('ancestors')->latest()->get();
        // Only get root folders (folders without a parent)
        $folderQuery = FolderDivision::whereIsRoot()->with('ancestors')->latest();
        $folderFilesQuery = FolderItemFile::latest();

        if (Auth::user()->hasRole('super-admin')) {
            $folders = $folderQuery->get();
            $folderFiles = $folderFilesQuery->get();
            $notifications = $folderFilesQuery->whereNotNull('notification')->get();

        }
        //  elseif (Gate::allows('admin')) {
        //     $folders = $folderQuery->where('company_id', $auth->company_id)->get();
        //     $folderFiles = $folderFilesQuery->where('company_id', $auth->company_id)->get();
        // }
        else {
            $folders = $folderQuery->where('company_id', $auth->company_id)->where('division_id', $auth->division_id)->get();
            $folderFiles = $folderFilesQuery->where('company_id', $auth->company_id)->where('division_id', $auth->division_id)->get();
            $notifications = $folderFilesQuery->whereNotNull('notification')->where('company_id', $auth->company_id)->where('division_id', $auth->division_id)->get();
        }


        // dd($folders);

        return view('pages.folder-division.index', compact('folders', 'folderFiles', 'notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Custom validation messages
        $messages = [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'description.max' => 'The description may not be greater than 255 characters.',
            'parent.exists' => 'The selected parent folder is invalid.',
        ];
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'parent' => 'nullable|exists:folder_divisions,id', // Ensure the parent exists if provided
        ], $messages);

        // Check if validation fails
        if ($validator->fails()) {
            // Get the error messages
            $errors = $validator->errors()->all();

            // Display errors using SweetAlert
            // alert()->error('Validation Error', implode('<br>', $errors));

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $auth = auth()->user();

        $folders = FolderDivision::create([
            'company_id' => $auth->company_id,
            'division_id' => $auth->division_id,
            'name' => $request->name,
            'description' => $request->description,
            'is_lock' => 0,
        ]);

        if ($request->parent && $request->parent !== 'none') {
            $node = FolderDivision::find($request->parent);
            $node->appendNode($folders);
        }

        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the folder
        $folders = FolderDivision::findOrFail($id);
        $allFolders = FolderDivision::where('company_id', auth()->user()->company_id)
            ->where('division_id', auth()->user()->division_id)
            ->orderBy('created_at', 'desc')->get();

        // Load only direct children (not all descendants)
        $descendants = $folders->children()->get();

        // Load ancestors for breadcrumbs
        $ancestors = $folders->ancestors()->get();

        $files = FolderItemFile::where('folder_division_id', $folders->id)->latest()->get();
        // if ($folders->parent_id != null) {
        //     abort(404, 'Folder not found or is not a root folder');
        // }
        return view('pages.folder-division.show', compact('folders', 'allFolders', 'descendants', 'ancestors', 'files'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FolderDivision $folderDivision)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Custom validation messages
        $messages = [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name may not be greater than 255 characters.',
        ];

        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ], $messages);

        // Check if validation fails
        if ($validator->fails()) {
            // Get the error messages
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Retrieve the validated input data
        $data = $validator->validated();

        // Find the folder division by ID
        $folderDivision = FolderDivision::findOrFail($id);

        // Update the folder division with validated data
        $folderDivision->update($data);

        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $folder = FolderDivision::findOrFail($id);
        $folder->delete();

        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }

    public function form_upload(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;

            $row = FolderDivision::findOrFail($id);
            $users = User::
                where('company_id', auth()->user()->company_id)
                ->whereDoesntHave('roles', function ($query) {
                    $query->whereIn('name', ['super-admin',]);
                })
                ->where('email', '!=', auth()->user()->email)
                ->orderBy('name', 'asc')->get();

            $boxNumbers = BoxNumber::where('company_id', Auth::user()->company_id)->latest()->get();


            // Dapatkan tanggal hari ini
            $date = now()->format('Ymd');

            // Ambil nomor terakhir yang dibuat hari ini
            $latestFile = DB::table('folder_item_files')
                ->whereDate('created_at', now()->toDateString())
                ->latest('id')
                ->first();

            // Tentukan nomor urut berikutnya
            $number = $latestFile ? ((int) substr($latestFile->file_number, -4)) + 1 : 1;

            // Formatkan nomor file
            $fileNumber = 'FILE-'.$date.'-'.str_pad($number, 4, '0', STR_PAD_LEFT);

            $data = [
                'id' => $row['id'],
                'users' => $users,
                'boxNumbers' => $boxNumbers,
                'fileNumber' => $fileNumber,
            ];

            $msg = [
                'data' => view('pages.folder-division.upload_file', $data)->render(),
            ];

            return response()->json($msg);
        }
    }

    public function upload(Request $request)
    {
        // $attach = $request->all();

        // dd($attach);

        // Custom validation messages
        $messages = [
            'required' => 'The :attribute field is required.',
            'max' => [
                'file' => 'Maximum file size to upload is 50MB.',
                'string' => ':attribute terlalu panjang (maks 250 karakter).',
            ],
            'unique' => ':attribute already been used.',
            'email' => ':attribute tidak sesuai, Masukan Email dengan benar.',
        ];
        // Validation rules
        $validator = Validator::make($request->all(), [
            'number_box_id' => 'required', // Ensure the parent exists if provided
            'number' => 'nullable', // Ensure the parent exists if provided
            'email' => 'email', // Ensure the parent exists if provided
            'date' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'file.*' => 'required|max:51200', //50MB,
            'email_cc' => 'nullable',
            // 'attach_file' => 'boolean',
            // 'email_cc' => 'nullable|array',
            // 'email_cc.*' => 'nullable|email',
        ], $messages);

        // Check if validation fails
        if ($validator->fails()) {
            // Get the error messages
            $errors = $validator->errors()->all();

            // Display errors using SweetAlert
            // alert()->error('Validation Error', implode('<br>', $errors));

            return redirect()->back()->withErrors($validator)->withInput();
        }


        $auth = auth()->user();
        $folder = FolderDivision::find($request->id);

        $companyName = $auth->company->name ?? 'admin';
        $divisionCode = $auth->division->code ?? 'admin';

        // dd([$divisionName, $companyName]);

        $ancestors = $folder->ancestors()->get();

        $path = 'file-folder/'.$companyName.'/'.$divisionCode;

        foreach ($ancestors as $ancestor) {
            $path .= '/'.$ancestor->name;
        }
        $path .= '/'.$folder->name;

        $disk_root = config('filesystems.disks.public_local.root');
        if (! file_exists($disk_root) || ! is_dir($disk_root)) {
            return redirect()->back()->withInput()->with('success', 'Data has been created successfully!');
        }

        $files = [];
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $image) {
                $file = $image->getClientOriginalName();
                $basename = pathinfo($file, PATHINFO_FILENAME).'-'.Str::random(3);
                $ext = $image->getClientOriginalExtension();
                $fullname = $basename.'.'.$ext;
                $storedFile = $image->storeAs($path, $fullname, 'public_local');
                $files[] = $storedFile;
            }
        }

        // $emailCC = $request->email_cc ? implode(',', $request->email_cc) : null;

        // dd($emailCC);

        foreach ($files as $file) {
            FolderItemFile::create([
                'folder_division_id' => $request->id,
                'division_id' => $auth->division_id,
                'company_id' => $auth->company_id,
                'box_number_id' => $request->box_number_id,
                // 'folder_item_id' => $folderItem->id,
                'number' => $request->number,
                'file_number' => $request->file_number,
                'date' => $request->date,
                'description' => $request->description,
                'tag' => $request->tag,
                'file' => $file,
                'notification' => $request->notification,
                'date_notification' => $request->date_notification,
                // 'email' => $request->email,
                'email' => auth()->user()->email,
                // 'email_cc' => $emailCC,
                'email_cc' => $request->email_cc,
                'attach_file' => $request->attach_file,
            ]);
        }

        return redirect()->back()->with('success', 'Data has been uploaded successfully!');
    }

    public function delete_file($id)
    {
        $folderFile = FolderItemFile::find($id);
        $file = $folderFile->file;

        // $path_file = $file['file'];

        if ($file) {
            // Extract the original file name and extension
            $originalName = pathinfo($file, PATHINFO_FILENAME);
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $checkedName = "(deleted) ".$originalName.'.'.$ext;

            // Define the new file path
            $newPath = dirname($file).'/'.$checkedName;

            // Rename the file in the storage
            if (Storage::disk('public_local')->exists($file)) {
                Storage::disk('public_local')->move($file, $newPath);
            }

            // Update the folderFile record with the new name
            $folderFile->file = $newPath;
            $folderFile->update();
        }

        // find old photo
        // $path_file = $file['file'];

        // delete file
        // if ($path_file != null || $path_file != '') {
        //     Storage::delete($path_file);
        // }

        $folderFile->delete();

        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }

    public function lockFolder($id)
    {
        $folderDivision = FolderDivision::find($id);
        if ($folderDivision) { // Check if the record exists
            if ($folderDivision->is_lock) { // Check if is_lock is true
                $folderDivision->is_lock = false;
                // alert()->success('Success', 'Folder Terbuka!');
            } else { // Implicit check for is_lock being false
                $folderDivision->is_lock = true;
                // alert()->success('Success', 'Folder Terkunci!');
            }
        } else {
            return redirect()->back()->with('error', 'Failed, please try again.');
        }
        // dd($folderDivision->is_lock);
        $folderDivision->save();

        return redirect()->back()->with(
            'success',
            $folderDivision->is_lock ? 'Folder Terkunci!' : 'Folder Terbuka!'
        );
    }
    public function lockFolderFile($id)
    {
        $folderFile = FolderItemFile::find($id);
        // if ($folderFile) { // Check if the record exists
        //     if ($folderFile->is_lock) { // Check if is_lock is true
        //         $folderFile->is_lock = false;
        //         alert()->success('Success', 'File Terbuka!');
        //     } else { // Implicit check for is_lock being false
        //         $folderFile->is_lock = true;
        //         alert()->success('Success', 'File Terkunci!');
        //     }
        // } else {
        //     alert()->error('Error', 'Gagal Melakukan Eksekusi!');
        //     return redirect()->back();
        // }
        // // dd($folderFile->is_lock);
        // $folderFile->save();

        // return redirect()->back();

        if ($folderFile) {
            if ($folderFile->is_lock) {
                $folderFile->is_lock = false;
            } else {
                $folderFile->is_lock = true;
            }
        } else {
            return redirect()->back()->with('error', 'Failed, please try again.');
        }
        // dd($folderFile->is_lock);
        $folderFile->save();

        return redirect()->back()->with(
            'success',
            $folderFile->is_lock ? 'Folder Terkunci!' : 'Folder Terbuka!'
        );
    }

    public function moveFile($id, Request $request)
    {
        $destinationFolder = $request->folderId;
        // dd($destinationFolder);
        $file = FolderItemFile::find($id);
        if ($destinationFolder) {

            $file->folder_division_id = $destinationFolder;
            $file->update();
            return redirect()->back()->with('success', 'Data has been moved successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed, please try again.');

        }
        // dd($file->is_lock);
        // return redirect()->back();
        // $file->save();

    }

    // public function sendMails()
    // {
    //     $folderFiles = FolderItemFile::whereNotNull('notification')->whereDate('date_notification', today())->get();

    //     foreach ($folderFiles as $file) {
    //         $ccRecipients = array_filter(explode(',', $file->email_cc));

    //         $email = Mail::to($file->email);

    //         if (! empty($ccRecipients)) {
    //             $email->cc($ccRecipients);
    //         }

    //         $email->send(new SendEmail([
    //             'title' => $file->notification,
    //             'body' => $file->description,
    //         ]));
    //     }

    // }
}