<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLeave;
use App\Models\AdminPermission;
use App\Models\AdminRole;
use App\Models\AdminSign;
use App\Models\AdminSignApply;
use App\Models\DateSet;
use App\Models\TimeSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator, DB, Date, Excel;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.admin:admin');
    }

    //公用页面
    public function index()
    {
//        $user = Auth::guard('admin')->user();
//        if ($user->hasRole('admin123')) {
//            dd(123);
//        } else {
//            dd(456);
//        }
        return view('admin/index');
    }

    //签到
    public function adminSignIn()
    {
        $admin_id = Auth::guard('admin')->user()->id;
        $now = Date::now();
        $now_date = $now->format('Y-m-d');
        $now_month = $now->format('m');
        $now_time = $now->format('H:i:s');
        if ($this->_adminSignCheck($admin_id, $now_date, 1)) {
            return $this->resp(10000, '您已签到');
        }
        $set_start_time = TimeSet::where('set_month', $now_month)->pluck('set_start_time')->first();
        if ($now_time <= $set_start_time) {
            AdminSign::create(['admin_id' => $admin_id, 'sign_time' => $now, 'sign_type' => 1]);
            return $this->resp(0, '签到成功');
        }
        AdminSign::create(['admin_id' => $admin_id, 'sign_time' => $now, 'sign_type' => 1,
            'sign_status' => 0]);
        return $this->resp(0, '签到成功');
    }

    //签退
    public function adminSignOut()
    {
        $admin_id = Auth::guard('admin')->user()->id;
        $now = Date::now();
        $now_date = $now->format('Y-m-d');
        $now_month = $now->format('m');
        $now_time = $now->format('H:i:s');
        $set_end_time = TimeSet::where('set_month', $now_month)->pluck('set_end_time')->first();
        if ($now_time >= $set_end_time) {
            $sign_status = 1;
        } else {
            $sign_status = 0;
        }
        $sign_id = $this->_adminSignCheck($admin_id, $now_date, 2);
        if ($sign_id) {
            AdminSign::where('id', $sign_id)->update(['sign_time' => $now, 'sign_status' => $sign_status]);
            return $this->resp(0, '签退成功');
        }
        AdminSign::create(['admin_id' => $admin_id, 'sign_time' => $now, 'sign_type' => 2,
            'sign_status' => $sign_status]);
        return $this->resp(0, '签退成功');
    }

    //签到签退判断
    private function _adminSignCheck($admin_id, $date, $sign_type)
    {
        $rs = AdminSign::where('admin_id', $admin_id)
            ->whereDate('sign_time', $date)
            ->where('sign_type', $sign_type)->first();
        if ($rs) {
            return $rs->id;
        } else {
            return 0;
        }
    }

    //我的考勤
    public function mysign()
    {
        return view('admin/mysign');
    }

    //请假
    public function adminAskForLeave(Request $request)
    {
        $rule = [
            'leave_start_time' => 'required|date_format:Y-m-d H:i:s',
            'leave_end_time' => 'required|date_format:Y-m-d H:i:s|after:leave_start_time',
            'leave_type' => 'required|integer|between:1,5',//请假类型：1-调休，2-事假，3-病假，4-出差，5-下现场
            'leave_reason' => 'required'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $admin_id = Auth::guard('admin')->user()->id;
        $leave_start_time = $request->leave_start_time;
        $leave_end_time = $request->leave_end_time;
        $tmp = AdminLeave::where('admin_id', $admin_id)
            ->where('leave_status', 1)
            ->where(function ($query) use ($leave_start_time, $leave_end_time) {
                $query->orWhere('leave_end_time', '<', $leave_start_time)
                    ->orWhere('leave_start_time', '>', $leave_end_time);
            })
            ->first();
        if (!$tmp) {
            return $this->resp(10000, '您提交的请假时间与已准假时间冲突，请核实修改后重新提交提交');
        }
        $tmp_start_time = Date::parse($leave_start_time)->format('Y-m-d');
        $tmp_end_time = Date::parse($leave_end_time)->format('Y-m-d');
        while ($tmp_start_time <= $tmp_end_time) {
            $tmp = DateSet::where('set_date', $tmp_start_time)->first();
            if ($tmp) {
                return $this->resp(10000, '您请假的时间包含休息天，请重新选择时间！');
            }
            $tmp_start_time = Date::parse($tmp_start_time)->add('+1 day')->format('Y-m-d');
        }
        AdminLeave::create(['admin_id' => $admin_id, 'submit_time' => Date::now(),
            'leave_start_time' => $leave_start_time, 'leave_end_time' => $leave_end_time,
            'leave_type' => $request->leave_type, 'leave_reason' => $request->leave_reason]);
        return $this->resp(0, '提交成功');
    }

    //补签
    public function adminSignApply(Request $request)
    {
        $rule = [
            'sign_apply_date' => 'required|date_format:Y-m-d',
            'sign_apply_type' => 'required|integer|between:1,2',//补签类型：1-补到签，2-补退签
            'sign_apply_reason' => 'required'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $admin_id = Auth::guard('admin')->user()->id;
        AdminSignApply::updateOrCreate(['admin_id' => $admin_id, 'sign_apply_date' => $request->sign_apply_date,
            'sign_apply_type' => $request->sign_apply_type, 'sign_apply_status' => 2],
            ['submit_time' => Date::now(), 'sign_apply_reason' => $request->sign_apply_reason]);
        return $this->resp(0, '提交成功');
    }

    //获取我的考勤
    public function getMySign(Request $request)
    {
        $admin_id = Auth::guard('admin')->user()->id;
        $rule = [
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $tmp_end_date = $request->end_date;
        $now_date = Date::now()->add('+1 day')->format('Y-m-d');
        if ($end_date > $now_date) {
            $end_date = $now_date;
        }
        //日期设置信息
        $set_data = DateSet::select()
            ->whereDate('set_date', '>=', $start_date)
            ->whereDate('set_date', '<', $end_date)->get();
        //签到信息
        $sign = AdminSign::select('*', DB::raw("DATE_FORMAT(sign_time,'%Y-%m-%d') as sign_date,DATE_FORMAT(sign_time,'%H:%i:%s') as sign_hour"))
            ->whereDate('sign_time', '>=', $start_date)
            ->whereDate('sign_time', '<', $end_date)
            ->where('admin_id', $admin_id)->get();
        //请假信息
        $leave = AdminLeave::select()
            ->where(function ($query) use ($start_date, $tmp_end_date) {
                $query->orWhere(function ($query) use ($start_date, $tmp_end_date) {
                    $query->whereDate('leave_start_time', '>=', $start_date)
                        ->whereDate('leave_start_time', '<', $tmp_end_date);
                })->orWhere(function ($query) use ($start_date, $tmp_end_date) {
                    $query->whereDate('leave_end_time', '>', $start_date)
                        ->whereDate('leave_end_time', '<=', $tmp_end_date);
                });
            })
            ->where('admin_id', $admin_id)->get();
        //补签信息
        $sign_apply = AdminSignApply::select()
            ->whereDate('sign_apply_date', '>=', $start_date)
            ->whereDate('sign_apply_date', '<', $end_date)
            ->where('admin_id', $admin_id)->get();
        //获取每天结果
        $arr = array();
        while ($start_date < $end_date) {
            $arr = array_merge($arr, $this->_getDaySignInfo($start_date, $set_data, $sign, $sign_apply, $leave));
            $start_date = Date::parse($start_date)->add('+1 day')->format('Y-m-d');
        }
        return $this->resp(0, $arr);
    }

    //获取某天休或班信息
    private function _getSetDateInfo($date, $set_date)
    {
        $rs = $set_date->where('set_date', $date)->first();
        if ($rs) {
            $tmp['start'] = $date;
            $tmp['title'] = '休';
            $tmp['className'] = 'bg-success';
            $tmp['type'] = 0;
        } else {
            $tmp['start'] = $date;
            $tmp['title'] = '班';
            $tmp['className'] = 'bg-info';
            $tmp['type'] = 1;
        }
        $tmp['order'] = 1;
        return $tmp;
    }

    //获取某天补签信息
    private function _getSignApplyInfo($date, $sign_type, $sign_apply)
    {
        //3-无签到信息，2-补签信息待审核，1-补签信息通过，0-补签信息驳回
        //1-签到，2-签退
        if (!$sign_apply->isEmpty()) {
            $rs = $sign_apply->where('sign_apply_date', $date);
            if (!$rs->isEmpty()) {
                $tmp = $rs->where('sign_apply_type', $sign_type);
                if (!$tmp->isEmpty()) {
                    return $tmp->pluck('sign_apply_status')->last();
                }
                return 3;
            }
            return 3;
        }
        return 3;
    }

    //获某天签到信息
    private function _getSignInInfo($date, $sign, $className, $sign_apply)
    {
        $tmp1 = $this->_getSignApplyInfo($date, 1, $sign_apply);
        switch ($tmp1) {
            case 0:
                $sign_apply_title = '补签驳回';
                $tmp['apply_reason'] = $sign_apply->where('sign_apply_date', $date)
                    ->where('sign_apply_type', 1)
                    ->pluck('sign_apply_reason')->last();
                break;
            case 1:
                $sign_apply_title = '已补签';
                break;
            case 2:
                $sign_apply_title = '补签待审';
                $tmp['apply_reason'] = $sign_apply->where('sign_apply_date', $date)
                    ->where('sign_apply_type', 1)
                    ->pluck('sign_apply_reason')->last();
                break;
            default:
                $sign_apply_title = null;
        }
        $rs = $sign->where('sign_date', $date)->where('sign_type', 1)->first();
        if ($rs) {
            $tmp['start'] = $date;
            if ($rs->sign_status) {
                $tmp['title'] = '已签到 ' . $rs->sign_hour;
                $tmp['className'] = $className ?: 'bg-info';
            } else {
                $tmp['title'] = $className ? '已签到 ' . $rs->sign_hour : '迟到 ' . $rs->sign_hour . ' ' . $sign_apply_title;
                if ($tmp1 == 1) {
                    $tmp['className'] = $className ?: 'bg-info';
                } else {
                    $tmp['className'] = $className ?: 'bg-warning';
                }
            }
        } else {
            $tmp['start'] = $date;
            $tmp['title'] = '未签到 ' . $sign_apply_title;
            if ($tmp1 == 1) {
                $tmp['className'] = $className ?: 'bg-info';
            } else {
                $tmp['className'] = $className ?: 'bg-danger';
            }
        }
        $tmp['order'] = 2;
        return $tmp;
    }

    //获某天签退信息
    private function _getSignOutInfo($date, $sign, $className, $sign_apply)
    {
        $tmp1 = $this->_getSignApplyInfo($date, 2, $sign_apply);
        switch ($tmp1) {
            case 0:
                $sign_apply_title = '补签驳回';
                $tmp['apply_reason'] = $sign_apply->where('sign_apply_date', $date)
                    ->where('sign_apply_type', 2)
                    ->pluck('sign_apply_reason')->last();
                break;
            case 1:
                $sign_apply_title = '已补签';
                break;
            case 2:
                $sign_apply_title = '补签待审';
                $tmp['apply_reason'] = $sign_apply->where('sign_apply_date', $date)
                    ->where('sign_apply_type', 2)
                    ->pluck('sign_apply_reason')->last();
                break;
            default:
                $sign_apply_title = null;
        }
        $rs = $sign->where('sign_date', $date)->where('sign_type', 2)->first();
        if ($rs) {
            $tmp['start'] = $date;
            if ($rs->sign_status) {
                $tmp['title'] = '已签退 ' . $rs->sign_hour;
                $tmp['className'] = $className ?: 'bg-info';
            } else {
                $tmp['title'] = $className ? '已签退 ' . $rs->sign_hour : '早退 ' . $rs->sign_hour . ' ' . $sign_apply_title;
                if ($tmp1 == 1) {
                    $tmp['className'] = $className ?: 'bg-info';
                } else {
                    $tmp['className'] = $className ?: 'bg-warning';
                }
            }
        } else {
            $tmp['start'] = $date;
            $tmp['title'] = '未签退 ' . $sign_apply_title;
            if ($tmp1 == 1) {
                $tmp['className'] = $className ?: 'bg-info';
            } else {
                $tmp['className'] = $className ?: 'bg-danger';
            }
        }
        $tmp['order'] = 3;
        return $tmp;
    }

    //获取某天请假信息
    private function _getLeaveInfo($date, $leave)
    {
        //0-无请假信息，1-调休，2-事假，3-病假，4-出差，5-下现场
        if (!$leave->isEmpty()) {
            $rs = $leave->reject(function ($v) use ($date) {
                $start = Date::parse($v['leave_start_time'])->format('Y-m-d');
                $stop = Date::parse($v['leave_end_time'])->format('Y-m-d');
                if ($date < $start || $date > $stop) {
                    return $v;
                }
            })->values()->last();
            if ($rs) {
                $tmp['start'] = $date;
                switch ($rs->leave_status) {
                    case 0:
                        $leave_status = '驳回';
                        break;
                    case 2:
                        $leave_status = '待审';
                        break;
                    default:
                        $leave_status = null;
                }
                switch ($rs->leave_type) {
                    case 1:
                        $tmp['title'] = '调休' . $leave_status;
                        break;
                    case 2:
                        $tmp['title'] = '事假' . $leave_status;
                        break;
                    case 3:
                        $tmp['title'] = '病假' . $leave_status;
                        break;
                    case 4:
                        $tmp['title'] = '出差' . $leave_status;
                        break;
                    case 5:
                        $tmp['title'] = '下现场' . $leave_status;
                        break;
                    default:
                        $tmp['title'] = '请假';
                }
                $tmp['className'] = 'bg-primary';
                $tmp['order'] = 4;
                $tmp['leave_info'] = $rs;
                return $tmp;
            }
            return 0;
        }
        return 0;
    }

    //获取每天考勤结果
    private function _getDaySignInfo($date, $set_date, $sign, $sign_apply, $leave)
    {
        $arr = array();
        //获取休息天信息
        $arr[] = $this->_getSetDateInfo($date, $set_date);
        if ($arr[0]['type']) {
            $className = null;
            //获取请假信息
            $rs = $this->_getLeaveInfo($date, $leave);
            $rs && $arr[] = $rs;
        } else {
            $className = 'bg-success';
        }
        //获取签到信息
        $arr[] = $this->_getSignInInfo($date, $sign, $className, $sign_apply);
        //获取签退信息
        $arr[] = $this->_getSignOutInfo($date, $sign, $className, $sign_apply);
        return $arr;
    }

    /*******日期事件视图*******/
    public function dateset()
    {
        $data['time_set'] = TimeSet::get();
        return view('admin/dateset', ['data' => $data]);
    }

    //获取日期事件
    public function getDateEvent(Request $request)
    {
        $rule = [
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $rs = DateSet::select()->where('set_date', '>=', $request->start_date)
            ->where('set_date', '<', $request->end_date)->get();
        return $this->resp(0, $rs);
    }

    //设置日期事件
    public function setDateEvent(Request $request)
    {
        $rule = [
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        return DB::transaction(function () use ($request) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            while ($start_date < $end_date) {
                DateSet::updateOrCreate(['set_date' => $start_date]);
                $start_date = Date::parse($start_date)->add('+1 day')->format('Y-m-d');
            }
            return $this->resp(0, '设置成功');
        });
    }

    //删除日期事件
    public function delDateEvent(Request $request)
    {
        $rule = [
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        return DB::transaction(function () use ($request) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            if ($start_date == $end_date) {
                DateSet::where('set_date', $start_date)->delete();
            } else {
                while ($start_date < $end_date) {
                    DateSet::where('set_date', $start_date)->delete();
                    $start_date = Date::parse($start_date)->add('+1 day')->format('Y-m-d');
                }
            }
            return $this->resp(0, '删除成功');
        });
    }

    //设置夏季工作时间
    public function setSummerTime(Request $request)
    {
        $rule = [
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        return DB::transaction(function () use ($request) {
            $start_time = $request->start_time;
            $end_time = $request->end_time;
            TimeSet::whereIn('set_month', ['06', '07', '08', '09'])
                ->update(['set_start_time' => $start_time, 'set_end_time' => $end_time]);
            return $this->resp(0, '设置成功');
        });
    }

    //设置冬季工作时间
    public function setWinterTime(Request $request)
    {
        $rule = [
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        return DB::transaction(function () use ($request) {
            $start_time = $request->start_time;
            $end_time = $request->end_time;
            TimeSet::whereNotIn('set_month', ['06', '07', '08', '09'])
                ->update(['set_start_time' => $start_time, 'set_end_time' => $end_time]);
            return $this->resp(0, '设置成功');
        });
    }

    /*******角色设置视图*******/
    public function roleset()
    {
        return view('admin/roleset');
    }

    //获取角色列表
    public function getRoleList(Request $request)
    {
        $rule = [
            'page' => 'integer',
            'item' => 'integer',
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $search = $request->search;
        $data = AdminRole::where(function ($q) use ($search) {
            $search &&
            $q->orWhere('admin_roles.name', 'like', '%' . $search . '%')
                ->orwhere('admin_roles.display_name', 'like', '%' . $search . '%')
                ->orwhere('admin_roles.description', 'like', '%' . $search . '%');
        })->orderBy('id', 'DESC')->paginate($request->item);
        return $this->resp(0, $data);
    }

    //删除角色
    public function delRole(Request $request)
    {
        $rule = [
            'role_id' => 'required|integer|exists:admin_roles,id'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $rs = AdminRole::where('id', $request->role_id)->delete();
        if ($rs) {
            return $this->resp(0, '删除成功');
        }
        return $this->resp(10000, '删除失败');
    }

    //添加角色
    public function addRole(Request $request)
    {
        $rule = [
            'role_name' => 'required|max:100|unique:admin_roles,name',
            'role_display_name' => 'required|max:50',
            'role_description' => 'required|max:100'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $rs = AdminRole::create(['name' => $request->role_name, 'display_name' => $request->role_display_name,
            'description' => $request->role_description]);
        if ($rs) {
            return $this->resp(0, '添加成功');
        }
        return $this->resp(10000, '添加失败');
    }

    //编辑角色
    public function editRole(Request $request)
    {
        $rule = [
            'role_id' => 'required|integer|exists:admin_roles,id',
            'role_name' => 'required|max:100|unique:admin_roles,name,' . $request->role_id,
            'role_display_name' => 'required|max:50',
            'role_description' => 'required|max:100'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $rs = AdminRole::where('id', $request->role_id)
            ->update(['name' => $request->role_name, 'display_name' => $request->role_display_name,
                'description' => $request->role_description]);
        if ($rs) {
            return $this->resp(0, '修改成功');
        }
        return $this->resp(10000, '修改失败');
    }

    //获取角色的权限
    public function getAdminPerms(Request $request)
    {
        $rule = [
            'role_id' => 'required|integer|exists:admin_roles,id'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $admin_perms = AdminRole::find($request->role_id)->perms;
        $data = AdminPermission::get()->map(function ($v) use ($admin_perms) {
            if ($admin_perms->where('id', $v['id'])->first()) {
                $v['prem_status'] = 1;
            } else {
                $v['prem_status'] = 0;
            }
            return $v;
        })->sortByDesc('prem_status')->values()->all();
        return $this->resp(0, $data);
    }

    //分配权限
    public function allotPrems(Request $request)
    {
        $rule = [
            'role_id' => 'required|integer|exists:admin_roles,id',
            'permission_id' => 'required|integer|exists:admin_permissions,id',
            'perm_allot_status' => 'required|integer|between:0,1'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $role = AdminRole::find($request->role_id);
        $perm_id = $request->permission_id;
        if ($request->perm_allot_status) {
            $role->attachPermissions([$perm_id]);
            return $this->resp(0, '分配权限成功');
        } else {
            $role->detachPermissions([$perm_id]);
            return $this->resp(0, '取消权限成功');
        }
    }

    /*******补签审核视图*******/
    public function signapplylist()
    {
        return view('admin/signapplylist');
    }

    //获取补签申请列表
    public function getSignApplyList(Request $request)
    {
        $rule = [
            'page' => 'integer',
            'item' => 'integer',
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $search = $request->search;
        $data = AdminSignApply::select('admininfo.name as realname', 'admin_sign_apply.*',
            'admin_sign_apply.sign_apply_type as sign_apply_type_name', 'approval.name as approval_name')
            ->leftjoin('admininfo', 'admininfo.admin_id', '=', 'admin_sign_apply.admin_id')
            ->leftjoin('admininfo as approval', 'approval.admin_id', '=', 'admin_sign_apply.sign_apply_approval')
            ->where(function ($q) use ($search) {
                $search &&
                $q->orWhere('admininfo.name', 'like', '%' . $search . '%')
                    ->orWhere('approval.name', 'like', '%' . $search . '%')
                    ->orWhere('admin_sign_apply.sign_apply_date', 'like', '%' . $search . '%');
            })
            ->orderBy('admin_sign_apply.sign_apply_status', 'DESC')
            ->orderBy('admin_sign_apply.sign_apply_date', 'DESC')
            ->paginate($request->item);
        return $this->resp(0, $data);
    }

    //审核补签申请
    public function checkSignApply(Request $request)
    {
        $rule = [
            'sign_apply_id' => 'required|integer|exists:admin_sign_apply,id',
            'approval_note' => 'required|max:200',
            'sign_apply_status' => 'required|integer|between:0,1'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $admin_id = Auth::guard('admin')->user()->id;
        $rs = AdminSignApply::where('id', $request->sign_apply_id)
            ->update(['sign_apply_approval' => $admin_id, 'approval_time' => Date::now(),
                'approval_note' => $request->approval_note, 'sign_apply_status' => $request->sign_apply_status]);
        if ($rs) {
            return $this->resp(0, '操作成功');
        }
        return $this->resp(10000, '操作失败');
    }

    /*******请假审核视图*******/
    public function leaveapplylist()
    {
        return view('admin/leaveapplylist');
    }

    //获取请假申请列表
    public function getLeaveApplyList(Request $request)
    {
        $rule = [
            'page' => 'integer',
            'item' => 'integer',
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $search = $request->search;
        $data = AdminLeave::select('admininfo.name as realname', 'admin_leave.*',
            'admin_leave.leave_type as leave_type_name', 'approval.name as approval_name')
            ->leftjoin('admininfo', 'admininfo.admin_id', '=', 'admin_leave.admin_id')
            ->leftjoin('admininfo as approval', 'approval.admin_id', '=', 'admin_leave.leave_approval')
            ->where(function ($q) use ($search) {
                $search &&
                $q->orWhere('admininfo.name', 'like', '%' . $search . '%')
                    ->orWhere('approval.name', 'like', '%' . $search . '%')
                    ->orWhere('admin_leave.submit_time', 'like', '%' . $search . '%');
            })
            ->orderBy('admin_leave.leave_status', 'DESC')
            ->orderBy('admin_leave.submit_time', 'DESC')
            ->paginate($request->item);
        return $this->resp(0, $data);
    }

    //审核请假申请
    public function checkLeaveApply(Request $request)
    {
        $rule = [
            'leave_id' => 'required|integer|exists:admin_leave,id',
            'approval_note' => 'required|max:200',
            'leave_status' => 'required|integer|between:0,1'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $admin_id = Auth::guard('admin')->user()->id;
        $rs = AdminLeave::where('id', $request->leave_id)
            ->update(['leave_approval' => $admin_id, 'approval_time' => Date::now(),
                'approval_note' => $request->approval_note, 'leave_status' => $request->leave_status]);
        if ($rs) {
            return $this->resp(0, '操作成功');
        }
        return $this->resp(10000, '操作失败');
    }

}
