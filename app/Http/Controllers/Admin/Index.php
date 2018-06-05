<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Permission;
use App\Repositories\Eloquent\AdminRepository;
use App\Repositories\Eloquent\MenuRepository;

class Index extends Controller
{
    protected $admin;
	protected $menu;
	public function __construct(AdminRepository  $admin , MenuRepository $menu){
		
        $this->admin = $admin;
		$this->menu = $menu;
	}
    //
    public function index()
    {
        // dd(auth()->user()->can('/admin/goods'));
    	// dd($this->admin->findBy(1)->toArray());
        $roles = auth()->user()->roles();
        
        // dd($roles->get());
        $roleName = [];
        if (!empty($roles->get())) {
            foreach ($roles->get() as $k => $role) {
                
                $roleName[$k] = $role->display_name;
                 
            }
        }
        
        
        //获取菜单
        $leftMenusList = $this->menu->getMenuList();
        
    	return view('admin.index.index' , ['roleName'=>$roleName , 'leftMenusList' => $leftMenusList]);
    }
    public function info()
    {
    	return view('admin.index.info');
    }
}
