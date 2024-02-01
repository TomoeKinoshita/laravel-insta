<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    //
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function index(Request $request){

        if($request->search){

            // all users ordered by name (->orderBy('name')->()get;)
            $all_users = $this->user->orderBy('name')->withTrashed()
                                    ->where('name', 'LIKE', '%'.$request->search.'%')->paginate(10);

            //get() - return all data
            //paginate(n) - return n number of data
            //今はuser少ししかないので仮にpaginate()を1として書いた。okだったので10に直した
            //withTrashed() - include soft-deleted records in the list

        }else{
            $all_users = $this->user->orderBy('name')->withTrashed()->paginate(10);
        }

        return view('admin.users.index')->with('all_users', $all_users)
                                        ->with('search', $request->search);
    }


    public function deactivate($id){
        $this->user->destroy($id);
            //looks like normal delete when you have added soft delete on the table.

        return redirect()->back();
    }

    public function activate($id){
        // activate or restore a foft-deleted record
        $this->user->onlyTrashed()->findOrFail($id)->restore();
        // onlyTrash - get only inactive records
        // restore() - restores inactive record

        return redirect()->back();
    }
}
